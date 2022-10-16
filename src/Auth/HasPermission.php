<?php

namespace NoaPe\Beluga\Auth;

use NoaPe\Beluga\Helpers\Permission;

trait HasPermissions
{
    /**
     * Cached permissions
     * 
     * @var array
     */
    protected $cachedPermissions = [];

    /**
     * Get permissions of the user.
     * 
     * @return array
     */
    public function getPermissions()
    {
        if (empty($this->cachedPermissions)) {
            $this->cachedPermissions = Permission::of($this);
        }

        return $this->cachedPermissions;
    }

    /**
     * Determine if the user has the given permission.
     *
     * @param  string  $permission
     * @return bool
     */
    public function hasPermission(string $permission)
    {
        return in_array($permission, $this->getPermissions());
    }
}