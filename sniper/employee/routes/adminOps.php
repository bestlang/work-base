<?php

Route::group(['prefix'=>'admin/sniper/employee', 'namespace'=>'Admin'], function(){
        Route::any('/departments/level1', 'DepartmentController@level1');
        Route::any('/departments/tree/select', 'DepartmentController@treeSelect');
        Route::any('/get/department/detail', 'DepartmentController@departmentDetail');
        Route::any('/get/department/descendants', 'DepartmentController@getDescendants');
        Route::post('/save/department', 'DepartmentController@save');
        Route::post('/delete/department', 'DepartmentController@delete');

        Route::any('/positions/tree/select', 'PositionController@treeSelect');
        Route::any('/get/position/detail', 'PositionController@positionDetail');
        Route::any('/get/position/descendants', 'positionController@getDescendants');
        Route::post('/save/position', 'PositionController@save');
        Route::post('/delete/position', 'PositionController@delete');

        Route::post('/save/employee', 'EmployeeController@save');
        Route::any('/department/employee', 'EmployeeController@departmentEmployee');
        Route::any('/get/employee/detail', 'EmployeeController@detail');
        Route::post('/delete/employee/education', 'EducationController@delete');
        Route::post('/delete/employee/job', 'JobController@delete');

        Route::any('/ding/get/departments', 'DingTalkController@departments');
        Route::any('/ding/get/department/users', 'DingTalkController@departmentUsers');
        Route::any('/ding/get/users/attendance', 'DingTalkController@usersAttendance');
});