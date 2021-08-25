<?php

namespace HStack\Plugins\Demo\Http\Controllers;

use App\Hooks\Hook;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    public function test()
    {
        return view('plugin:demo::demo');
    }

    // 这里只是为了不弄脏主程序controller，实际可以直接挪到其他地方，和插件无关
    public function hookTest()
    {
        Hook::call('demo_hook', 'Hello', 'World');

        dd('Hook processed data: ' . $GLOBALS['__demo_hook_data']);
    }
}
