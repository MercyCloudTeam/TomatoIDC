<?php

namespace App\Hooks;

class Hook
{

    private static array $hooks;

    /**
     * 使用Hook
     * @param string $hook
     * @param ...$params
     */
    public static function call(string $hook, ...$params)
    {
        foreach (self::$hooks[$hook] ?? [] as $callable) {
            call_user_func_array($callable, $params);
        }
    }

    /**
     * 注册Hook
     * @param string $hook
     * @param callable $callable
     */
    public static function register(string $hook, callable $callable)
    {
        self::$hooks[$hook][] = $callable;
    }
}
