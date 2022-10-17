<?php

namespace NoaPe\Beluga\Auth\Middleware;

use Closure;

class UserHasBelugaAdministrationPermission extends UserHasPermission
{
    protected $permission = 'beluga_administration';
}