<?php

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