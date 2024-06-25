<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('check-authentication-code', [AuthController::class, 'checkAuthenticationCode']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::group(['middleware' => 'api'], function ($router) {

    Route::get('category', [CategoryController::class, 'getAllCategory']);

    Route::get('product', [ProductController::class, 'getAllProduct']);

    Route::get('product/{productId}', [ProductController::class, 'getProductById']);

    Route::get('cart', [CartController::class, 'getAllCartDetails']);

    Route::post('cart', [CartController::class, 'addToCart']);

    Route::patch('cart', [CartController::class, 'changeQuantity']);

    Route::delete('cart/{cartDetailId}', [CartController::class, 'delete']);

    Route::get('order', [OrderController::class, 'getAllOrderDetails']);

    Route::post('order', [OrderController::class, 'order']);
});
