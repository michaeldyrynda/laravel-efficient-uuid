<?php

namespace Tests;

use Dyrynda\Database\Blueprint;
use Mockery as m;
use PHPUnit_Framework_TestCase;

class DatabaseMySqlSchemaGrammarTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testAddingUuid()
    {
        $blueprint = new Blueprint('users');
        $blueprint->uuid('foo');
        $statements = $blueprint->toSql($this->getConnection(), $this->getGrammar());

        $this->assertEquals(1, count($statements));
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
