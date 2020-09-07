<?php
Route::any('/sniper', 'EmployeeController@index');


Route::group(['prefix' => 'ajax'], function($router){
    Route::group(['middleware' => 'auth'], function(){
        include('adminOps.php');
    });
});