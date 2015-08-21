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



    ],

];
