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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.verify']], function(){
    //Super Admin
    Route::post('login', 'UserController@login');

    //Donatur
    Route::post('/donatur', 'DonaturController@store');
    Route::post('/donatur/{id}', 'DonaturController@update');
    Route::delete('donatur/{id}', 'DonaturController@destroy');
});
