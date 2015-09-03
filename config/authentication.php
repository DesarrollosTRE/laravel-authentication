<?php

return [

    /*
     * Enable routes
     *
     * The routes included in the package are disabled by default to avoid conflicts with your application. If you
     * wish to use the default routes, set this option to true.
     */
    'enableRoutes' => env('AUTH_ENABLE_ROUTES', false),

    /*
     * Parent view and e-mail view
     *
     * The views that come with the package extend a basic Bootstrap master view, but my best guess is that you like
     * something fancier than a plain white page with a registration form. You can override the parent and e-mail
     * view by setting the name of your view here.
     */
    'parentView' => env('AUTH_PARENT_VIEW', 'authentication::app'),
    'emailView' => env('AUTH_EMAIL_VIEW', 'authentication::email'),

    /*
     * Registration options
     */
    'registration' => [

        /*
         * User name
         *
         * By default the user's name field is shown, but not required. You can change the default behaviour to:
         *
         *      on          Shows the name field, but it is not required.
         *      off         Hides the name field.
         *      required    Shows the name field and makes it required.
         */
        'userName' => env('AUTH_REGISTRATION_USERNAME', 'on'),

        /*
         * Redirect URI
         *
         * After a successful registration, the user is redirected to the home page. With this option you can
         * configure a different destination.
         */
        'redirectUri' => env('AUTH_REGISTRATION_REDIRECT_URI', '/'),

    ],

    /*
     * Password options
     */
    'password' => [

        /*
         * Minimum password length (in characters)
         */
        'minLength' => env('AUTH_PASSWORD_MIN_LENGTH', 8),

    ],

    /*
     * Password reset options
     */
    'passwordReset' => [

        /*
         * E-mail view
         *
         * Set the name of your e-mail here to override the package's default view.
         */
        'email' => env('AUTH_PASSWORD_RESET_EMAIL', 'authentication::emails.password-reset'),

        /*
         * Sender details
         *
         *      email   The e-mail address that is used for sending reset tokens.
         *      name    The name that is used as sender.
         */
        'from' => [
            'email' => env('AUTH_PASSWORD_RESET_FROM_EMAIL', config('mail.from.address')),
            'name' => env('AUTH_PASSWORD_RESET_FROM_ADDRESS', config('mail.from.name')),
        ],

        /*
         * Expire time (in minutes)
         */
        'expiresAfter' => env('AUTH_PASSWORD_RESET_EXPIRES_AFTER', config('auth.password.expire')),

    ],

    /*
     * Login options
     */
    'login' => [

        /*
         * Remember me
         *
         * You can offer your users the convenience of remembering their login by switching this option to on
         * or default.
         *
         *      on          Shows the remember me checkbox.
         *      off         Hides the remember me checkbox.
         *      default     Checks the remember me checkbox by default.
         */
        'rememberMe' => env('AUTH_LOGIN_REMEMBER_ME', 'off'),

        /*
         * Redirect URI
         *
         * After a successful login attempt, the user is redirected to the homepage. With this option you can
         * configure a different destination.
         */
        'redirectUri' => env('AUTH_LOGIN_REDIRECT_URI', '/'),

    ],

    /*
     * Logout options
     */
    'logout' => [

        /*
         * Redirect URI
         *
         * After logging out, the user is redirected to the homepage. With this option you can configure a
         * different destination.
         */
        'redirectUri' => env('AUTH_LOGOUT_REDIRECT_URI', '/'),

    ],

];
