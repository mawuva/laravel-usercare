<?php

return [
    /*
    | Slug separator
    */
    'separator' => '.',


    /*
    | Manage user config
    */
    'user'  => [
        'slug'              => config('custom-user.user.slug'),
        /*
        | The name of the parameter you set in your web.php or api.php to get user's ID
        */
        'id_route_param'    => 'id',

        /**
         * User's table congig
         */
        'table'             => [
            'account_type_foreign_key'  => env('USERCARE_USERS_DATABASE_TABLE_ACCOUNT_TYPE_FOREIGN_KEY', 'account_type_id'),
        ],

        /*
        | User's profile config
        */

        'profile'       => [
            'enabled'       => true,
            'model'         => Mawuekom\Usercare\Models\Profile::class,
        
            /*
            | User's profile table config
            */

            'table'         => [
                'name'              => env('USERCARE_PROFILES_DATABASE_TABLE', 'profiles'),
                'primary_key'       => env('USERCARE_PROFILES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
                'user_foreign_key'  => env('USERCARE_PROFILES_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
            ],
        ],
    ],

    /*
    | Manage account type config
    |
    | You may want to use multiple account type as : 
    | Guest account, Premium account, etc.
    */
    'account_type'          => [
        'enabled'           => false,
        'name'              => 'Account Type',
        'slug'              => 'account_type',
        'model'             => Mawuekom\Usercare\Models\AccountType::class,

        /*
        | The name of the parameter you set in your web.php or api.php to get account type's ID
        */
        'id_route_param'    => 'id',

        'table'             => [
            'name'          => env('USERCARE_ACCOUNT_TYPES_DATABASE_TABLE', 'account_types'),
            'primary_key'   => env('USERCARE_ACCOUNT_TYPES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Add uuid support
    |--------------------------------------------------------------------------
    */

    'uuids'     => [
        'enabled'   => config('custom-user.uuids.enabled'),
        'column'    => config('custom-user.uuids.column')
    ],
];