<?php
Route::any('/csrf', 'IndexController@csrf');

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'auth.jwt'], function(){
    include('adminOps.php');
});
Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
    Route::any('/file/upload/ueditor', 'UploadController@ueditor');
});

