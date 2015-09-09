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

## Getting started

### Installation

Pull in the package by Composer:

```bash
composer require speelpenning/laravel-authentication
```

Add the service provider to app.php:
 
```php
Speelpenning\Authentication\AuthenticationServiceProvider::class,
```

### The user model

There are two options for implementation: using the model that comes with the package or strip App\User and let it extend the package's user model. Most likely you choose to extend, so you can add your own logic and relationships to the model.

For just using the package's model, change the model entry in auth.php like so:

```php
'model' => Speelpenning\Authentication\User::class,
```

Extending can be done like so:

```php
<?php namespace App;

use Speelpenning\Authentication\User as BaseUser;

class User extends BaseUser
{

    //

}
```

### Routes

Route name                            | Description
------------------------------------- | ---------------------------------------------------------
authentication::user.create           | Displays the registration form
authentication::session.create        | Displays the login form
authentication::profile.show          | Displays the user's profile
authentication::session.destroy       | Performs a user logout (shown on profile.show)
authentication::profile.edit          | Displays the edit profile form (shown on profile.show)
authentication::password.edit         | Displays the change password form (shown on profile.show)
authentication::password-reset.create | Displays the form for requesting a password reset link

> All routes have a translation entry equal to the route name, e.g. trans('authentication::user.create').

### Integration in your app

For this, I recommend you to read the configuration section below. When you have a configuration that satisfies your needs, you may add some listeners to the following events:

```php
Speelpenning\Authentication\Events\PasswordResetLinkWasSent::class
Speelpenning\Authentication\Events\PasswordWasChanged::class
Speelpenning\Authentication\Events\PasswordWasReset::class
Speelpenning\Authentication\Events\UserHasLoggedIn::class
Speelpenning\Authentication\Events\UserHasLoggedOut::class
Speelpenning\Authentication\Events\UserHasLoginHasFailed::class
Speelpenning\Authentication\Events\UserWasRegistered::class
Speelpenning\Authentication\Events\UserWasRemembered::class
Speelpenning\Authentication\Events\UserWasUpdated::class
```

## Configuration

To avoid publishing the config, all configuration can be done through the .env file.

### Enable routes

The routes included with the package are disabled by default to avoid conflicts with your application. They can be enabled like so:

```ini
AUTH_ENABLE_ROUTES=[true|false]
```
Default value: false

### Parent and e-mail view

The package comes with a plain white bootstrap parent view. Maybe that satisfies your needs, but if you are not very much charmed by that, change it with the following line:

```ini
AUTH_APP_VIEW=<view-name>
```
Default value: authentication::app

```ini
AUTH_EMAIL_VIEW=<view-name>
```
Default value: authentication::email

### Registration options

#### Allow or disallow public registration

```ini
AUTH_REGISTRATION_ALLOW_PUBLIC=[true|false]
```
Default value: true

> When disallowing public registration, users can ben registered with
```bash
php artisan user:register <email> [<name>] [--with-reset]
```

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

### Password reset options

#### E-mail view

Set the name of your e-mail here to override the package's default view. The view receives the user ($user) and password reset model ($passwordReset).

```ini
AUTH_PASSWORD_RESET_EMAIL=<view-name>
```
Default value: authentication::emails.password-reset

#### Sender details

```ini
AUTH_PASSWORD_RESET_FROM_EMAIL=<email-address>
```
Default value: config('mail.from.address')

```ini
AUTH_PASSWORD_RESET_FROM_NAME=<sender-name>
```
Default value: config('mail.from.name')

#### Subject

```ini
AUTH_PASSWORD_RESET_SUBJECT=<key>
```
Default value: authentication::password-reset.subject

#### Token expire time (in minutes)

```ini
AUTH_PASSWORD_RESET_EXPIRES_AFTER=<minutes>
```
Default value: config('auth.password.expire')
