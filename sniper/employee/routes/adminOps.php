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
        Route::any('/get/position/descendants', 'PositionController@getDescendants');
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
        Route::any('/ding/get/user/week/attendance/avg', 'DingTalkController@weekAvg');
        Route::any('/ding/get/user/month/attendance/avg', 'DingTalkController@monthAvg');
        Route::any('/ding/get/user/department/week/attendance/avg', 'DingTalkController@departmentsWeekAvg');//
        Route::any('/ding/get/user', 'DingTalkController@user');
        Route::any('/ding/get/today', 'DingTalkController@today');
});