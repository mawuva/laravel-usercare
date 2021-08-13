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
        'enable'                    => true,
        'model'                     => null,
        'checker'                   => false,
        'number_to_check'           => 3,
        'name'                      => 'Password History',
        'resource_name'             => 'password_history',

        'table'                     => [
            'name'                  => env('USERCARE_PASSWORD_HISTORIES_DATABASE_TABLE', 'password_histories'),
            'primary_key'           => env('USERCARE_PASSWORD_HISTORIES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'user_foreign_key'      => env('USERCARE_PASSWORD_HISTORIES_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bunch of features to enable or disable.
    |--------------------------------------------------------------------------
    */

    'enable' => [
        'proper_names'          => true,
        'email_optionality'     => false,
        'phone_number'          => false,
        'gender'                => false,
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