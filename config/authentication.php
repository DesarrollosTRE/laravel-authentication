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
     * Parent view
     *
     * The views that come with the package extend a basic Bootstrap master view, but my best guess is that you like
     * something fancier than a plain white page with a registration form. You can override the parent view by
     * setting the name of your view here.
     */
    'parentView' => env('AUTH_PARENT_VIEW', 'authentication::app'),


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
         *      off         Does not show the name field.
         *      required    Shows the name field and makes it required.
         */
        'userName' => env('AUTH_REGISTRATION_USERNAME', 'on'),

    ],

    /*
     * Password options
     */
    'password' => [

        /*
         * Minimum password length (in characters)
         */
        'minLength' => env('AUTH_REGISTRATION_MIN_PASSWORD_LENGTH', 8),

    ],

];
