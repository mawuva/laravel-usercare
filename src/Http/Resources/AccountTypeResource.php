<?php

namespace Mawuekom\Usercare\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\ApiResourceLinks\ApiResourceLinks;
use Mawuekom\Usercare\Http\Resources\Collections\UserCollection;

class AccountTypeResource extends JsonResource
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
        $accountTypesTablePK    = config('usercare.account_type.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$accountTypesTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$accountTypesTablePK};

        $data = [
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
            'links'         => $this ->resourceLinksDetails('account-types', $id),
            'users'         => new UserCollection($this ->whenLoaded('users'))
        ];

        return array_merge($dataID, $data);
    }
}

