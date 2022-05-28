<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;

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

Route::middleware('auth_api')->get('/product/search', [ProductController::class, 'search']);

Route::middleware('auth_api')->post('/product/{product}/shop/{shop}', [ProductController::class, 'shop']);
Route::middleware('auth_api')->delete('/product/{product}/shop/{shop}', [ProductController::class, 'shopDestroy']);

Route::middleware('auth_api')->apiResource('/product', ProductController::class);
Route::middleware('auth_api')->apiResource('/shop', ShopController::class);

Route::post('/token', [UserController::class, 'token']);
Route::apiResource('/user', UserController::class);
