<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::middleware(['throttle:60,1'])->group(function () {
        Route::get('goods/list', 'IndexController@getGoodListApi');//获取商品列表
        Route::get('goods/categories/{name}', 'IndexController@getGoodCategoriesApi');//查询商品分类信息
        Route::post('user/login', 'IndexController@apiLoginAction');
        Route::middleware(['auth', 'check.admin.authority'])->group(function () {
            Route::prefix('')->group(function () {

            });
        });
    });
});
