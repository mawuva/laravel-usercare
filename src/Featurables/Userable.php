<?php

namespace Mawuekom\Usercare\Featurables;

use Mawuekom\ModelUuid\Utils\GeneratesUuid;

trait Userable
{
    use GeneratesUuid;

    /**
     * The names of the columns that should be used for the UUID.
     *
     * @return array
     */
    public function uuidColumns(): array
    {
        return [config('usercare.uuids.column')];
    }
    
    /**
     * Set password attribute
     *
     * @param string $password
     *
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this ->attributes['password'] = $password;
    }
}