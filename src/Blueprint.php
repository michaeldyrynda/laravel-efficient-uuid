<?php

namespace Dyrynda\Database;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    /**
     * Create a new uuid column on the table, of type binary(16)
     *
     * @link  https://www.percona.com/blog/2014/12/19/store-uuid-optimized-way/ Store UUID in an optimized way
     *
     * @param  string  $column
     *
     * @return \Illuminate\Support\Fluent
     */
    public function efficientUuid($column)
    {
        return $this->addColumn('efficientUuid', $column);
    }
}
