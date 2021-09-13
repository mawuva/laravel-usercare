<?php

use Faker\Factory;
use Illuminate\Support\Facades\Schema;

if (!function_exists('uuid_is_enabled_and_has_column')) {
    /**
     * Check if uuid is enabled and has column defined in config.
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_column(): bool {
        $uuid_enable    = config('usercare.uuids.enable');
        $uuid_column    = config('usercare.uuids.column');

        return ($uuid_enable && $uuid_column !== null)
                ? true
                : false;
    }
}

if (!function_exists('uuid_is_enabled_and_has_been_detected')) {
    /**
     * Check if uuid is enabled and has been detected.
     * 
     * @param string $resource
     * @param int|string $id
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_been_detected(string $resource, int|string $id = null, $inTrashed = false): bool {
        $model = config('usercare.'.$resource.'.model');
        $uuidColumn = config('usercare.uuids.column');

        return (config('usercare.uuids.enable') && is_the_given_id_a_uuid($uuidColumn, $id, $model, $inTrashed))
                ? true
                : false;
    }
}

if (!function_exists('resolve_key')) {
    /**
     * Get key to use to make queries
     * 
     * @param string $resource
     * @param int|string $id
     * 
     * @return string
     */
    function resolve_key(string $resource, int|string $id = null, $inTrashed = false): string {
        $uuidColumn = config('usercare.uuids.column');
        $resourcePrimaryKey = config('usercare.'.$resource.'.table.primary_key');

        return (uuid_is_enabled_and_has_been_detected($resource, $id, $inTrashed))
                ? $uuidColumn
                : $resourcePrimaryKey;
    }
}


if ( ! function_exists('generate_random_username')) {
    /**
     * Generate username from random string
     *
     * @param int $min
     * @param int $max
     * 
     * @return string
     */
    function generate_random_username(int $min = 3, int $max = 12, $rand_bytes = true): string {
        $faker = Factory::create();

        $str = '';
        $nbr = '';

        for ($i = 0; $i < rand($min, $max); $i++) {
            $str .= '?';
            $nbr .= '#';
        }

        return ($rand_bytes)
                ? $faker->bothify($str.'-'.$nbr) . '-' . bin2hex(random_bytes(rand($min, $max)))
                : $faker->bothify($str.$nbr);
    }
}

if (!function_exists('account_type_is_enabled_and_exists')) {
    /**
     * Check if account types is enabled and exists in schema.
     * 
     * @return bool
     */
    function account_type_is_enabled_and_exists(): bool {
        $account_types_enable = config('usercare.account_type.enable');
        $account_types_table  = config('usercare.account_type.table.name');

        return ($account_types_enable && Schema::hasTable($account_types_table))
                ? true
                : false;
    }
}

if (!function_exists('schema_has_proper_names_columns')) {
    /**
     * Check if schema has proper names columns.
     * 
     * @return bool
     */
    function schema_has_proper_names_columns(): bool {
        $table = config('usercare.user.table.name');

        return (Schema::hasColumn($table, 'last_name') && Schema::hasColumn($table, 'first_name'))
                ? true
                : false;
    }
}

if (!function_exists('proper_names_is_enabled_and_does_not_exist')) {
    /**
     * Check if proper names is enabled and exists in schema.
     * 
     * @return bool
     */
    function proper_names_is_enabled_and_does_not_exist(): bool {
        $proper_names_enabled = config('usercare.enable.proper_names');

        return ($proper_names_enabled && !schema_has_proper_names_columns())
                ? true
                : false;
    }
}

if (!function_exists('proper_names_is_enabled_and_exists')) {
    /**
     * Check if proper names is enabled and exists in schema.
     * 
     * @return bool
     */
    function proper_names_is_enabled_and_exists(): bool {
        $proper_names_enabled = config('usercare.enable.proper_names');

        return ($proper_names_enabled && schema_has_proper_names_columns())
                ? true
                : false;
    }
}

if (!function_exists('schema_has_phone_number_column')) {
    /**
     * Check if schema has phone number column.
     * 
     * @return bool
     */
    function schema_has_phone_number_column(): bool {
        $table = config('usercare.user.table.name');

        return (Schema::hasColumn($table, 'phone_number'))
                ? true
                : false;
    }
}

if (!function_exists('phone_number_is_enabled_and_exists')) {
    /**
     * Check if phone number is enabled and exists in schema.
     * 
     * @return bool
     */
    function phone_number_is_enabled_and_exists(): bool {
        $phone_number_enabled = config('usercare.enable.phone_number');

        return ($phone_number_enabled && schema_has_phone_number_column())
                ? true
                : false;
    }
}

if (!function_exists('schema_has_gender_column')) {
    /**
     * Check if schema has gender column.
     * 
     * @return bool
     */
    function schema_has_gender_column(): bool {
        $table = config('usercare.user.table.name');

        return (Schema::hasColumn($table, 'gender'))
                ? true
                : false;
    }
}

if ( ! function_exists('success_response')) {
    /**
     * Generate username from random string
     *
     * @param string $message
     * @param array|null|Object $data
     * @param int $code
     * 
     * @return array
     */
    function success_response(string $message = 'Action performed successfully', $data = null, int $code = 200): array {
        return [
            'code'      => $code,
            'status'    => 'success',
            'message'   => $message,
            'data'      => $data,
        ];
    }
}

if ( ! function_exists('failure_response')) {
    /**
     * Generate username from random string
     *
     * @param string $message
     * @param array|null|Object $data
     * @param int $code
     * 
     * @return array
     */
    function failure_response(string $message = 'Action attempted failed', $data = null, int $code = 0): array {
        return [
            'code'      => $code,
            'status'    => 'failed',
            'message'   => $message,
            'data'      => $data,
        ];
    }
}

if ( ! function_exists('check_key_in_array')) {
    /**
     * Chef if a key exists in array
     *
     * @param array $array
     * @param string $key
     * 
     * @return string
     */
    function check_key_in_array(array $array = [], string $key = '') {
        if (is_array($array) && !empty($key)) {
            if (key_exists($key, $array)) {
                if ($array[$key] != null) {
                    return $array[$key];
                }
            }
        }
    }
}
