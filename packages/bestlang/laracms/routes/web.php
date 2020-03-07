<?php
Route::group(['prefix' => 'cms'], function ($router) {
    Route::get('/', 'IndexController@index');
    Route::get('/cms', 'IndexController@cms');
    Route::get('/about', 'IndexController@about');
    Route::get('/contact', 'IndexController@contact');

    Route::get('/content/{id}', 'ContentController@index');
    Route::get('/channel/{id}', 'ChannelController@index');
    Route::any('/comment/save', 'CommentController@save');
});