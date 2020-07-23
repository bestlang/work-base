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
Route::any('/order/generate', 'OrderController@generate');
Route::any('/order/{order_no}', 'OrderController@detail');

//进入商户平台-->产品中心-->开发配置 填写此地址
Route::any('/notify/wechat/native', 'OrderController@wechatNativeNotify');
Route::any('/notify/wechat/async', 'OrderController@wechatAsyncNotify');

Route::group(['prefix' => 'ajax'], function($router){
    Route::any('/pay/native1', 'OrderController@native1');
    Route::any('/pay/native2', 'OrderController@native2');
    Route::any('/csrf', 'IndexController@csrf');
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::any('login', 'AuthController@login');
        Route::any('logout', 'ExitController@logout');
    });
    // @todo 使用带参数的中间来验证管理员 role:administrator
    Route::group(['middleware' => 'auth'], function(){
          include('adminOps.php');

    });
});
//登录之后的动作定向到首页
//Route::get('/home', function(){
//    return redirect('/');
//});
Route::group(['namespace'=>'Auth'], function(){
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
});

