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

Route::post('checkAuth', 'APIController@checkAuth');
Route::post('registerPassword', 'APIController@registerPassword');
Route::post('forgotPassword', 'APIController@forgotPassword');
Route::post('updatePassword', 'APIController@updatePassword');

Route::middleware(['auth:sanctum'])->group(function () {

  Route::get('getUserInfo', 'APIController@getUserInfo');
  Route::post('sendAttendInfo', 'APIController@sendAttendInfo');
  Route::post('updateProfile', 'APIController@updateProfile');

});