<?php

namespace Mawuekom\Usercare\Contracts\Assignables;

use Illuminate\Database\Eloquent\Relations\HasOne;

interface HasProfile
{
    /**
     * User has profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne;
}