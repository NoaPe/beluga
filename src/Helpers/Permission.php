<?php

namespace NoaPe\Beluga\Helpers;

use Illuminate\Foundation\Auth\User;

class Permission
{
    /**
     * Instance
     */
    protected static $instance = null;

    /**
     * Permissions
     */
    protected $permissions = [];

    /**
     * Get instance
     *
     * @return Permission
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            $class = static::class;
            static::$instance = new $class();
        }

        return static::$instance;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        $this->permissions = static::getPermissionsArray();
    }

    /**
     * Recursive function for flattening array.
     *
     * @return array
     */
    protected static function flatten($array)
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, static::flatten($value), [$key]);
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * Get permissions array
     *
     * @return array
     */
    public static function getPermissionsArray()
    {
        return config('permissions');
    }

    /**
     * Get permissions
     *
     * @return array
     */
    public static function getPermissions()
    {
        return static::getInstance()->permissions;
    }

    /**
     * Get sub permissions
     *
     * @param  string  $permission
     * @return array|null
     */
    public static function getSubPermissions($permission)
    {
        return static::getPermissionGroup($permission, true);
    }

    /**
     * Get permission group
     *
     * @param  string  $name
     * @param  bool  $flatened
     * @param  array  $permissionArray
     * @return array|null
     */
    public static function getPermissionGroup(string $name, bool $flatened = false, array $permissionArray = null)
    {
        $permissionArray = $permissionArray ?: static::getPermissions();

        if (! $permissionArray) {
            return null;
        }

        if (isset($permissionArray[$name])) {
            return $flatened ? static::flatten($permissionArray[$name]) : $permissionArray[$name];
        } else {
            foreach ($permissionArray as $value) {
                if (is_array($value)) {
                    $group = static::getPermissionGroup($name, $flatened, $value);

                    if ($group !== null) {
                        return $group;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Get all permission of a given user
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     **/
    public static function of(User $user)
    {
        $permissions = [];

        foreach ($user->getAttribute('permissions') as $permission) {
            $toAdd = static::getSubPermissions($permission->name);

            if ($toAdd !== null && is_array($toAdd)) {
                $permissions = array_merge($permissions, $toAdd);
            }

            $permissions[] = $permission->name;
        }

        return $permissions;
    }

    /**
     * User has permission among given permissions
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  array  $permissions
     * @return bool
     */
    public static function has(User $user, array $permissions)
    {
        $userPermissions = static::of($user);
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Permission is in the given group
     *
     * @param  string  $permission
     * @param  string  $group
     * @return bool
     */
    public static function isInGroup(string $permission, string $group)
    {
        $group = static::getPermissionGroup($group);

        if ($group !== null) {
            return in_array($permission, $group);
        }

        return false;
    }

    /**
     * User has the given permission
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  string  $permission
     * @return bool
     *
     * @throws \BadMethodCallException
     */
    public static function hasPermission(User $user, string $permission)
    {
        if (method_exists($user, 'hasPermission')) {
            return $user->hasPermission($permission);
        } else {
            throw new \BadMethodCallException('User model must use NoaPe\Beluga\Auth\HasPermission trait.');
        }
    }
}
