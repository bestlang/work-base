<?php
Route::any('/csrf', 'IndexController@csrf');

/*AuthController: api only*/
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    /*Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');*/
});

Route::group(['middleware' => 'auth.jwt'], function(){
    include('adminOps.php');
});