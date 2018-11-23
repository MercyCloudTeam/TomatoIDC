<?php

namespace App\Providers;

use App\GoodCategoriesModel;
use App\HostModel;
use App\OrderModel;
use App\Policies\GoodsCategoriesPolicy;
use App\Policies\HostPolicy;
use App\Policies\OrderPolicy;
use App\Policies\WorkOrderPolicy;
use App\WorkOrderModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        GoodCategoriesModel::class => GoodsCategoriesPolicy::class,
        HostModel::class => HostPolicy::class,
        OrderModel::class=>OrderPolicy::class,
        WorkOrderModel::class =>WorkOrderPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
