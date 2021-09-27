<?php

namespace App\Providers;

use App\HStack\SetupManager;
use App\Plugins\PluginManager;
use Illuminate\Support\ServiceProvider;

class HStackServiceProvider extends ServiceProvider
{
    public array $setups;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind('hstack-theme', function () {
//        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        (new SetupManager());

    }
}
