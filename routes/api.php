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


Route::get('v1/core/users', function() {
    $user = \Illuminate\Foundation\Auth\User::first();

    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\CreatedUser(User::first()));

    return response()->json([
        'data' => User::orderBy('name')->get(),
    ]);
});
