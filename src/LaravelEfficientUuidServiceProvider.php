<?php

namespace Dyrynda\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Dyrynda\Database\Connection\MySqlConnection;
use Dyrynda\Database\Connection\SQLiteConnection;
use Dyrynda\Database\Connection\PostgresConnection;
use Dyrynda\Database\Exceptions\UnknownGrammarClass;

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

        Grammar::macro('typeEfficientUuid', function (Fluent $column) {
            $className = (new \ReflectionClass($this))->getShortName();

            if ($className === "MySqlGrammar") {
                return sprintf('binary(%d)', $column->length ?? 16);
            }

            if ($className === "PostgresGrammar") {
                return 'bytea';
            }

            if ($className === "SQLiteGrammar") {
                return 'blob(256)';
            }

            throw new UnknownGrammarClass();
        });


        Blueprint::macro('efficientUuid', function ($column): ColumnDefinition {
            /** @var Blueprint $this */
            return $this->addColumn('efficientUuid', $column);
        });
    }
}
