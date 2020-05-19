<?php
Route::group(['prefix' => ''], function ($router) {
    Route::get('/', 'IndexController@index');
//    Route::get('/cms', 'IndexController@cms');
    Route::get('/about', 'IndexController@about');
    Route::get('/contact', 'IndexController@contact');
    Route::get('/content/{id}', 'ContentController@index')->name('content');
    Route::get('/channel/{id}', 'ChannelController@index')->name('channel');
    Route::any('/comment/save', 'CommentController@save');

});

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
        });
    });
});
//登录之后的动作定向到首页
Route::get('/home', function(){
    return redirect('/');
});

