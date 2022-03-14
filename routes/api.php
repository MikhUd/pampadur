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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('/dating-card', \App\Http\Controllers\DatingCard\DatingCardController::class)->only(['update', 'store', 'index']);
    Route::get('/files/{path}', \App\Http\Controllers\GetPrivateFilesController::class)->where('path', '.*');
});


Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/token', [\App\Http\Controllers\Auth\AuthController::class, 'token']);

