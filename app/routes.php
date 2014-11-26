<?php

Route::pattern('id', '[0-9]+');

Route::get('/', ['uses' => 'Pages@landing', 'as' => 'landing']);
Route::get('login', ['uses' => 'Users@login']);
Route::get('logout', ['uses' => 'Users@logout']);
Route::get('signup', ['uses' => 'Users@signup']);
Route::get('account', ['uses' => 'Users@account']);
Route::get('account/save', ['uses' => 'Users@accountSave']);
Route::get('home', ['uses' => 'Users@home']);

Route::group(['prefix' => 'user', 'before' => 'auth'], function() {
    Route::get('{id}', ['uses' => 'Photos@index']);
    Route::get('{id}/follow', ['uses' => 'Users@follow']);
});

Route::group(['prefix' => 'photo', 'before' => 'auth'], function() {
    Route::get('upload', ['uses' => 'Photos@upload']);
    Route::group(['prefix' => '{id}'], function() {
        Route::get('/', ['uses' => 'Photos@view']);
        Route::get('delete', ['uses' => 'Photos@delete']);
        Route::get('like', ['uses' => 'Photos@like']);
    });
});

