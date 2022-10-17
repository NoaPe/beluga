<?php

namespace NoaPe\Beluga\Auth\Middleware;

class UserHasBelugaAdministrationPermission extends UserHasPermission
{
    protected $permission = 'beluga_administration';
}
