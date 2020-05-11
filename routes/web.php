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
// cms
//Route::group(['prefix' => 'cms', 'namespace'=>'Cms'], function ($router) {
//    Route::get('/', 'IndexController@index');
//    Route::get('/cms', 'IndexController@cms');
//    Route::get('/about', 'IndexController@about');
//    Route::get('/contact', 'IndexController@contact');
//
//    Route::get('/content/{id}', 'ContentController@index');
//    Route::get('/channel/{id}', 'ChannelController@index');
//    Route::any('/comment/save', 'CommentController@save');
//});

//Route::get('/', 'Pdd\IndexController@index');
//Route::get('/', function (){
//    return redirect('/cms');
//});
Route::get('/info', function(){echo phpinfo();});
//测试微信支付
Route::get('/pay', 'Pdd\IndexController@wePay');
Route::get('/notify', 'Pdd\IndexController@notify');
Route::get('/test/jwt/token', 'Pdd\IndexController@testJwtToken');
Route::get('/test', 'Pdd\IndexController@test');
//小程序code换openid session_key等信息
Route::get('/mp/code/session', 'MpController@codeSession');
Route::any('/mp/serve', 'MpController@serve');
Route::get('/mp/upload/image', 'MpController@uploadImage');

Route::get('/encrypt', 'IndexController@encrypt');
Route::get('/token', 'IndexController@token');
Route::get('/decrypt', 'IndexController@decrypt');

Route::get('/test/permission/guard', 'IndexController@testPermissionGuard');


// for test purpose
Route::get('/activity/zero/benifits', 'ActivityController@zeroBenifits');
Route::get('/activity/applicables', 'Admin\ActivityController@applicables');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
