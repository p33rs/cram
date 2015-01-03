<?php

Route::pattern('id', '[0-9]+');

Route::get('/', ['uses' => 'PagesController@landing', 'as' => 'landing']);

Route::post('login', ['uses' => 'UsersController@login', 'as' => 'login']);
Route::post('logout', ['uses' => 'UsersController@logout', 'as' => 'logout']);
Route::post('signup', ['uses' => 'UsersController@signup', 'as' => 'signup']);

Route::group(['prefix' => 'user', 'before' => 'auth'], function() {
    Route::put('/', ['uses' => 'UsersController@update', 'as' => 'user/update']);
    Route::group(['prefix' => '{username}'], function() {
        Route::get('/', ['uses' => 'UsersController@read', 'as' => 'user/read']);
        Route::post('/follow', ['uses' => 'UsersController@follow', 'as' => 'user/follow']);
        Route::post('/unfollow', ['uses' => 'UsersController@unfollow', 'as' => 'user/unfollow']);
    });
});

Route::group(['prefix' => 'photo', 'before' => 'auth'], function() {
    Route::post('/', ['uses' => 'PhotosController@create', 'as' => 'photo/create']);
    Route::get('/', ['uses' => 'PhotosController@read', 'as' => 'photo/list']);
    Route::group(['prefix' => '{id}'], function() {
        Route::get('/', ['uses' => 'PhotosController@read', 'as' => 'photo/view']);
        Route::get('.jpg', ['uses' => 'PhotosController@raw', 'as' => 'photo/raw']);
        Route::put('/', ['uses' => 'PhotosController@update', 'as' => 'photo/update']);
        Route::delete('/', ['uses' => 'PhotosController@delete', 'as' => 'photo/delete']);
        Route::post('/like', ['uses' => 'PhotosController@like', 'as' => 'photo/like']);
        Route::post('/unlike', ['uses' => 'PhotosController@unlike', 'as' => 'photo/unlike']);
    });
});

Route::group(['prefix' => 'comment', 'before' => 'auth'], function() {
    Route::post('/', ['uses' => 'CommentsController@create', 'as' => 'comment/create']);
    Route::get('/', ['uses' => 'CommentsController@read', 'as' => 'comment/list']);
    Route::group(['prefix' => '{id}'], function() {
        Route::get('/', ['uses' => 'CommentsController@read', 'as' => 'comment/view']);
    });
});