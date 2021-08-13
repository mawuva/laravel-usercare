<?php

namespace Mawuekom\Usercare\Featurables;

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
        $profile_model = config('usercare.user_profile.model');
        $profiles_table_user_fk = config('usercare.user_profile.table.user_foreign_key');
        $users_table_pk = config('usercare.user.table.primary_key');

        return $this ->hasOne($profile_model, $profiles_table_user_fk, $users_table_pk);
    }

    /**
     * User has profile picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profilePicture(): HasOne
    {
        $profile_picture_model = config('usercare.user_profile_picture.model');
        $profile_pictures_table_user_fk = config('usercare.user_profile_picture.table.user_foreign_key');
        $users_table_pk = config('usercare.user.table.primary_key');

        return $this ->hasOne($profile_picture_model, $profile_pictures_table_user_fk, $users_table_pk);
    }
}