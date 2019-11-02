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


// 登录
Route::post('login', 'Api\AuthController@login')->name('admin.login');

// 注册
Route::post('register', 'Api\AuthController@register')->name('admin.register');

// 访客咨询
Route::post('visit', 'Api\VisitorController@mine');

// 访客聊天内容
Route::get('visitor/messages','Api\ChatController@visitorMessage');

// 需要登录的路由组
Route::group([
    'middleware'    => [
        'jwt.auth',
    ]

],function (){

    // 退出
    Route::delete('logout', 'Api\AuthController@logout');
    Route::get('profile', 'Api\AuthController@profile');

    // 客服
    Route::apiResource('admin','Api\AdminController');

    // 访客
    Route::apiResource('visitor','Api\VisitorController');

    // 客服聊天内容
    Route::get('service/messages','Api\ChatController@serviceMessage');


    // 应用
    Route::get('application','Api\ApplicationController@show');
});
