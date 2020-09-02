<?php
Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
    Route::get('/user/info', 'UserController@info');
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
});