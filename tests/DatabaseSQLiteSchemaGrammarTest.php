<?php

namespace Tests;

use Mockery as m;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Dyrynda\Database\Schema\Grammars\SQLiteGrammar;

class DatabaseSQLiteSchemaGrammarTest extends TestCase
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
            ['alter table "users" add column "foo" varchar not null', 'alter table "users" add column "bar" blob(256) not null'],
            $blueprint->toSql($connection, new SQLiteGrammar)
        );
    }
}
