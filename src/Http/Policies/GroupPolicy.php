<?php

namespace NoaPe\Beluga\Http\Policies;

use NoaPe\Beluga\Auth\Policies\RestPolicy;

class GroupPolicy extends RestPolicy
{
    /**
     * Table name
     *
     * @var string
     */
    public $table_name = 'group_tables';
}
