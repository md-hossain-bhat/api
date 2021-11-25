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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('App\Http\Controllers')->group(function(){
    Route::get('users','APIController@getUsers');
    Route::post('add-user','APIController@addUser');
    Route::post('add-multiple-users','APIController@addMultipleUsers');
    Route::get('users/{id?}','APIController@getSingleUser');
    Route::put('user-details-update/{id}','APIController@updateUserDetails');
    Route::patch('user-update/{id}','APIController@updateUser');
    Route::delete('delete-user/{id}','APIController@deleteUser');
});

