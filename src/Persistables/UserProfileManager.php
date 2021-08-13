<?php

namespace Mawuekom\Usercare\Persistables;

use Mawuekom\Usercare\Traits\ResourceDataManager;
use Illuminate\Database\Eloquent\Builder;

trait UserProfileManager
{
    use ResourceDataManager;

    /**
     * Save user profile datas
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function saveDatas(int|string $user_id, array $data): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);

        $userProfile = $this ->getAndSaveUserProfileDatas($user_id, [
            'location'      => check_key_in_array($data, 'location'),
            'bio'           => check_key_in_array($data, 'bio'),
            'description'   => check_key_in_array($data, 'description'),
        ]); 

        return success_response(trans('usercare::messages.entity.saved', [
            'Entity' => trans_choice('usercare::entity.user_profile', 1)
        ]), $userProfile);
    }

    /**
     * Get and save user profile datas
     * 
     * @param  int|string $user_id
     * @param array $data
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getAndSaveUserProfileDatas(int|string $user_id, array $data): Builder
    {
        $model = config('usercare.user_profile.model');

        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);

        $checkUserProfile = $model::checkUserProfile($user ->id) ->first();

        if ($checkUserProfile !== null) {
            $checkUserProfile ->update($data);
        }

        else {
            $insert = array_merge($data, ['user_id' => $user ->id]);
            $model::create($insert);
        }

        return $user ->with('profile');
    }
}