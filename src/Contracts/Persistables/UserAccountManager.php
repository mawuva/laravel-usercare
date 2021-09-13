<?php

namespace Mawuekom\Usercare\Contracts\Persistables;

interface UserAccountManager
{
    /**
     * Create new user account.
     *
     * @param array $data
     *
     * @return array
     */
    public function createUserAccount(array $data): array;

    /**
     * Get user by ID
     * 
     * @param int|string $user_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getUserById($user_id, $deleted = false): array;

    /**
     * Get user by username
     * 
     * @param string $username
     * 
     * @return array
     */
    public function getUserByUserName(string $username): array;

    /**
     * Update user data
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function updateUser(int|string $user_id, array $data): array;

    /**
     * Change user email
     * 
     * @param int|string $user_id
     * @param string $email
     * 
     * @return array
     */
    public function changeUserEmail(int|string $user_id, string $email): array;

    /**
     * Change user email
     * 
     * @param int|string $user_id
     * @param string $phone_number
     * 
     * @return array
     */
    public function changeUserPhoneNumber(int|string $user_id, string $phone_number): array;

    /**
     * Change user's username
     * 
     * @param int|string $user_id
     * @param string $username
     * 
     * @return array
     */
    public function changeUsername(int|string $user_id, string $username): array;

    /**
     * Change user password
     * 
     * @param int|string $user_id
     * @param string $password
     * 
     * @return array
     */
    public function changePassword($user_id, string $password): array;

    /**
     * Reset user password
     * 
     * @param int|string $user_id
     * @param string $old_password
     * @param string $new_password
     * 
     * @return array
     */
    public function resetPassword(int|string $user_id, string $old_password, string $new_password): array;

    /**
     * Delete role
     * 
     * @param int|string $user_id
     * 
     * @return array
     */
    public function deleteUser(int|string $user_id): array;

    /**
     * Restore user account
     * 
     * @param int|string $user_id
     * 
     * @return array
     */
    public function restoreUser(int|string $user_id): array;

    /**
     * Delete user permanently
     * 
     * @param int|string $user_id
     * 
     * @return array
     */
    public function destroyUser(int|string $user_id): array;
}