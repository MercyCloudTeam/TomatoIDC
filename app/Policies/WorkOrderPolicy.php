<?php

namespace App\Policies;

use App\User;
use App\WorkOrderModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the work order model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrderModel  $workOrderModel
     * @return mixed
     */
    public function view(User $user, WorkOrderModel $workOrderModel)
    {
        return $user->id === $workOrderModel->user_id;
    }

    /**
     * Determine whether the user can create work order models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the work order model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrderModel  $workOrderModel
     * @return mixed
     */
    public function update(User $user, WorkOrderModel $workOrderModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the work order model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrderModel  $workOrderModel
     * @return mixed
     */
    public function delete(User $user, WorkOrderModel $workOrderModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the work order model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrderModel  $workOrderModel
     * @return mixed
     */
    public function restore(User $user, WorkOrderModel $workOrderModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the work order model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrderModel  $workOrderModel
     * @return mixed
     */
    public function forceDelete(User $user, WorkOrderModel $workOrderModel)
    {
        //
    }
}
