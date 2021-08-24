<?php

namespace HStack\Plugins\Demo\Http\Controllers;

use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    public function test()
    {
        return view('plugin:demo::demo');
    }

}
