<?php

Route::group(['prefix' => 'ajax'], function($router){

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::any('login', 'AuthController@login');
        Route::any('logout', 'ExitController@logout');
    });

    // @todo 使用带参数的中间来验证管理员 role:administrator
    Route::group(['middleware' => 'auth'], function(){
        include('adminOps.php');

    });
});

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