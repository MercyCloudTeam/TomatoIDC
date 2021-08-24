<?php

use HStack\Plugins\Demo\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('plugin/test', [DemoController::class, 'test']);
