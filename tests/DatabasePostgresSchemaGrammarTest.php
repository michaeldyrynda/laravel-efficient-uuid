<?php

namespace Tests;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Mockery as m;
use Tests\Fixtures\EfficientUuidPost;

class DatabasePostgresSchemaGrammarTest extends TestCase
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
            ['alter table "users" add column "foo" uuid not null, add column "bar" bytea not null'],
            $blueprint->toSql($connection, new PostgresGrammar)
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
            ['alter table "users" add column "foo" uuid not null, add column "efficient_uuid_post_id" bytea not null'],
            $blueprint->toSql($connection, new PostgresGrammar)
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
            ['alter table "users" add column "foo" uuid not null, add column "bar" bytea not null'],
            $blueprint->toSql($connection, new PostgresGrammar)
        );
    }
}
