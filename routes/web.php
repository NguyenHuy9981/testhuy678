<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShoppifyController;

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

Route::get('/', [ShoppifyController::class, 'index'])->name('home');

Route::post('/store', [ShoppifyController::class, 'store'])->name('store');

Route::get('/authenticate', [ShoppifyController::class, 'authenticate']);

Route::post('/admin/oauth/access_token', [ShoppifyController::class, 'getshop'])->name('getshop');


// Home //
Route::get('/product', [HomeController::class, 'index'])->name('product.index');