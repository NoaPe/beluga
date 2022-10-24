<?php

namespace NoaPe\Beluga\Auth;

use NoaPe\Beluga\Helpers\Permission;

trait HasPermissions
{
    /**
     * Get permissions of the user.
     *
     * @return array
     */
    public function getPermissions()
    {
        return Permission::of($this);
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
        return $this->hasMany('NoaPe\Beluga\Http\Shells\Permission');
    }

    /**
     * Add permission to the user.
     *
     * @param  string  $permission
     * @return void
     */
    public function addPermission(string $permission)
    {
        $this->permissions()->create(['name' => $permission])->save();
        $this->refresh();
    }

    /**
     * Delete permission to the user.
     *
     * @param  string  $permission
     * @return void
     */
    public function deletePermission(string $permission)
    {
        $this->permissions()->where('name', $permission)->delete();
        $this->refresh();
    }
}