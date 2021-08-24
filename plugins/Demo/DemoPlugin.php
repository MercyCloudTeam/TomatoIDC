<?php

namespace HStack\Plugins\Demo;

use App\Plugins\Plugin;

class DemoPlugin extends Plugin
{
    public string $name = 'Demo';

    public function boot()
    {
        $this->enableViews();
        $this->enableRoutes();
    }
}
