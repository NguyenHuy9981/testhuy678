<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppifyController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Webhook', [ShoppifyController::class, 'createWebhook'])->name('createWebhook');

Route::post('/createProduct', [ShoppifyController::class, 'createProduct'])->name('createProduct');

Route::post('/updateProduct', [ShoppifyController::class, 'updateProduct'])->name('updateProduct');

Route::post('/deleteProduct', [ShoppifyController::class, 'deleteProduct'])->name('deleteProduct');
