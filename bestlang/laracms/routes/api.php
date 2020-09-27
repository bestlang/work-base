<?php
Route::group(['middleware' => 'auth:api'], function(){
    include('adminOps.php');
});

