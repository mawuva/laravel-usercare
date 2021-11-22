<?php

namespace Mawuekom\Usercare\Repositories;

use Mawuekom\Repository\Eloquent\BaseRepository;
use Mawuekom\Repository\Logics\QueryLogic;

class UserRepository extends BaseRepository
{
    use QueryLogic;
    
    /**
     * Get the model on which works
     * 
     * @return Model|string
     */
    public function model()
    {
        return config('custom-user.user.model');
    }

    /**
     * Get the columns on which the search will be done
     * 
     * @return array
     */
    public function searchableFields()
    {
        return ['name', 'first_name', 'email', 'phone_number'];
    }

    /**
     * Columns on which filterig will be done
     * 
     * @return array
     */
    public function filterableFields(): array
    {
        return ['name', 'first_name', 'email', 'phone_number'];
    }

    /**
     * Determine by which property the results collection will be ordered
     * 
     * @return array
     */
    public function sortableFields(): array
    {
        return ['name', 'first_name', 'email', 'phone_number', 'created_at'];
    }

    /**
     * Determine the relation that will be load on the resulting model
     * 
     * @return array
     */
    public function includableRelations(): array
    {
        return ['profile', 'accountType'];
    }

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     * 
     * @return array
     */
    public function selectableFields(): array
    {
        return ['name', 'first_name', 'email', 'phone_number'];
    }
}