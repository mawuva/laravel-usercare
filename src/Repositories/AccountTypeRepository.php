<?php

namespace Mawuekom\Usercare\Repositories;

use Mawuekom\Repository\Eloquent\BaseRepository;

class AccountTypeRepository extends BaseRepository
{
    /**
     * Get the model on which works
     * 
     * @return Model|string
     */
    public function model()
    {
        return config('usercare.account_type.model');
    }

    /**
     * Get the columns on which the search will be done
     * 
     * @return array
     */
    public function searchableFields()
    {
        return ['name', 'slug'];
    }
}