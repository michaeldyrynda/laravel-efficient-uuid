<?php

namespace Tests;

use Dyrynda\Database\LaravelEfficientUuidServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(realpath(__DIR__.'/database/factories'));

        $this->setupDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelEfficientUuidServiceProvider::class,
        ];
    }

    protected function setupDatabase($app)
    {
        Schema::dropAllTables();

        $app['db']->connection()->getSchemaBuilder()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->efficientUuid('uuid');
            $table->efficientUuid('custom_uuid');
            $table->string('title');
        });
    }
}
