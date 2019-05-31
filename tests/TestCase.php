<?php

namespace Tests;

use Dyrynda\Database\LaravelEfficientUuidServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelEfficientUuidServiceProvider::class,
        ];
    }
}
