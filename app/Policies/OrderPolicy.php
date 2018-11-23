<?php

namespace App\Policies;

use App\User;
use App\OrderModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order model.
     *
     * @param  \App\User  $user
     * @param  \App\OrderModel  $orderModel
     * @return mixed
     */
    public function view(User $user, OrderModel $orderModel)
    {
        return $user->id === $orderModel->user_id;
    }

    /**
     * Determine whether the user can create order models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the order model.
     *
     * @param  \App\User  $user
     * @param  \App\OrderModel  $orderModel
     * @return mixed
     */
    public function update(User $user, OrderModel $orderModel)
    {
        return $user->id === $orderModel->user_id;
    }

    /**
     * Determine whether the user can delete the order model.
     *
     * @param  \App\User  $user
     * @param  \App\OrderModel  $orderModel
     * @return mixed
     */
    public function delete(User $user, OrderModel $orderModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the order model.
     *
     * @param  \App\User  $user
     * @param  \App\OrderModel  $orderModel
     * @return mixed
     */
    public function restore(User $user, OrderModel $orderModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the order model.
     *
     * @param  \App\User  $user
     * @param  \App\OrderModel  $orderModel
     * @return mixed
     */
    public function forceDelete(User $user, OrderModel $orderModel)
    {
        //
    }
}
