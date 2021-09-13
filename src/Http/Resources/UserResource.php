<?php

namespace Mawuekom\Usercare\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\ApiResourceLinks\ApiResourceLinks;

class UserResource extends JsonResource
{
    use ApiResourceLinks;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        $uuidColumn             = config('usercare.uuids.column');
        $usersTablePK    = config('usercare.user.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$usersTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$usersTablePK};

        $data = [
            'name'              => $this ->name,
            'last_name'         => $this ->last_name, 
            'first_name'        => $this ->first_name,
            'full_name'         => $this ->full_name,
            'gender'            => $this ->gender,
            'email'             => $this ->email,
            'phone_number'      => $this ->phone_number,
            'links'             => $this ->resourceLinksDetails('users', $id),
            'profile'           => new UserProfileResource($this ->whenLoaded('profile')),
            'profile_picture'   => new UserProfilePictureResource($this ->whenLoaded('profilePicture')),
            'account_type'      => new AccountTypeResource($this ->whenLoaded('accountType')),
        ];

        return array_merge($dataID, $data);
    }
}