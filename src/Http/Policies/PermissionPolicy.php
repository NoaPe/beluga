<?php

namespace NoaPe\Beluga\Http\Policies;

use NoaPe\Beluga\Auth\Policies\RestPolicy;

class PermissionPolicy extends RestPolicy
{
    /**
     * Table name
     *
     * @var string
     */
    public $table_name = 'beluga_permissions';
}
