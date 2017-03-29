<?php

namespace Dyrynda\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\MySqlGrammar as BaseMySqlGrammar;
use Illuminate\Support\Fluent;

class MySqlGrammar extends BaseMySqlGrammar
{
    /**
     * Create the column definition for a UUID type.
     *
     * @param  \Illuminate\Support\Fluent  $column
     *
     * @return string
     */
    protected function typeUuid(Fluent $column)
    {
        return sprintf('binary(16)');
    }
}
