<?php

namespace Mawuekom\Usercare\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Mawuekom\ApiResourceLinks\ApiResourceLinks;
use Mawuekom\Usercare\Http\Resources\UserResource;

class UserCollection extends ResourceCollection
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
            'data' => UserResource::collection($this ->collection),
            'meta' => [
                'total' => $this->collection->count(),
                'links' => $this ->collectionLinksDetails('users')
            ]
        ];
    }
}