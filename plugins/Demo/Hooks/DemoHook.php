<?php

namespace HStack\Plugins\Demo\Hooks;

class DemoHook
{
    public function __invoke($param_1, $param_2)
    {
        $GLOBALS['__demo_hook_data'] = "$param_1, $param_2!";
    }
}
