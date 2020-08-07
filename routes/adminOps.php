<?php
Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
    Route::any('fabric/brand/save', 'FabricBrandController@save');
});