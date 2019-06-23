<?php

namespace Zeropingheroes\Lanager\Policies;

use Zeropingheroes\Lanager\User;
use Zeropingheroes\Lanager\UserFavouriteGame;

class UserFavouriteGamePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view a given item.
     *
     * @param null|User $authUser
     * @param UserFavouriteGame $userFavouriteGame
     * @return mixed
     */
    public function view(?User $authUser, UserFavouriteGame $userFavouriteGame)
    {
        // Anyone can view users
        return true;
    }

    /**
     * Determine whether the user can create an item.
     *
     * @param User $authUser
     * @param User $user
     * @return mixed
     */
    public function create(User $authUser, User $user)
    {
        return $authUser->id === $user->id;
    }
}