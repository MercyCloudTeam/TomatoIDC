<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('tickets', 'TicketController');
    $router->resource('billing', 'BillingController');
    $router->resource('category', 'CategoryController');
    $router->resource('service', 'ServiceController');
    $router->resource('products', 'ProductController');
    $router->resource('user', 'UserController');

});
