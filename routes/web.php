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

Route::view('/','theme::index');


Route::middleware(['auth:sanctum','web'])->prefix('home')->group(function (){
    Route::resource('tickets',TicketController::class);
});

Route::view('/product','theme::product');
Route::view('/product','');
Route::view('/product','');

Route::view('/contact','theme::contact')->name('contact');
Route::post('/contact',[TicketController::class,'contactStore']);
//Route::post('/contact','theme::contact')->name('contact');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
