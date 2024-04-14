<?php

use App\Http\Controllers\ProductsController;
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



///PUBLIC ROUTES
Route::get('/products', [ProductsController::class, 'index']);
///Resource
Route::resource('/products', ProductsController::class);


Route::get('/add-to-cart/{id}', [ProductsController::class, 'addToCart']);
Route::get('/cart', [ProductsController::class, 'getCartItems']);
Route::post('/cart/{id}/increase', [ProductsController::class, 'increaseQuantity']);
Route::post('/cart/{id}/decrease', [ProductsController::class, 'decreaseQuantity']);
Route::delete('/cart/{id}', [ProductsController::class, 'removeFromCart']);



