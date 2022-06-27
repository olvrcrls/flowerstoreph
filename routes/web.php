<?php

use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/products', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->middleware(['auth', 'verified'])->name('products.create');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware(['auth', 'verified'])->name('products.edit');
Route::post('/products', [ProductController::class, 'store'])->middleware(['auth', 'verified'])->name('products.store');
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware(['auth', 'verified'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware(['auth', 'verified'])->name('products.delete');
Route::put('/products/{product}/restore', [ProductController::class, 'restore'])->middleware(['auth', 'verified'])->name('products.restore');

Route::get('/orders', [OrderController::class, 'index'])->middleware(['auth', 'verified'])->name('orders');

require __DIR__.'/auth.php';
