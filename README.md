# Usercase - A Users Management Package that includes many features arround user

This package provide a bunch of features that will help implement users management in your laravel project.

## Installation

You can install the package via composer:

```bash
composer require mawuekom/laravel-usercare
```

## Usage

Once install, go to `config/app.php` to add `UsercareServiceProvider` in providers array

 Laravel 5.5 and up Uses package auto discovery feature, no need to edit the `config/app.php` file.

 - #### Service Provider

```php
'providers' => [

    ...

    Mawuekom\Usercare\UsercareServiceProvider::class,

],
```

- #### Publish Assets

```bash
php artisan vendor:publish --provider="Mawuekom\Usercare\UsercareServiceProvider"
```

Or you can publish config

```bash
php artisan vendor:publish --provider="Mawuekom\Usercare\UsercareServiceProvider" --tag="config"
```

#### Configuration

* You can change connection for models, models path and there is also a handy pretend feature.
* There are many configurable options which have been extended to be able to configured via `.env` file variables.
* Editing the configuration file directly may not needed because of this.
* See config file: [usercare.php](https://github.com/mawuva/laravel-usercare/blob/main/config/usercare.php).

```php
<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'separator' => '.',

    /*
    |--------------------------------------------------------------------------
    | USERCARE feature settings
    |--------------------------------------------------------------------------
    */

    'account_type' => [
        'enable'                    => true,
        'name'                      => 'Account Type',
        'resource_name'             => 'account_type',
        'model'                     => null,

        'table'                     => [
            'name'                  => env('USERCARE_ACCOUNT_TYPES_DATABASE_TABLE', 'account_types'),
            'primary_key'           => env('USERCARE_ACCOUNT_TYPES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    'user' => [
        'model'                     => App\Models\User::class,
        'name'                      => 'User',
        'resource_name'             => 'user',

        'table'                     => [
            'name'                      => env('USERCARE_USERS_DATABASE_TABLE', 'users'),
            'primary_key'               => env('USERCARE_USERS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'account_type_foreign_key'  => env('USERCARE_USERS_DATABASE_TABLE_ACCOUNT_TYPE_FOREIGN_KEY', 'account_type_id'),
        ],
    ],

    'user_profile' => [
        'enable'                    => true,
        'model'                     => null,

        'table'                     => [
            'name'                      => env('USERCARE_PROFILES_DATABASE_TABLE', 'profiles'),
            'primary_key'               => env('USERCARE_PROFILES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'user_foreign_key'          => env('USERCARE_PROFILES_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],
    ],

    'user_profile_picture'          => [
        'enable'                    => true,
        'model'                     => null,

        'table'                     => [
            'name'                      => env('USERCARE_PROFILE_PICTURES_DATABASE_TABLE', 'profile_pictures'),
            'primary_key'               => env('USERCARE_PROFILE_PICTURES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'user_foreign_key'          => env('USERCARE_PROFILE_PICTURES_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],

        'default'                   => [
            'file_source_url'       => url('/'),
            'avatar'                => asset('/'), // asset('default-avatar.png')
            'bg_picture'            => asset('/'), // asset('default-bg-picture.png')
        ],
    ],

    'password_history' => [
        'checker'                   => false,
        'number_to_check'           => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Bunch of features to enable or disable.
    |--------------------------------------------------------------------------
    */

    'enable' => [
        'proper_names'          => true,
        'email_optionality'     => false,
        'phone_number'          => true,
        'gender'                => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Add uuid support
    |--------------------------------------------------------------------------
    */

    'uuids' => [
        'enable' => true,
        'column' => '_id'
    ],
];
```

## The rest is coming soon

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

