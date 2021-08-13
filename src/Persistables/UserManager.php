<?php

namespace Mawuekom\Usercare\Persistables;

use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\Usercare\Traits\ResourceDataManager;

trait UserManager
{
    use ResourceDataManager;

    /**
     * Get users list with trashed
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getAllUsers($paginate = true): array
    {
        $resource = config('usercare.user.resource_name');
        $users = config('usercare.'.$resource.'.model')::withTrashed() ->get();

        $this ->checkDataRecords($users, trans('usercare::messages.records.not_found_trashed'));

        return success_response(trans('usercare::messages.entity.list', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $users);
    }

    /**
     * Get users list
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getUsers($paginate = true): array
    {
        $resource = config('usercare.user.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $users = (!$paginate)
                        ? $modelRepo ->getAllResources()
                        : $modelRepo ->paginateAllResources();
        }

        else {
            $users = (!$paginate)
                                ? $modelRepo ->all()
                                : $modelRepo ->paginate(20);
        }

        $this ->checkDataRecords($users, trans('usercare::messages.records.not_available'));

        return success_response(trans('usercare::messages.entity.list', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $users);
    }
    
    /**
     * Retrieve trashed users
     * 
     * @return array
     */
    public function getDeletedUsers(): array
    {
        $resource = config('usercare.user.resource_name');
        $users = config('usercare.'.$resource.'.model')::onlyTrashed() ->get();

        $this ->checkDataRecords($users, trans('usercare::messages.records.not_found_trashed'));

        return success_response(trans('usercare::messages.entity.deleted_list', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $users);
    }

    /**
     * Search user
     * 
     * @param string $searchTerm
     * @param boolean $paginate
     * 
     * @return array
     */
    public function searchUsers(string $searchTerm, $paginate = false): array
    {
        $resource = config('usercare.user.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $users = (!$paginate)
                                ? $modelRepo ->searchResources($searchTerm)
                                : $modelRepo ->paginateSearchResources($searchTerm);
        }

        else {
            $users = (!$paginate)
                                ? $modelRepo ->whereLike(['name', 'slug'], $searchTerm)
                                : $modelRepo ->whereLike(['name', 'slug'], $searchTerm) ->paginate(20);
        }

        $this ->checkDataRecords($users, trans('usercare::messages.records.not_found_trashed'));

        return success_response(trans('usercare::messages.entity.search_results', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $users);
    }
}