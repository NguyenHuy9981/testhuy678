<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppifyController;
use App\Http\Controllers\WebhookProductController;

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

//  Webhook đồng bộ dữ liệu từ Shopify xuống App
Route::any('/Webhook', [WebhookProductController::class, 'createWebhook'])->name('createWebhook');

Route::any('/createProduct', [WebhookProductController::class, 'createProduct'])->name('createProduct');

Route::any('/updateProduct', [WebhookProductController::class, 'updateProduct'])->name('updateProduct');

Route::any('/deleteProduct', [WebhookProductController::class, 'deleteProduct'])->name('deleteProduct');
