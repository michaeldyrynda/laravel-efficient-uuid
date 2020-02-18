<?php

namespace Tests;

use Mockery as m;
use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as DB;
use Dyrynda\Database\Schema\Grammars\MySqlGrammar;

class DatabaseMySqlSchemaGrammarTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testAddingUuid()
    {
        $blueprint = new Blueprint('users', function ($table) {
            $table->uuid('foo');
            $table->efficientUuid('bar');
        });

        $connection = m::mock(Connection::class);

        $this->assertEquals(
            ['alter table `users` add `foo` char(36) not null, add `bar` binary(16) not null'],
            $blueprint->toSql($connection, new MySqlGrammar)
        );
    }

    public function testChangingUuid()
    {
        app('db')->connection()->getSchemaBuilder()->create('users', function ($table) {
            $table->uuid('foo');
            $table->efficientUuid('bar');
        });

        $blueprint = new Blueprint('users', function ($table) {
            $table->efficientUuid('bar')->nullable(false)->change();
        });

        $expected = [
            'CREATE TEMPORARY TABLE __temp__users AS SELECT foo, bar FROM users',
            'DROP TABLE users',
            'CREATE TABLE users (foo VARCHAR(255) NOT NULL COLLATE BINARY, bar BLOB NOT NULL)',
            'INSERT INTO users (foo, bar) SELECT foo, bar FROM __temp__users',
            'DROP TABLE __temp__users',
        ];

        $this->assertEquals($expected, $blueprint->toSql(app('db')->connection(), new MySqlGrammar));
    }
}
