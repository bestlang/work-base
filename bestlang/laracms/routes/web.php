<?php

Route::get('/', 'IndexController@index');
Route::get('/about', 'IndexController@about');
Route::get('/contact', 'IndexController@contact');
Route::get('/content/{id}', 'ContentController@index')->name('content');
Route::get('/channel/{id}', 'ChannelController@index')->name('channel');
Route::get('/single/{id}', 'ChannelController@single')->name('single');
Route::any('/comment/save', 'CommentController@save');
Route::get('/tag/{name}', 'TagController@contents')->name('tag');
Route::get('/search/{keyword}', 'SearchController@contents')->name('search');
Route::get('/ucenter', 'UCenterController@index');
Route::get('/ucenter/orders', 'OrderController@orders');
Route::any('/order/generate', 'OrderController@generate');
Route::any('/order/{order_no}', 'OrderController@detail');

//进入商户平台-->产品中心-->开发配置 填写此地址
Route::any('/notify/wechat/native', 'OrderController@wechatNativeNotify');
Route::any('/notify/wechat/async', 'OrderController@wechatAsyncNotify');
Route::any('/notify/alipay', 'AliPayController@notify');

Route::group(['prefix' => 'ajax'], function($router){
    Route::any('/pay/native1', 'OrderController@native1');
    Route::any('/pay/native2', 'OrderController@native2');
    Route::any('/pay/alipay/page', 'AliPayController@page');
    Route::any('/csrf', 'IndexController@csrf');
    // @todo 使用带参数的中间来验证管理员 role:administrator
    Route::group(['middleware' => 'auth'], function(){
          include('adminOps.php');

    });
});
//登录之后的动作定向到首页
//Route::get('/home', function(){
//    return redirect('/');
//});

