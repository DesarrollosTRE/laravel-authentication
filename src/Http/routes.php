<?php

Route::group(['as' => 'authentication::'], function () {

    /*
     * Registration routes
     */
    Route::get('create-your-account', [
        'as' => 'user.create',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\UserController@create'
    ]);
    Route::post('create-your-account', [
        'as' => 'user.store',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\UserController@store'
    ]);

    /*
     * Authentication routes
     */
    Route::get('login-to-your-account', [
        'as' => 'session.create',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\SessionController@create'
    ]);
    Route::post('login-to-your-account', [
        'as' => 'session.store',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\SessionController@store'
    ]);
    Route::get('logout', [
        'as' => 'session.destroy',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\SessionController@destroy'
    ]);

    /*
     * Profile routes
     */
    Route::get('profile', [
        'as' => 'user.show',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\ProfileController@show'
    ]);
    Route::get('profile/edit', [
        'as' => 'user.edit',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\ProfileController@edit'
    ]);
    Route::patch('profile', [
        'as' => 'user.update',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\ProfileController@update'
    ]);

});
