<?php

namespace Dyrynda\Database;

use Dyrynda\Database\Exceptions\UnknownGrammarClass;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;

class LaravelEfficientUuidServiceProvider extends ServiceProvider
{
    public function register()
    {
        Grammar::macro('typeEfficientUuid', function (Fluent $column) {
            switch (class_basename(static::class)) {
                case 'MySqlGrammar':
                    return sprintf('binary(%d)', $column->length ?? 16);

                case 'PostgresGrammar':
                    return 'bytea';

                case 'SQLiteGrammar':
                    return 'blob(256)';

                default:
                    throw new UnknownGrammarClass;
            }
        });

        Blueprint::macro('efficientUuid', function ($column): ColumnDefinition {
            /* @var Blueprint $this */
            return $this->addColumn('efficientUuid', $column);
        });
    }
}
