<?php

namespace NoaPe\Beluga\Http\Policies;

use NoaPe\Beluga\Auth\Policies\RestPolicy;

class TablePolicy extends RestPolicy
{
    /**
     * Table name
     *
     * @var string
     */
    public $table_name = 'beluga_tables';
}