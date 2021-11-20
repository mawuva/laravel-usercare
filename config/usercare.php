<?php

return [
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
            'model'         => null,
        
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
];