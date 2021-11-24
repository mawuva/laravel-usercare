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
     * Return repository instance
     *
     * @return \Mawuekom\Usercare\Repositories\AccountTypeRepository
     */
    public function fromRepo()
    {
        return $this->accountTypeRepository;
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

        return success_response($accountType, trans('lang-resources::commons.messages.entity.created', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]), Response::HTTP_CREATED);
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
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($accountType, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.account_type', 1)
            ]));
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
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($accountType, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.account_type', 1)
            ]));
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

        return success_response($accountType, trans('lang-resources::commons.messages.completed.update'));
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

        return success_response($accountType, trans('lang-resources::commons.messages.completed.update'));
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

        return success_response($accountType, trans('lang-resources::commons.messages.entity.deleted', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]));
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

        return success_response($accountType, trans('lang-resources::commons.messages.entity.restored', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]));
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

        return success_response(null, trans('lang-resources::commons.messages.entity.deleted_permanently', [
            'Entity' => trans_choice('usercare::entity.account_type', 1)
        ]));
    }
}