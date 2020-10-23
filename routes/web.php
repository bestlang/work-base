<?php

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
Route::any('/', function(){
        return redirect(config('bestlang.defaultApplicationPath'));
});

//Route::get('/info', function(){echo phpinfo();});
//测试微信支付
//Route::get('/pay', 'Pdd\IndexController@wePay');
//Route::get('/notify', 'Pdd\IndexController@notify');
//Route::get('/test/jwt/token', 'Pdd\IndexController@testJwtToken');
//Route::get('/test', 'Pdd\IndexController@test');
//小程序code换openid session_key等信息
Route::get('/mp/code/session', 'MpController@codeSession');
Route::any('/mp/serve', 'MpController@serve');
Route::get('/mp/upload/image', 'MpController@uploadImage');

Route::get('/encrypt', 'IndexController@encrypt');
Route::get('/token', 'IndexController@token');
Route::get('/decrypt', 'IndexController@decrypt');

Route::get('/test/permission/guard', 'IndexController@testPermissionGuard');


//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('wechat/order/native1', 'IndexController@native1');

Route::get('wechat/order/native2', 'IndexController@native2');

Route::any('alipay/create', 'Index2Controller@invoke');



//Route::group(['prefix' => 'ajax'], function($router){
//    Route::any('pay/native2', 'PayController@native2');
//});
