<?php

namespace Dyrynda\Database\Schema\Grammars;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Grammars\MySqlGrammar as BaseMySqlGrammar;

class MySqlGrammar extends BaseMySqlGrammar
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
        return sprintf('binary(%d)', $column->length ?? 16);
    }
}
