<?php

namespace Dyrynda\Database;

use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Dyrynda\Database\Connection\MySqlConnection;
use Dyrynda\Database\Connection\SQLiteConnection;
use Dyrynda\Database\Connection\PostgresConnection;

class LaravelEfficientUuidServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
            return new MySqlConnection($connection, $database, $prefix, $config);
        });

        Connection::resolverFor('postgres', function ($connection, $database, $prefix, $config) {
            return new PostgresConnection($connection, $database, $prefix, $config);
        });
        
        Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            return new SQLiteConnection($connection, $database, $prefix, $config);
        });

        Blueprint::macro('efficientUuid', function ($column) {
            return $this->addColumn('efficientUuid', $column);
        });
    }
}
