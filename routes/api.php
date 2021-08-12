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
Route::group([
 'namespace' => 'App\Http\Controllers',
], function(){
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::post('/logout', 'UserController@logout');
    // Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');

    //Donatur
    Route::get('/donatur', 'DonaturController@index')->middleware('jwt.verify');
    Route::get('/donatur/{id}', 'DonaturController@get')->middleware('jwt.verify');
    Route::post('/donatur', 'DonaturController@store')->middleware('jwt.verify');
    Route::post('/donatur/{id}', 'DonaturController@update')->middleware('jwt.verify');
    Route::post('/donatur/{id}/delete', 'DonaturController@destroy')->middleware('jwt.verify');
});
