<?php

namespace NoaPe\Beluga\Auth\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use NoaPe\Beluga\Shell;

class ShellPolicy extends RestPolicy
{
    use HandlesAuthorization;

    /**
     * __call method for verify if hasPermission method exists for user.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (method_exists($parameters[0], 'isOwnedBy')
            && method_exists($parameters[0], 'isEditedBy')
            && method_exists($parameters[0], 'isViewedBy')) {
            return $this->{$method}(...$parameters);
        } else {
            throw new \BadMethodCallException("User does not use NoaPe\Beluga\Auth\HasOwningRelation trait.");
        }
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
        return $shell->isOwnedBy($user) || $shell->isEditedBy($user) || $shell->isViewedBy($user);
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
        return $shell->isOwnedBy($user) || $shell->isEditedBy($user);
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
        return $shell->isOwnedBy($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Shell $shell)
    {
        return $shell->isOwnedBy($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  \NoaPe\Beluga\Shell  $shell
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Shell $shell)
    {
        return $shell->isOwnedBy($user);
    }
}
