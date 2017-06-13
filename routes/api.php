<?php

use App\Models\User;
use Illuminate\Http\Request;

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
    return $request->user()->id;
});


Route::prefix('core')->middleware('auth:api')->namespace('Core')->group(function() {
    //GET -> users2.dev/api/v1/core/users
    Route::get('users', 'UserController@index');
    //POST -> users2.dev/api/v1/core/users
    Route::post('users', 'UserController@store');
    //GET -> users2.dev/api/v1/core/users/1
    Route::get('users/{user}', 'UserController@show');
    //PUT -> users2.dev/api/v1/core/users/1
    Route::put('users/{user}', 'UserController@update');
    //DELETE -> users2.dev/api/v1/core/users/1
    Route::delete('users/{user}', 'UserController@destroy');

    //GET -> users2.dev/api/v1/core/roles
    Route::get('roles', 'RoleController@index');

});