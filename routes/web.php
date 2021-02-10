<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;

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

Route::get('/', [ProductsController::class, 'actionGetProducts']);

Route::get('/actionSortProducts', [ProductsController::class, 'actionSortProducts']);

Auth::routes();

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/actionAddProduct', [CartController::class, 'actionAddProduct']);
Route::delete('/actionDeleteProduct', [CartController::class, 'actionDeleteProduct']);