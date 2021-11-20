<?php

namespace Mawuekom\Usercare\Services;

use Illuminate\Http\Response;
use Mawuekom\Usercare\Actions\SaveAccountTypeAction;
use Mawuekom\Usercare\DataTransferObjects\AccountTypeDTO;
use Mawuekom\Usercare\Facades\Usercare;
use Mawuekom\Usercare\Repositories\AccountTypeRepository;

class AccountTypeService
{
    /**
     * @var \Mawuekom\Usercare\Repositories\AccountTypeRepository
     */
    protected $accountTypeRepository;

    /**
     * Entity name
     *
     * @var string
     */
    protected $slug;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Usercare\Repositories\AccountTypeRepository $accountTypeRepository
     * 
     * @return void
     */
    public function __construct(AccountTypeRepository $accountTypeRepository)
    {
        $this ->slug                    = config('usercare.account_type.slug');
        $this ->accountTypeRepository   = $accountTypeRepository;
    }

    /**
     * Create new account type.
     *
     * @param \Mawuekom\Usercare\DataTransferObjects\AccountTypeDTO $accountTypeDTO
     *
     * @return array
     */
    public function create(AccountTypeDTO $accountTypeDTO): array
    {
        $accountType = app(SaveAccountTypeAction::class) ->execute($accountTypeDTO);

        return success_response(trans('lang-resources::commons.messages.entity.created', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType, 201);
    }

    /**
     * Get all account types with trashed too
     * 
     * @param boolean $paginate
     * @param array $columns
     * 
     * @return array
     */
    public function getWithTrashed($paginate = true, $columns = ['*'])
    {
        $data = $this ->accountTypeRepository ->withTrashed();

        $results = ($paginate) ? $data ->paginate(null, $columns) : $data ->get($columns);

        if ($results ->count() > 0) {
            return success_response(
                trans('lang-resources::commons.messages.entity.list_with_deleted', [
                    'Entity' => trans_choice('usercare::entity.account_type', 2)
                ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_found_trashed'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Get all account type without trashed too
     * 
     * @param boolean $paginate
     * @param array $columns
     * 
     * @return array
     */
    public function getWithoutTrashed($paginate = true, $columns = ['*'])
    {
        $data = $this ->accountTypeRepository;

        $results = ($paginate) ? $data ->paginate(null, $columns) : $data ->all($columns);

        if ($results ->count() > 0) {
            return success_response(trans('lang-resources::messages.entity.list', [
                'Entity' => trans_choice('usercare::entity.account_type', 2)
            ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_available'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Get only trashed account type too
     * 
     * @param boolean $paginate
     * @param array $columns
     * 
     * @return array
     */
    public function getOnlyTrashed($paginate = true, $columns = ['*'])
    {
        $data = $this ->accountTypeRepository ->onlyTrashed();

        $results = ($paginate) ? $data ->paginate(null, $columns) : $data ->get($columns);

        if ($results ->count() > 0) {
            return success_response(trans('lang-resources::messages.entity.deleted_list', [
                'Entity' => trans_choice('usercare::entity.account_type', 2)
            ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_available'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Search account type
     * 
     * @param string $searchTerm
     * @param boolean $paginate
     * @param array $columns
     * 
     * @return array
     */
    public function search(string $searchTerm, $paginate = true, $columns = ['*'])
    {
        $data = $this ->accountTypeRepository ->search($searchTerm, $columns);

        $results = ($paginate) ? $data ->paginate() : $data;

        if ($results ->count() > 0) {
            return success_response(trans('lang-resources::messages.entity.search_results', [
                'Entity' => trans_choice('usercare::entity.account_type', 2)
            ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_found'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Get account type by ID
     * 
     * @param int|string $id
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getById($id, $inTrashed = false, $columns = ['*'])
    {
        $accountType = Usercare::getEntityById($this ->slug, $id, $inTrashed, $columns);

        if (is_null($accountType)) {
            return failure_response(trans('lang-resources::messages.resource.not_found'), null, Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response(trans('lang-resources::messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.account_type', 1)
            ]), $accountType);
        }
    }

    /**
     * Get account type by field
     * 
     * @param string $field
     * @param string $value
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getByField($field, $value = null, $inTrashed = false, $columns = ['*'])
    {
        $accountType = Usercare::getEntityByField($this ->slug, $field, $value, $inTrashed, $columns);

        if (is_null($accountType)) {
            return failure_response(trans('lang-resources::messages.resource.not_found'), null, Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response(trans('lang-resources::messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.account_type', 1)
            ]), $accountType);
        }
    }

    /**
     * Update account type data
     * 
     * @param int|string $id
     * @param \Mawuekom\CustomUser\DataTransferObjects\AccountTypeDTO $accountTypeDTO
     * 
     * @return array
     */
    public function update($id, AccountTypeDTO $accountTypeDTO)
    {
        $accountType = app(SaveAccountTypeAction::class) ->execute($accountTypeDTO, $id);

        return success_response(trans('lang-resources::commons.messages.completed.update'), $accountType);
    }

    /**
     * Update account type field except password by ID
     *
     * @param int|string $id
     * @param string $field
     * @param string|null $value
     *
     * @return array
     */
    public function updateFieldValueById($id, string $field, string $value = null)
    {
        $accountType = Usercare::getEntityById($this ->slug, $id, false, [$field]);

        $accountType ->{$field} = $value;
        $accountType ->save();

        return success_response(trans('lang-resources::commons.messages.completed.update'), $accountType);
    }

    /**
     * Delete account type
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function delete($id)
    {
        $accountType = Usercare::getEntityById($this ->slug, $id, false, ['id']);
        $accountType ->delete();

        return success_response(trans('lang-resources::messages.entity.deleted', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Restore account type
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function restore($id)
    {
        $accountType = Usercare::getEntityById($this ->slug, $id, true, ['id']);
        $accountType ->restore();

        return success_response(trans('lang-resources::messages.entity.restored', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), $accountType);
    }

    /**
     * Delete account type permanently
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function destroy($id)
    {
        $accountType = Usercare::getEntityById($this ->slug, $id, true, ['id']);
        $accountType ->forceDelete();

        return success_response(trans('lang-resources::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]));
    }
}