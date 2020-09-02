<?php
Route::group(['middleware' => 'auth.jwt'], function(){
    include('adminOps.php');
});
/*Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
    Route::any('/file/upload/ueditor', 'UploadController@ueditor');
});*/

