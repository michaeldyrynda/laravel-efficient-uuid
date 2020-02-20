<?php

namespace Dyrynda\Database\Schema\Grammars;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Grammars\PostgresGrammar as BasePostgresGrammar;

class PostgresGrammar extends BasePostgresGrammar
{
    /**
     * Create the column definition for a UUID type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     *
     * @return string
     */
    protected function typeEfficientUuid(Fluent $column)
    {
        return 'bytea';
    }
}
