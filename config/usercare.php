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
        /*
        | The name of the parameter you set in your web.php or api.php to get user's ID
        */
        'id_route_param'    => 'id',


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
        'enabled'           => true,
        'name'              => 'Account Type',
        'slug'              => 'account_type',
        'model'             => Mawuekom\Usercare\Models\AccountType::class,

        'table'             => [
            'name'          => env('USERCARE_ACCOUNT_TYPES_DATABASE_TABLE', 'account_types'),
            'primary_key'   => env('USERCARE_ACCOUNT_TYPES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],
];