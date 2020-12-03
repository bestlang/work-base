<?php

Route::get('/cms', 'IndexController@index')->name('cms');
Route::get('/about', 'IndexController@about');
Route::get('/contact', 'IndexController@contact');
Route::get('/content/{id}', 'ContentController@index')->name('content');
Route::get('/channel/{id}', 'ChannelController@index')->name('channel');
Route::get('/single/{id}', 'ChannelController@single')->name('single');
Route::any('/comment/save', 'CommentController@save');
Route::get('/tag/{name}', 'TagController@contents')->name('tag');
Route::get('/search/{keyword}', 'SearchController@contents')->name('search');
Route::group(['middleware' => 'auth'], function(){
    Route::any('user', 'UCenterController@user');
    Route::get('/ucenter', 'UCenterController@index');
    Route::get('/ucenter/orders', 'OrderController@orders');
    Route::get('/ucenter/password/modify', 'UCenterController@passwordModifyForm');
    Route::get('/ucenter/order/detail/{order_no}', 'OrderController@detail')->name('orderDetail');
    Route::any('/order/generate', 'OrderController@generate');
    Route::any('/order/pay/{order_no}', 'OrderController@orderPay')->name('orderPay');
});


//进入商户平台-->产品中心-->开发配置 填写此地址
Route::any('/notify/wechat/native', 'WxPayController@wechatNativeNotify');
Route::any('/notify/wechat/async', 'WxPayController@wechatAsyncNotify');

Route::any('/return/alipay', 'AliPayController@returnUrl');
Route::any('/notify/alipay', 'AliPayController@asyncNotify');

Route::any('/pay/wxpay', 'PayController@wxpay');
Route::any('/pay/alipay', 'PayController@alipay');

Route::group(['prefix' => 'ajax'], function($router){

    Route::group(['middleware' => 'auth'], function(){
        include('adminOps.php');
    });

    Route::any('/pay/native1', 'WxPayController@native1');
    Route::any('/pay/native2', 'WxPayController@native2');

    Route::any('/pay/alipay/page', 'AliPayController@page');
});

Route::fallback(function(){
    return redirect('/');
});