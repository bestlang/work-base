<?php
Route::any('/csrf', 'IndexController@csrf');

/*AuthController: api only*/
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    /*Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');*/
});

Route::group(['middleware' => 'auth:api'], function(){
    include('adminOps.php');
});
