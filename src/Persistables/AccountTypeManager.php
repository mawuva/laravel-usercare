<?php

namespace Mawuekom\Usercare\Persistables;

use Illuminate\Http\Response;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\RepositoryLayer\BaseRepository;
use Mawuekom\Usercare\Traits\ResourceDataManager;

trait AccountTypeManager
{
    use ResourceDataManager;

    /**
     * Create new account type
     *
     * @param array $data
     *
     * @return array
     */
    public function createAccountType(array $data): array
    {
        $resource = config('usercare.account_type.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        $this ->validateSlug($data['slug'], $resource);

        $insert = [
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
        ];

        $accountType = ($modelRepo instanceof BaseApiRepository || $modelRepo instanceof BaseRepository)
                        ? $modelRepo ->create($insert)
                        : $modelRepo::create($insert);

        return success_response(trans('usercare::messages.entity.created', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Get all account types with trashed too
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getAllAccountTypes($paginate = true): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountTypes = config('usercare.'.$resource.'.model')::withTrashed() ->get();

        $this ->checkDataRecords($accountTypes, trans('usercare::messages.records.not_found_trashed'));

        return success_response(trans('usercare::messages.entity.deleted_list', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountTypes);
    }

    /**
     * Get all account types
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getAccountTypes($paginate = true): array
    {
        $resource = config('usercare.account_type.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $accountTypes = (!$paginate)
                                ? $modelRepo ->getAllResources()
                                : $modelRepo ->paginateAllResources();
        }

        else {
            $accountTypes = (!$paginate)
                                ? $modelRepo ->all()
                                : $modelRepo ->paginate(20);
        }

        $this ->checkDataRecords($accountTypes, trans('usercare::messages.records.not_available'));

        return success_response(trans('usercare::messages.entity.list', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountTypes);
    }

    /**
     * Retrieve trashed account types
     * 
     * @return array
     */
    public function getDeletedAccountTypes(): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountTypes = config('usercare.'.$resource.'.model')::onlyTrashed() ->get();

        $this ->checkDataRecords($accountTypes, trans('usercare::messages.records.not_found_trashed'));

        return success_response(trans('usercare::messages.entity.deleted_list', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountTypes);
    }

    /**
     * Search account type 
     * 
     * @param string $searchTerm
     * @param boolean $paginate
     * 
     * @return array
     */
    public function searchAccountTypes(string $searchTerm, $paginate = false): array
    {
        $resource = config('usercare.account_type.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $accountTypes = (!$paginate)
                                ? $modelRepo ->searchResources($searchTerm)
                                : $modelRepo ->paginateSearchResources($searchTerm);
        }

        else {
            $accountTypes = (!$paginate)
                                ? $modelRepo ->whereLike(['name', 'slug'], $searchTerm)
                                : $modelRepo ->whereLike(['name', 'slug'], $searchTerm) ->paginate(20);
        }

        $this ->checkDataRecords($accountTypes, trans('usercare::messages.records.no_results_found'), Response::HTTP_NOT_FOUND);

        return success_response(trans('usercare::messages.entity.search_results', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountTypes);
    }

    /**
     * Get account type by ID
     * 
     * @param int|string $account_type_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getAccountType(int|string $account_type_id, $deleted = false): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountType = $this ->validateAndGetResourceById($account_type_id, $resource, $deleted);

        return success_response(trans('usercare::messages.entity.resource', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Get account type by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getAccountTypeBySlug(string $slug): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountType = $this ->validateAndGetResourceBySlug($slug, $resource);

        return success_response(trans('usercare::messages.entity.resource', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Update account type data
     * 
     * @param int|string $account_type_id
     * @param array $data
     * 
     * @return array
     */
    public function updateAccountType(int|string $account_type_id, array $data): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountType = $this ->validateAndGetResourceById($account_type_id, $resource);

        $this ->validateSlug($data['slug'], $resource, $accountType ->id);

        $accountType ->update([
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
        ]);

        return success_response(trans('usercare::messages.entity.updated', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Delete role
     * 
     * @param int|string $account_type_id
     * 
     * @return array
     */
    public function deleteAccountType(int|string $account_type_id): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountType = $this ->validateAndGetResourceById($account_type_id, $resource);
        $accountType ->delete();

        return success_response(trans('usercare::messages.entity.deleted', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Restore account type account
     * 
     * @param int|string $account_type_id
     * 
     * @return array
     */
    public function restoreAccountType(int|string $account_type_id): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountType = $this ->validateAndGetResourceById($account_type_id, $resource, true);
        $accountType ->restore();

        return success_response(trans('usercare::messages.entity.restored', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Delete account type permanently
     * 
     * @param int|string $account_type_id
     * 
     * @return array
     */
    public function destroyAccountType(int|string $account_type_id): array
    {
        $resource = config('usercare.account_type.resource_name');
        $accountType = $this ->validateAndGetResourceById($account_type_id, $resource, true);
        $accountType ->forceDelete();

        return success_response(trans('usercare::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), null);
    }
}