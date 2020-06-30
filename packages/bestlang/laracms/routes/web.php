<?php

Route::get('/', 'IndexController@index');
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
Route::get('/about', 'IndexController@about');
Route::get('/contact', 'IndexController@contact');
Route::get('/content/{id}', 'ContentController@index')->name('content');
Route::get('/channel/{id}', 'ChannelController@index')->name('channel');
Route::get('/single/{id}', 'ChannelController@single')->name('single');
Route::any('/comment/save', 'CommentController@save');
Route::get('/tag/{name}', 'TagController@contents')->name('tag');
Route::get('/search/{keyword}', 'SearchController@contents')->name('search');
Route::get('/user', 'UserController@index');

Route::group(['prefix' => 'ajax'], function($router){
    Route::any('/csrf', 'IndexController@csrf');
    Route::group(['prefix' => 'auth'], function ($router) {
//        Route::any('login', 'AuthController@login');
        Route::any('logout', 'ExitController@logout');
    });
//    Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
//        Route::get('/user/info', 'UserController@info');
//    });
    // @todo 使用带参数的中间来验证管理员 role:administrator
    Route::group(['middleware' => 'auth', 'prefix'=>'admin', 'namespace'=>'Admin'], function(){
        Route::get('/user/info', 'UserController@info');
        Route::any('/file/upload', 'UploadController@index');
        Route::any('/privileges/roles', 'PrivilegesController@roles');
        Route::any('/privileges/save/role', 'PrivilegesController@saveRole');
        Route::any('/privileges/delete/role', 'PrivilegesController@deleteRole');
        Route::any('/privileges/role/users', 'PrivilegesController@roleUsers');
        Route::any('/privileges/permissions/tree', 'PrivilegesController@permissionsTree');
        Route::any('/privileges/role/permissions', 'PrivilegesController@rolePermissions');
        Route::post('/privileges/add/permission', 'PrivilegesController@addPermission');
        Route::post('/privileges/edit/permission', 'PrivilegesController@editPermission');
        Route::post('/privileges/delete/permission', 'PrivilegesController@deletePermission');
        Route::post('/privileges/remove/role/model', 'PrivilegesController@removeRoleModel');
        Route::post('/privileges/give/permissions/to', 'PrivilegesController@givePermissionsTo');
        Route::any('/privileges/user/permissions', 'PrivilegesController@userPermissions');
        Route::post('/user/create', 'UserController@create');
        Route::post('/user/create/role/user', 'UserController@createRoleUser');
        Route::group(['namespace'=>'Cms'], function(){
            Route::any('/cms/channel/tree', 'ChannelController@tree');
            Route::any('/cms/channel/add', 'ChannelController@add');
            Route::any('/cms/channel/save', 'ChannelController@save');
            Route::any('/cms/channel/delete', 'ChannelController@delete');
            Route::any('/cms/channel/children', 'ChannelController@children');
            Route::any('/cms/channel/whole', 'ChannelController@whole');
            Route::any('/cms/model/field/types', 'FieldTypeController@index');
            Route::any('/cms/model/field/type/save', 'FieldTypeController@save');
            Route::any('/cms/model', 'ModelController@index');
            Route::any('/cms/model/save', 'ModelController@save');
            Route::any('/cms/model/delete', 'ModelController@delete');
            Route::any('/cms/model/save/field', 'ModelController@saveField');
            Route::any('/cms/model/save/field/order', 'ModelController@saveFieldOrder');
            Route::any('/cms/model/delete/field', 'ModelController@deleteField');
            Route::any('/cms/model/get', 'ModelController@get');
            Route::any('/cms/contents', 'ContentController@index');
            Route::any('/cms/content/save', 'ContentController@save');
            Route::any('/cms/content/delete', 'ContentController@delete');
            Route::any('/cms/content/whole', 'ContentController@whole');
            Route::any('/cms/positions', 'PositionController@index');
            Route::any('/cms/position/save', 'PositionController@save');
            Route::any('/cms/position/subs', 'PositionController@subs');
            Route::any('/cms/position/contents', 'PositionController@contents');
            Route::any('/cms/content/positions', 'PositionController@contentPositions');
            Route::any('/cms/get/position', 'PositionController@position');
            Route::any('/cms/get/comments', 'CommentController@index');
            Route::any('/cms/get/content/comments', 'CommentController@content');
            Route::any('/cms/save/ad/position', 'AdController@saveAdPosition');
            Route::any('/cms/get/ad/positions', 'AdController@getAdPositions');
            Route::any('/cms/delete/ad/position', 'AdController@deleteAdPosition');
            Route::any('/cms/save/ad', 'AdController@saveAd');
            Route::any('/cms/get/ads', 'AdController@getAds');
            Route::any('/cms/get/ad', 'AdController@getAd');
            Route::any('/cms/delete/ad', 'AdController@deleteAd');
        });
    });
});
//登录之后的动作定向到首页
Route::get('/home', function(){
    return redirect('/');
});

