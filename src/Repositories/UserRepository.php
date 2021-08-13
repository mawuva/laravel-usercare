<?php

namespace Mawuekom\Usercare\Repositories;

use Mawuekom\RepositoryLayer\BaseApiRepository;

class UserRepository extends BaseApiRepository
{
    public function model()
    {
        return config('usercare.user.model');
    }

    /**
     * Determine the columns on which the search will be done
     */
    public function searchFields(): array
    {
        return ['name', 'last_name', 'first_name', 'email', 'phone_number'];
    }
    
    /**
     * Columns on which filterig will be done
     */
    public function filters(): array
    {
        return ['name', 'last_name', 'first_name', 'email', 'gender', 'phone_number'];
    }

    /**
     * Determine by which property the results collection will be ordered
     */
    public function sorts(): array
    {
        return [];
    }

    /**
     * Determine the relation that will be load on the resulting model   collection
     */
    public function collectionRelation(): array
    {
        return ['accountType', 'profile', 'profilePicture'];
    }

    /**
     * Determine the relation that will be load on the resulting model resource
     */
    public function resourceRelation(): array
    {
        return ['accountType', 'profile', 'profilePicture'];
    }

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     */
    public function fields(): array
    {
        return [];
    }
}