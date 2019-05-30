<?php

namespace Tests;

use Dyrynda\Database\Blueprint;
use Mockery as m;
use Orchestra\Testbench\TestCase;

class DatabaseMySqlSchemaGrammarTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testAddingUuid()
    {
        $blueprint = new Blueprint('users');
        $blueprint->uuid('foo');
        $blueprint->efficientUuid('bar');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertContains('alter table `users` add `foo` char(36) not null, add `bar` binary(16) not null', $statements);
    }

    protected function getConnection($connection = null)
    {
        return m::mock('Illuminate\Database\Connection');
    }

    public function getGrammar()
    {
        return new \Dyrynda\Database\Schema\Grammars\MySqlGrammar;
    }
}
