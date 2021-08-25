<?php

use App\Hooks\Hook;
use HStack\Plugins\Demo\Hooks\DemoHook;

Hook::register('demo_hook', new DemoHook());
