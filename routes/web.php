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




Route::prefix('product')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('product.index');

    // Đồng bộ dữ liệu từ phía App lên Shopify
    Route::get('/formCreate', [HomeController::class, 'createProduct'])->name('product.create');

    Route::post('/create', [HomeController::class, 'createProduct_UpShopify'])->name('createProduct_UpShopify');

    Route::get('/edit/{id}', [HomeController::class, 'editProduct'])->name('product.edit');

    Route::post('/update/{id}', [HomeController::class, 'updateProduct_UpShopify'])->name('updateProduct_UpShopify');

    Route::get('/delete/{id}', [HomeController::class, 'deleteProduct_UpShopify'])->name('deleteProduct_UpShopify');
});
