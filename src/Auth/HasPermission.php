<?php

namespace NoaPe\Beluga\Auth;

use NoaPe\Beluga\Helpers\Permission;

trait HasPermission
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

    /**
     * Permissions of the user, hasMany relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('NoaPe\Beluga\Shells\Permission');
    }
}
