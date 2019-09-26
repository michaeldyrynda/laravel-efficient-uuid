<?php

namespace Dyrynda\Database\Connection;

use Dyrynda\Database\Schema\Grammars\SQLiteGrammar;
use Illuminate\Database\SQLiteConnection as BaseSQLiteConnection;

class SQLiteConnection extends BaseSQLiteConnection
{
    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SQLiteGrammar);
    }
}
