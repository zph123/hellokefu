<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


// Login
Route::post('login', 'Api\AuthController@login')->name('admin.login');
// Register
Route::post('register', 'Api\AuthController@register')->name('admin.register');


// 需要登录的路由组
Route::group([
    'middleware'    => [
        'jwt.auth',
    ]

],function (){

    // Auth
    Route::delete('logout', 'Api\AuthController@logout');
    Route::get('profile', 'Api\AuthController@profile');

    // Admin
    Route::apiResource('admin','Api\AdminController');

    // Visitor
    Route::apiResource('visitor','Api\VisitorController');

    // Chat
    Route::apiResource('chat','Api\ChatController');
});
