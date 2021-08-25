<?php

namespace App\Hooks;

class Hook
{
    public static function call(string $hook, ...$params)
    {
        foreach ($GLOBALS['hstack_hooks'][$hook] ?? [] as $callable) {
            call_user_func_array($callable, $params);
        }
    }

    public static function register(string $hook, callable $callable)
    {
        $GLOBALS['hstack_hooks'][$hook][] = $callable;
    }
}
