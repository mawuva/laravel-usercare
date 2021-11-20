<?php

namespace Mawuekom\Usercare\DataHelper;

use Illuminate\Http\Response;
use Mawuekom\CustomUser\Facades\CustomUser;
use Mawuekom\Usercare\Actions\SaveUserProfileAction;
use Mawuekom\Usercare\DataTransferObjects\UserProfileDTO;

trait UserProfileHelper
{
    /**
     * Get user's profile
     *
     * @param int|string $id
     *
     * @return array
     */
    public function getUserProfile($id): array
    {
        $user = CustomUser::getUserById($id);

        if (is_null($user)) {
            return failure_response(trans('lang-resources::messages.resource.not_found'), null, Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response(trans('lang-resources::messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.user_profile', 1)
            ]), $user ->with('profile') ->first());
        }
    }

    /**
     * Save or udate user's profile
     *
     * @param int|string $id
     * @param \Mawuekom\Usercare\DataTransferObjects\UserProfileDTO $userProfileDTO
     *
     * @return array
     */
    public function updateProfile($id, UserProfileDTO $userProfileDTO): array
    {
        $user = CustomUser::getUserById($id, false, ['id', 'name', 'email']);

        app(SaveUserProfileAction::class) ->execute($user ->id, $userProfileDTO);

        return success_response(
            trans('lang-resources::commons.messages.completed.update'), 
            $user ->with('profile') ->first()
        );
    }
}