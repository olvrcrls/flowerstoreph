<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('users', UserController::class);
Route::controller(UserController::class)->group(function() {
    Route::get('/users/enabled', 'indexEnabled')->name('users.enabled');
    Route::get('/users/disabled', 'indexDisabled')->name('users.disabled');
});

Route::apiResource('products', ProductController::class);
Route::controller(ProductController::class)->group(function() {
    Route::get('/products/enabled', 'indexEnabled')->name('products.enabled');
    Route::get('/products/disabled', 'indexDisabled')->name('products.disabled');
});

Route::apiResource('orders', OrderController::class);