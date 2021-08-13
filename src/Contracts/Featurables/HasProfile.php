<?php

namespace Mawuekom\Usercare\Contracts\Featurables;

use Illuminate\Database\Eloquent\Relations\HasOne;

interface HasProfile
{
    /**
     * User has profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne;

    /**
     * User has profile picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profilePicture(): HasOne;
}