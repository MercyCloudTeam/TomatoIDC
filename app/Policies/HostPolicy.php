<?php

namespace App\Policies;

use App\User;
use App\HostModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the host model.
     *
     * @param  \App\User  $user
     * @param  \App\HostModel  $hostModel
     * @return mixed
     */
    public function view(User $user, HostModel $hostModel)
    {
        if ($hostModel->status == 1) {
            return $user->id === $hostModel->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create host models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the host model.
     *
     * @param  \App\User  $user
     * @param  \App\HostModel  $hostModel
     * @return mixed
     */
    public function update(User $user, HostModel $hostModel)
    {
        return $user->id === $hostModel->user_id;
    }

    /**
     * Determine whether the user can delete the host model.
     *
     * @param  \App\User  $user
     * @param  \App\HostModel  $hostModel
     * @return mixed
     */
    public function delete(User $user, HostModel $hostModel)
    {

    }

    /**
     * Determine whether the user can restore the host model.
     *
     * @param  \App\User  $user
     * @param  \App\HostModel  $hostModel
     * @return mixed
     */
    public function restore(User $user, HostModel $hostModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the host model.
     *
     * @param  \App\User  $user
     * @param  \App\HostModel  $hostModel
     * @return mixed
     */
    public function forceDelete(User $user, HostModel $hostModel)
    {
        //
    }
}
