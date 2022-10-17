<?php

namespace NoaPe\Beluga\Auth;

use NoaPe\Beluga\Helpers\Permission;

trait HasShellWithPermissions
{
    /**
     * Association of methods to permissions
     * 
     * @var array
     */
    protected $permissions = [
        'index' => 'view',
        'show' => 'view',
        'create' => 'create',
        'store' => 'create',
        'edit' => 'edit',
        'update' => 'edit',
        'destroy' => 'delete',
    ];

    /**
     * __call magic method
     * 
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, array_keys($this->permissions))) {
            return Permission::hasPermission(auth()->user(), $this->shell->getTableName().'_'.$this->permissions[$method]);
        } else {
            return parent::__call($method, $parameters);
        }
    }
}