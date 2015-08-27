# Authentication for Laravel 5.1

This package is build to quick start authentication for your Laravel application. It provides:
- A simple user model (Eloquent), which is stored in the user table that comes with Laravel
- User controller for registration
- Session controller for login and logout
- Twitter bootstrap views
- Events to hook your listeners on 

## Events

```php
Speelpenning\Authentication\Events\UserWasRegistered    // Fired after a successful registration
Speelpenning\Authentication\Events\UserHasLoggedIn      // Fired after a successful login attempt
```

## Configuration

To avoid publishing the config, all configuration can be done through the .env file.

### Enable routes

The routes included in the package are disabled by default to avoid conflicts with your application. The default routes can be enabled like so:

```ini
AUTH_ENABLE_ROUTES=true
```
Default value: false

### Parent view

The package comes with a plain white bootstrap parent view. Maybe that satisfies your needs, but if you are not very much charmed by it you can change it with the following line:

```ini
AUTH_PARENT_VIEW=<view-name>
```
Default value: authentication::app

Each view fills two sections: title and content.

### Registration options

#### User name field

This option switches the user name field on, off or makes it a required field.

```ini
AUTH_REGISTRATION_USERNAME=[on|off|required]
```
Default value: on

#### Redirect URI

After a successful registration the user will be redirected to this URI.

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
 
#### Redirect URI

After a successful login attempt, the user will be redirected to this URI.

```ini
AUTH_LOGIN_REDIRECT_URI=<uri>
```
Default value: /

### Logout options
 
#### Redirect URI

After a logout is performed, the user will be redirected to this URI.

```ini
AUTH_LOGIN_REDIRECT_URI=<uri>
```
Default value: /
