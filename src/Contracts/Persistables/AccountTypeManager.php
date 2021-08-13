<?php

namespace Mawuekom\Usercare\Contracts\Persistables;

interface AccountTypeManager
{
    /**
     * Create new account type
     *
     * @param array $data
     *
     * @return array
     */
    public function createAccountType(array $data): array;

    /**
     * Get all account types with trashed too
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getAllAccountTypes($paginate = true): array;

    /**
     * Get all account types
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getAccountTypes($paginate = true): array;

    /**
     * Retrieve trashed account types
     * 
     * @return array
     */
    public function getDeletedAccountTypes(): array;

    /**
     * Search account type 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchAccountTypes(string $searchTerm): array;

    /**
     * Get account type by ID
     * 
     * @param int|string $account_type_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getAccountType(int|string $account_type_id, $deleted = false): array;

    /**
     * Get account type by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getAccountTypeBySlug(string $slug): array;

    /**
     * Update account type data
     * 
     * @param int|string $account_type_id
     * @param array $data
     * 
     * @return array
     */
    public function updateAccountType(int|string $account_type_id, array $data): array;

    /**
     * Delete role
     * 
     * @param int|string $account_type_id
     * 
     * @return array
     */
    public function deleteAccountType(int|string $account_type_id): array;

    /**
     * Restore account type account
     * 
     * @param int|string $account_type_id
     * 
     * @return array
     */
    public function restoreAccountType(int|string $account_type_id): array;

    /**
     * Delete account type permanently
     * 
     * @param int|string $account_type_id
     * 
     * @return array
     */
    public function destroyAccountType(int|string $account_type_id): array;
}