<?php

namespace Mawuekom\Usercare\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\ApiResourceLinks\ApiResourceLinks;

class UserProfileResource extends JsonResource
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
        $userProfilesTablePK    = config('usercare.user_profile.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$userProfilesTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$userProfilesTablePK};

        $data = [
            'location'          => $this ->location,
            'bio'     => $this ->bio,
        ];

        return array_merge($dataID, $data);
    }
}