<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','theme::index')->name('index');


Route::middleware(['auth:sanctum'])->prefix('home')->group(function (){
    Route::middleware(['verified'])->group(function (){//验证后
        Route::resource('tickets',TicketController::class);
    });
    Route::view('/dashboard','theme::dashboard')->name('dashboard');//仪表盘

});
Route::view('/terms-of-service','theme::terms-of-service' )->name('terms.show');//用户协议
Route::view('/privacy-policy', 'theme::privacy-policy')->name('policy.show');//隐私协议

Route::view('/product','theme::product');
Route::view('/product','');
Route::view('/product','');

Route::view('/contact','theme::contact')->name('contact');//联系页面
Route::post('/contact',[TicketController::class,'contactStore']);//提交联系申请

//Route::view('theme::billing.product-list',);
//Route::post('/contact','theme::contact')->name('contact');
