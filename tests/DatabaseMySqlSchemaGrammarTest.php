<?php

namespace Tests;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Mockery as m;
use Tests\Fixtures\EfficientUuidPost;

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

    public function testAddingUuidFor()
    {
        $blueprint = new Blueprint('users', function ($table) {
            $table->uuid('foo');
            $table->efficientUuidFor(EfficientUuidPost::class);
        });

        $connection = m::mock(Connection::class);

        $this->assertEquals(
            ['alter table `users` add `foo` char(36) not null, add `efficient_uuid_post_id` binary(16) not null'],
            $blueprint->toSql($connection, new MySqlGrammar)
        );
    }

    public function testAddingUuidForWithCustomColumn()
    {
        $blueprint = new Blueprint('users', function ($table) {
            $table->uuid('foo');
            $table->efficientUuidFor(EfficientUuidPost::class, 'bar');
        });

        $connection = m::mock(Connection::class);

        $this->assertEquals(
            ['alter table `users` add `foo` char(36) not null, add `bar` binary(16) not null'],
            $blueprint->toSql($connection, new MySqlGrammar)
        );
    }
}
