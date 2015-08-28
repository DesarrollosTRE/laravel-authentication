# Authentication for Laravel 5.1

[![Build Status](https://travis-ci.org/Speelpenning-nl/laravel-authentication.svg)](https://travis-ci.org/Speelpenning-nl/laravel-authentication)
[![codecov.io](http://codecov.io/github/Speelpenning-nl/laravel-authentication/coverage.svg?branch=master)](http://codecov.io/github/Speelpenning-nl/laravel-authentication?branch=master)
[![Latest Stable Version](https://poser.pugx.org/speelpenning/laravel-authentication/version)](https://packagist.org/packages/speelpenning/laravel-authentication)
[![Latest Unstable Version](https://poser.pugx.org/speelpenning/laravel-authentication/v/unstable)](//packagist.org/packages/speelpenning/laravel-authentication)
[![License](https://poser.pugx.org/speelpenning/laravel-authentication/license)](https://packagist.org/packages/speelpenning/laravel-authentication)

This package is made to quick start a highly configurable authentication for your Laravel application. It provides:
- A basic user model (Eloquent), which is uses the user table migration that comes with Laravel
- A user controller for registration
- A session controller for logging in and logging out
- Twitter bootstrap views with reusable forms
- Events to hook your listeners on (logging, notifications, e-mails, etc.)

## List of events

```php
Speelpenning\Authentication\Events\UserHasLoggedIn
Speelpenning\Authentication\Events\UserHasLoggedOut
Speelpenning\Authentication\Events\UserWasRegistered
Speelpenning\Authentication\Events\UserWasRemembered
```

## Configuration

To avoid publishing the config, all configuration can be done through the .env file.

### Enable routes

The routes included with the package are disabled by default to avoid conflicts with your application. They can be enabled like so:

```ini
AUTH_ENABLE_ROUTES=true
```
Default value: false

### Parent view

The package comes with a plain white bootstrap parent view. Maybe that satisfies the needs for a backend application, but if you are not very much charmed by that, change it with the following line:

```ini
AUTH_PARENT_VIEW=<view-name>
```
Default value: authentication::app

Each view fills two sections: title and content.

### Registration options

#### User's name field

This option switches the user's name field on, off or makes it a required field.

```ini
AUTH_REGISTRATION_USERNAME=[on|off|required]
```
Default value: on

#### Redirect URI

After a successful registration the user will be redirected to this URI. This must be a valid URI within your application, since the redirect() helper function is handling the redirect.

```ini
AUTH_REGISTRATION_REDIRECT_URI=<uri>
```
Default value: /

### Password options

#### Minimum password length

```ini
AUTH_PASSWORD_MIN_LENGTH=<length>
```
Default value: 8

### Login options

#### Remember me

If you want to offer your users the convenience of remembering their login, switch this option to on.

```ini
AUTH_LOGIN_REMEMBER_ME=[on|off|default]
```
Default value: off

#### Redirect URI

After a successful login attempt, the user will be redirected to this URI.  This must be a valid URI within your application, since the redirect() helper function is handling the redirect.

```ini
AUTH_LOGIN_REDIRECT_URI=<uri>
```
Default value: /

### Logout options
 
#### Redirect URI

After a logout is performed, the user will be redirected to this URI. This must be a valid URI within your application, since the redirect() helper function is handling the redirect.

```ini
AUTH_LOGIN_REDIRECT_URI=<uri>
```
Default value: /
