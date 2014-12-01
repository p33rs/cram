<?php

Route::pattern('id', '[0-9]+');

Route::get('/', ['uses' => 'PagesController@landing', 'as' => 'landing']);
Route::post('login', ['uses' => 'UsersController@login', 'as' => 'login']);
Route::get('logout', ['uses' => 'UsersController@logout', 'as' => 'logout']);
Route::post('signup', ['uses' => 'UsersController@signup', 'as' => 'signup']);
Route::get('account', ['uses' => 'UsersController@account', 'as' => 'account']);
Route::post('account/save', ['uses' => 'UsersController@accountSave', 'as' => 'account/save']);
Route::get('photos', ['uses' => 'PhotosController@index', 'as' => 'photos']);
Route::get('photos/new', ['uses' => 'PhotosController@new', 'as' => 'photos/new']);

Route::group(['prefix' => 'user', 'before' => 'auth'], function() {
    Route::get('{id}', ['uses' => 'PhotosController@index', 'as' => 'user/photos']);
    Route::post('{id}/follow', ['uses' => 'UsersController@follow', 'as' => 'user/follow']);
});

Route::group(['prefix' => 'photo', 'before' => 'auth'], function() {
    Route::get('upload', ['uses' => 'PhotosController@upload', 'as' => 'photo/upload']);
    Route::group(['prefix' => '{id}'], function() {
        Route::get('/', ['uses' => 'PhotosController@view', 'as' => 'photo']);
        Route::get('raw', ['uses' => 'PhotosController@raw', 'as' => 'photo/raw']);
        Route::post('comment', ['uses' => 'PhotosController@comment', 'as' => 'photo/comment']);
        Route::post('delete', ['uses' => 'PhotosController@delete', 'as' => 'photo/delete']);
        Route::post('like', ['uses' => 'PhotosController@like', 'as' => 'photo/like']);
    });
});

