<?php

namespace Mawuekom\Usercare\Contracts\Persistables;

interface UserManager
{
    /**
     * Get users list with trashed
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getAllUsers($paginate = true): array;

    /**
     * Get users list
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getUsers($paginate = true): array;
    
    /**
     * Retrieve trashed users
     * 
     * @return array
     */
    public function getDeletedUsers(): array;

    /**
     * Search user
     * 
     * @param string $searchTerm
     * @param boolean $paginate
     * 
     * @return array
     */
    public function searchUsers(string $searchTerm, $paginate = false): array;
}