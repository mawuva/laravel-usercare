<?php

namespace Mawuekom\Usercare\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Mawuekom\ApiResourceLinks\ApiResourceLinks;
use Mawuekom\Usercare\Http\Resources\AccountTypeResource;

class AccountTypeCollection extends ResourceCollection
{
    use ApiResourceLinks;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => AccountTypeResource::collection($this ->collection),
            'meta' => [
                'total' => $this->collection->count(),
                'links' => $this ->collectionLinksDetails('account-types')
            ]
        ];
    }
}