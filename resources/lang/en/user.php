<?php

return [

    /*
     * Labels
     */
    'administrator'         => 'Administrator',
    'banned_at'             => 'Banned since',
    'created_at'            => 'Registered at',
    'email'                 => 'E-mail address',
    'name'                  => 'Name',
    'not_banned'            => 'Not banned',
    'optional'              => 'Optional',
    'password'              => 'Password',
    'password_confirmation' => 'Confirm password',

    /*
     * Actions
     */
    'ban'                   => 'Ban user',
    'create'                => 'Create your account',
    'edit'                  => 'Edit user',
    'index'                 => 'User index',
    'show'                  => 'User details',
    'unban'                 => 'Unban user',
    'update'                => 'Update user',

    /*
     * Messages
     */
    'admin_granted'         => 'User :email is granted administrator privileges.',
    'admin_revoked'         => 'Administrator privileges revoked for user :email.',
    'banned'                => 'User :email is banned and cannot log in anymore.',
    'created'               => 'Your account was created successfully. Thank you for registering with us!',
    'creation_failed'       => 'We were not able to complete your registration. Please check your input and try again.',
    'missing_manage_users'  => 'Speelpenning\Contracts\Authentication\ManagesUsers contract is missing.',
    'unbanned'              => 'User :email is unbanned and may log in again.',

    /*
     * Console
     */
    'console' => [
        'created'           => 'User registered with the following password: :password',
    ],

];
