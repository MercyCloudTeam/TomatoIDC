<?php

namespace App\Providers;

use App\HStack\SetupManager;
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
