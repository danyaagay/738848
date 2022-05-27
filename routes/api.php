<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

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

Route::middleware('auth_api')->apiResource('/book', BookController::class);
Route::middleware('auth_api')->apiResource('/genre', GenreController::class);

Route::post('/token', [UserController::class, 'token']);

Route::post('/book/{book}/genre/{genre}', [BookController::class, 'genre']);
Route::delete('/book/{book}/genre/{genre}', [BookController::class, 'genreDestroy']);

Route::apiResource('/user', UserController::class);
