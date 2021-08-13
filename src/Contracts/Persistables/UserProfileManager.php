<?php

namespace Mawuekom\Usercare\Contracts\Persistables;

interface UserProfileManager
{
    /**
     * Save user profile datas
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function saveDatas(int|string $user_id, array $data): array;
}