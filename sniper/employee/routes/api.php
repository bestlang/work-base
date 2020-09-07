<?php
Route::group(['middleware' => 'auth.jwt'], function(){
    include('adminOps.php');
});

