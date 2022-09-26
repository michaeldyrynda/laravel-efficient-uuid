<?php

namespace Tests;

use Dyrynda\Database\Exceptions\UnknownGrammarClass;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\SqlServerGrammar;
use Mockery as m;
use Tests\Fixtures\EfficientUuidPost;

class DatabaseInvalidSchemaGrammarTest extends TestCase
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

        $this->expectExceptionObject(new UnknownGrammarClass());

        $blueprint->toSql($connection, new SqlServerGrammar);
    }

    public function testAddingUuidFor()
    {
        $blueprint = new Blueprint('users', function ($table) {
            $table->uuid('foo');
            $table->efficientUuidFor(EfficientUuidPost::class);
        });

        $connection = m::mock(Connection::class);

        $this->expectExceptionObject(new UnknownGrammarClass());

        $blueprint->toSql($connection, new SqlServerGrammar);
    }
}
