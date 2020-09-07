<?php

Route::group(['prefix'=>'admin/sniper/employee', 'namespace'=>'Admin'], function(){
        Route::any('/departments', 'DepartmentController@index');
        Route::post('/save/department', 'DepartmentController@save');
});