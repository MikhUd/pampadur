<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
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
Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::resource('/dating-card', \App\Http\Controllers\DatingCard\DatingCardController::class)->only(['update', 'store', 'index']);
    Route::get('/files/{path}', \App\Http\Controllers\GetPrivateFilesController::class)->where('path', '.*');
});


Route::get('/{any}', MainController::class)->where('any', '.*');
Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);



