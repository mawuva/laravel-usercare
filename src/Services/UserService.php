<?php

namespace Mawuekom\Usercare\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mawuekom\CustomUser\Actions\UpdatePasswordAction;
use Mawuekom\CustomUser\Facades\CustomUser;
use Mawuekom\Usercare\Actions\CreateUserAction;
use Mawuekom\Usercare\Actions\UpdateUserDataAction;
use Mawuekom\Usercare\DataTransferObjects\CreateUserDTO;
use Mawuekom\Usercare\DataTransferObjects\UpdateUserDataDTO;
use Mawuekom\Usercare\DataTransferObjects\UpdateUserPasswordDTO;
use Mawuekom\Usercare\Repositories\UserRepository;

class UserService
{   
    /**
     * @var \Mawuekom\Usercare\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Entity name
     *
     * @var string
     */
    protected $slug;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Usercare\Repositories\UserRepository $userRepository
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this ->slug            = config('custom-user.user.slug');
        $this ->userRepository  = $userRepository;
    }

    /**
     * Return repository instance
     *
     * @return \Mawuekom\Usercare\Repositories\UserRepository
     */
    public function fromRepo()
    {
        return $this->userRepository;
    }

    /**
     * Create new user account.
     *
     * @param \Mawuekom\Usercare\DataTransferObjects\CreateUserDTO $data
     *
     * @return array
     */
    public function create(CreateUserDTO $storeUserDTO): array
    {
        $user = app(CreateUserAction::class) ->execute($storeUserDTO);

        return success_response($user, trans('lang-resources::commons.messages.entity.created', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]), Response::HTTP_CREATED);
    }

    /**
     * Get user by ID
     * 
     * @param int|string $id
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getById($id, $inTrashed = false, $columns = ['*'])
    {
        $user = CustomUser::getUserById($id, $inTrashed, $columns);

        if (is_null($user)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($user, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]));
        }
    }

    /**
     * Get user by field
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
        $user = CustomUser::getUserByField($field, $value, $inTrashed, $columns);

        if (is_null($user)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($user, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]));
        }
    }

    /**
     * Update user data
     * 
     * @param int|string $id
     * @param \Mawuekom\Usercare\DataTransferObjects\UpdateUserDataDTO $updateUserDTO
     * 
     * @return array
     */
    public function update($id, UpdateUserDataDTO $updateUserDTO)
    {
        $user = app(UpdateUserDataAction::class) ->execute($id, $updateUserDTO);

        return success_response($user, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Update user field except password by ID
     *
     * @param int|string $id
     * @param string $field
     * @param string|null $value
     *
     * @return array
     */
    public function updateFieldValueById($id, string $field, string $value = null)
    {
        if ($field === 'password') {
            throw new Exception("Password can not be update through this way. Use Mawuekom\\Usercare\\Services\\UserService::changePassword method instead");
        }

        $user = CustomUser::getUserById($id, false, [$field]);
        $user ->{$field} = $value;
        $user ->save();

        return success_response($user, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Reset user password
     * 
     * @param int|string $id
     * @param \Mawuekom\Usercare\DataTransferObjects\UpdateUserPasswordDTO $updateUserPasswordDTO
     * 
     * @return array
     */
    public function updatePassword($id, UpdateUserPasswordDTO $updateUserPasswordDTO)
    {
        $user = CustomUser::getUserById($id, false, ['email', 'password']);

        if (!Hash::check($updateUserPasswordDTO ->old_password, $user ->password)) {
            throw ValidationException::withMessages([
                'password'      => trans('usercare::messages.old_password_not_matching'),
                'old_password'  => trans('usercare::messages.old_password_not_matching'),
            ]);
        }

        app(UpdatePasswordAction::class) ->execute($user, $updateUserPasswordDTO ->new_password);

        return success_response(null, trans('passauth::messages.password_changed'));
    }

    /**
     * Delete user
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function delete($id)
    {
        $user = CustomUser::getUserById($id, false, ['id']);

        if (Auth::check() && (Auth::user() ->id === $user ->id)) {
            throw new Exception(trans('usercare::messages.can_not_delete_yourself'), Response::HTTP_FORBIDDEN);
        }
        
        $user ->delete();

        return success_response($user, trans('lang-resources::commons.messages.entity.deleted', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]));
    }

    /**
     * Restore user account
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function restore($id)
    {
        $user = CustomUser::getUserById($id, true, ['id']);
        $user ->restore();

        return success_response($user, trans('lang-resources::commons.messages.entity.restored', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]));
    }

    /**
     * Delete user permanently
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function destroy($id)
    {
        $user = CustomUser::getUserById($id, true, ['id']);
        $user ->forceDelete();

        return success_response(null, trans('lang-resources::commons.messages.entity.deleted_permanently', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]));
    }
}