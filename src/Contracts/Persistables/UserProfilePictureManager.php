<?php

namespace Mawuekom\Usercare\Contracts\Persistables;

interface UserProfilePictureManager
{
    /**
     * Save user profile avatar picture
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function saveAvatar(int|string $user_id, array $data): array;

    /**
     * Save user profile background picture
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function saveBgPicture(int|string $user_id, array $data): array;
}