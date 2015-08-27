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

});
