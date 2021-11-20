<?php

namespace Mawuekom\Usercare\Contracts\Assignables;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasAccountType
{
    /**
     * User belongs to account type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountType(): BelongsTo;
}