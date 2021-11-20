<?php

namespace Mawuekom\Usercare\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Usercare\DataTransferObjects\UserProfileDTO;

class SaveUserProfileAction
{
    /**
     * Execute action
     *
     * @param int $id
     * @param \Mawuekom\Usercare\DataTransferObjects\UserProfileDTO $userProfileDTO
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(int $id, UserProfileDTO $userProfileDTO): Model
    {
        $profile = app(config('usercare.user.profile.model'));

        $checkProfile = $profile->checkUserProfile($id) ->first();

        if ($checkProfile !== null)
            $profile = $checkProfile;

        $profile->location      = $userProfileDTO ->location;
        $profile->bio           = $userProfileDTO ->bio;
        $profile->description   = $userProfileDTO ->description;

        if ($checkProfile === null)
            $profile->user_id   = $id;

        $profile ->save();

        return $profile;
    }
}