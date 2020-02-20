<?php

namespace Dyrynda\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\PostgresGrammar as BasePostgresGrammar;

class PostgresGrammar extends BasePostgresGrammar
{
    /**
     * Create the column definition for a UUID type.
     *
     * @return string
     */
    protected function typeEfficientUuid()
    {
        return 'bytea';
    }
}
