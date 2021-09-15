<?php

namespace Mawuekom\Usercare\Traits;

use Exception;
use Illuminate\Http\Response;

trait DataRecordsChecker
{
    /**
     * Check if the given resource is not null
     *
     * @param [type] $resource
     * @param string $message
     * @param int $code
     * @param bool $exception
     *
     * @return array
     */
    public function checkDataResource($resource, string $message, int $code = Response::HTTP_NOT_FOUND, $exception = false)
    {
        if (is_null($resource)) {
            if ($exception) {
                throw new Exception($message, $code);
            }

            return failure_response($message, null, $code);
        }
    }

    /**
     * Check if the given records or collection contains data or not
     *
     * @param [type] $records
     * @param string $message
     * @param int $code
     * @param bool $exception
     * 
     * @throws Exception
     *
     * @return array
     */
    public function checkDataRecords($records, string $message, int $code = Response::HTTP_NO_CONTENT, $exception = false): array
    {
        if ($records ->count() === 0) {
            if ($exception) {
                throw new Exception($message, $code);
            }

            return failure_response($message, null, $code);
        }
    }
}