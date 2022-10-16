<?php

namespace NoaPe\Beluga\Auth;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

trait HasOwningRelation
{
    /**
     * Potential owners of the shell.
     * 
     * @var array
     */
    protected $owners = [];

    /**
     * Potential editors of the shell.
     * 
     * @var array
     */
    protected $editors = [];

    /**
     * Potential viewers of the shell.
     * 
     * @var array
     */
    protected $viewers = [];

    /**
     * If user is in relation with the shell.
     * 
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  string $relationType
     * @return bool
     */
    protected function isInRelation(User $user, string $relationType)
    {
        $arrayName = Str::plural($relationType);

        if (in_array('User', $this->{$arrayName})) {
            return $this->getAttribute('user_id') == $user->id;
        }

        foreach ($this->{$arrayName} as $relation) {
            if ($this->{$relation}->isInRelation($user, $relationType)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Determine if the user is an owner of the shell.
     * 
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return bool
     */
    public function isOwnedBy(User $user)
    {
        return $this->isInRelation($user, 'owner');
    }

    /**
     * Determine if the user is an editor of the shell.
     * 
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return bool
     */
    public function isEditedBy(User $user)
    {
        return $this->isInRelation($user, 'editor');
    }

    /**
     * Determine if the user is a viewer of the shell.
     * 
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @return bool
     */
    public function isViewedBy(User $user)
    {
        return $this->isInRelation($user, 'viewer');
    }
}