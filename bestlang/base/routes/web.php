<?php
Route::any('/', function(){
    return redirect(config('bestlang.defaultApplicationPath'));
});
Route::group(['prefix' => 'ajax'], function($router){

    Route::any('/csrf', 'IndexController@csrf');
    Route::group(['namespace'=>'Auth', 'prefix'=>'auth'], function(){
        Route::any('login', 'LoginController@login');
        Route::any('logout', 'LoginController@logout');
        Route::any('password/modify', 'LoginController@passwordModify');
    });
    Route::group(['middleware' => 'auth'], function(){
        include('adminOps.php');
    });
});

/*登录注册相关路由*/
Route::group(['namespace'=>'Auth'], function(){
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::any('logout', 'LoginController@logout')->name('logout');
    // Registration Routes...
    if(env('APP_ALLOW_REGISTER', false)){
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
});

Route::any('/socialite/qq', 'SocialiteController@qq');
Route::any('/open3rd/qq', 'SocialiteController@qq');