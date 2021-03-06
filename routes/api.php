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

Route::prefix('auth')->group(function () {
  Route::post('/register', 'AuthController@register');
  Route::post('/login', 'AuthController@login');
  Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
});

Route::prefix('password')->group(function () {
  Route::post('email', 'PasswordResetController@sendEmail');
  Route::post('reset', 'PasswordResetController@reset');
});
