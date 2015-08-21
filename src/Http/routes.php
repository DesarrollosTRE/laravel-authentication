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

});
