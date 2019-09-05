<?php

namespace Tests;

use Mockery as m;
use Dyrynda\Database\Blueprint;
use PHPUnit\Framework\TestCase;

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
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertCount(1, $statements);
        $this->assertEquals('alter table `users` add `foo` binary(16) not null', $statements[0]);
    }

    protected function getConnection()
    {
        return m::mock('Illuminate\Database\Connection');
    }

    public function getGrammar()
    {
        return new \Dyrynda\Database\Schema\Grammars\MySqlGrammar;
    }
}
