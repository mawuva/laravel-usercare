<?php

namespace Mawuekom\Usercare\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\ApiResourceLinks\ApiResourceLinks;

class UserProfilePictureResource extends JsonResource
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
        $userProfilePicturesTablePK    = config('usercare.user_profile_picture.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$userProfilePicturesTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$userProfilePicturesTablePK};

        $data = [
            'avatar' => [
                'title'     => $this ->avatar_title,
                'mime'      => $this ->avatar_mime,
                'url'       => $this ->avatar_url,
                'status'    => $this ->avatar_status,
            ],

            'bg_picture' => [
                'title'     => $this ->bg_picture_title,
                'mime'      => $this ->bg_picture_mime,
                'url'       => $this ->bg_picture_url,
                'status'    => $this ->bg_picture_status,
            ],
        ];

        return array_merge($dataID, $data);
    }
}