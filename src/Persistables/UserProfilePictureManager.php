<?php

namespace Mawuekom\Usercare\Persistables;

use Mawuekom\Usercare\Traits\ResourceDataManager;
use Illuminate\Database\Eloquent\Builder;

trait UserProfilePictureManager
{
    use ResourceDataManager;
    
    /**
     * Save user profile avatar picture
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function saveAvatar(int|string $user_id, array $data): array
    {
        $userProfilePicture = $this ->getAndSaveUserProfilePicture($user_id, [
            'avatar_title'      => check_key_in_array($data, 'avatar_title'),
            'avatar_mime'       => check_key_in_array($data, 'avatar_mime'),
            'avatar_url'        => check_key_in_array($data, 'avatar_url'),
            //'avatar_status'     => check_key_in_array($data, 'avatar_status'),
        ]); 

        return success_response(trans('usercare::messages.entity.saved', [
            'Entity' => trans('usercare::entity.attributes.avatar')
        ]), $userProfilePicture);
    }

    /**
     * Save user profile background picture
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function saveBgPicture(int|string $user_id, array $data): array
    {
        $userProfilePicture = $this ->getAndSaveUserProfilePicture($user_id, [
            'bg_picture_title'      => check_key_in_array($data, 'bg_picture_title'),
            'bg_picture_mime'       => check_key_in_array($data, 'bg_picture_mime'),
            'bg_picture_url'        => check_key_in_array($data, 'bg_picture_url'),
            'bg_picture_status'     => check_key_in_array($data, 'bg_picture_status'),
        ]); 

        return success_response(trans('usercare::messages.entity.saved', [
            'Entity' => trans('usercare::entity.attributes.background_picture')
        ]), $userProfilePicture);
    }

    /**
     * Get and save user profile picture
     * 
     * @param  int|string $user_id
     * @param array $data
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getAndSaveUserProfilePicture(int|string $user_id, array $data): Builder
    {
        $model = config('usercare.user_profile_picture.model');

        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);

        $checkUserProfilePicture = $model::checkUserProfilePicture($user ->id) ->first();

        if ($checkUserProfilePicture !== null) {
            $checkUserProfilePicture ->update($data);
        }

        else {
            $insert = array_merge($data, ['user_id' => $user ->id]);
            $model::create($insert);
        }

        return $user ->with('profilePicture');
    }
}