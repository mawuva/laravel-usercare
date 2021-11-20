<?php

namespace Mawuekom\Usercare\Assignables;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasProfile
{
    /**
     * User has profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        $profileModel           = config('usercare.user.profile.model');
        $profilesTableUserFK    = config('usercare.user.profile.table.user_foreign_key');
        $usersTablePK           = config('custom-user.user.table.primary_key');

        return $this ->hasOne($profileModel, $profilesTableUserFK, $usersTablePK);
    }
}