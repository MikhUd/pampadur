<?php

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
    Route::get('/dating-card/reciprocal-likes', [\App\Http\Controllers\DatingCard\DatingCardController::class, 'getReciprocalLikes']);
    Route::get('/dating-card/to-assess', [\App\Http\Controllers\DatingCard\DatingCardController::class, 'getDatingCardsToAssess']);
    Route::get('/files', \App\Http\Controllers\GetPrivateFilesController::class);
    Route::post('/delete-token', [\App\Http\Controllers\Auth\AuthController::class, 'deleteToken']);
    Route::post('/like/set', [\App\Http\Controllers\DatingCard\LikeController::class, 'setLikeOrDislike']);
});


Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/get-token', [\App\Http\Controllers\Auth\AuthController::class, 'getToken']);

