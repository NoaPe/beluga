<?php

namespace NoaPe\Beluga\Auth\Policies;

use NoaPe\Beluga\Shell;
use NoaPe\Beluga\Helpers\Permission;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestPolicy
{
    use HandlesAuthorization;

    /**
     * Table name
     * 
     * @var string
     */
    public $table_name = null;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Permission::hasPermission($user, $this->table_name.'_view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Shell $shell)
    {
        return Permission::hasPermission($user, $this->table_name.'_view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Permission::hasPermission($user, $this->table_name.'_create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Shell $shell)
    {
        return Permission::hasPermission($user, $this->table_name.'_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Shell $shell)
    {
        return Permission::hasPermission($user, $this->table_name.'_delete');
    }
}
