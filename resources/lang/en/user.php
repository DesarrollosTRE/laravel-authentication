<?php

return [

    /*
     * Labels
     */
    'administrator'         => 'Administrator',
    'created_at'            => 'Registered at',
    'email'                 => 'E-mail address',
    'name'                  => 'Name',
    'optional'              => 'Optional',
    'password'              => 'Password',
    'password_confirmation' => 'Confirm password',

    /*
     * Actions
     */
    'create'                => 'Create your account',
    'edit'                  => 'Edit user',
    'index'                 => 'User index',
    'show'                  => 'User details',
    'update'                => 'Update user',

    /*
     * Messages
     */
    'admin_granted'         => 'User :email is granted administrator privileges.',
    'admin_revoked'         => 'Administrator privileges revoked for user :email.',
    'created'               => 'Your account was created successfully. Thank you for registering with us!',
    'creation_failed'       => 'We were not able to complete your registration. Please check your input and try again.',
    'missing_manage_users'  => 'Speelpenning\Contracts\Authentication\ManagesUsers contract is missing.',

    /*
     * Console
     */
    'console' => [
        'created'           => 'User registered with the following password: :password',
    ],

];
