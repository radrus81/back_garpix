<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartSessionController;

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


Route::get('sortProducts/{field?}/{typeSort?}', [ProductsController::class, 'sortProducts']);

Route::post('/addProductToSession', [CartSessionController::class, 'addProduct']);
Route::delete('cartsession/deleteProductFromSession', [CartSessionController::class, 'deleteProductFromSession']);

