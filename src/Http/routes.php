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
        'as' => 'profile.show',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\ProfileController@show'
    ]);
    Route::get('profile/edit', [
        'as' => 'profile.edit',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\ProfileController@edit'
    ]);
    Route::patch('profile', [
        'as' => 'profile.update',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\ProfileController@update'
    ]);

    /*
     * Password routes
     */
    Route::get('password', [
        'as' => 'password.edit',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\PasswordController@edit'
    ]);
    Route::patch('password', [
        'as' => 'password.update',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\PasswordController@update'
    ]);

    /*
     * Password reset routes
     */
    Route::get('reset-your-password', [
        'as' => 'password-reset.create',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\PasswordResetController@create'
    ]);
    Route::post('reset-your-password', [
        'as' => 'password-reset.store',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\PasswordResetController@store'
    ]);
    Route::get('reset-your-password/{token}', [
        'as' => 'password-reset.edit',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\PasswordResetController@edit'
    ]);
    Route::patch('reset-your-password', [
        'as' => 'password-reset.update',
        'uses' => 'Speelpenning\Authentication\Http\Controllers\PasswordResetController@update'
    ]);

});
