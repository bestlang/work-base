<?php

use Illuminate\Http\Request;

Route::post('register', 'UserController@register');
Route::post('admin/login', 'UserController@login');//alias
Route::post('admin/register', 'UserController@register');//alias

Route::get('/user/white/list', 'UserController@whiteList');


// mix
//Route::group(['middleware' => 'auth.jwt'], function () {
//    Route::get('user', 'UserController@getAuthUser');
//    Route::get('user/refresh', 'UserController@refresh');
//    Route::get('admin/user/refresh', 'UserController@refresh');//alias
//    Route::post('/user/submit/wx', 'UserController@submitWx');
//    Route::post('/user/submit/mobile', 'UserController@submitMobile');
//
//    Route::get('/user/get/parent', 'UserController@parentUser');
//    Route::get('/get/user/by/id', 'UserController@getUserById');
//
//    Route::get('/judge/newbie', 'UserController@isNewbie');
//
//    Route::post('/mp/update/user/info', 'MpController@updateUserInfo');
//    Route::post('/mp/decode/share/info', 'MpController@decodeShareInfo');
//    Route::get('/mp/get/user/by/mp/open/id', 'MpController@getUserByMpOpenId');
//    Route::get('/mp/ensure/relationship', 'MpController@ensureRelationship');
//    Route::post('/search/history/record', 'SearchHistoryController@record');
//    Route::get('/search/hot/words', 'SearchHistoryController@hotWords');
//    Route::get('/f/rate', 'UserController@fRate');
//    Route::get('/f/level', 'UserController@fLevel');
//});
