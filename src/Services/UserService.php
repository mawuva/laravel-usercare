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
     * Create new user account.
     *
     * @param \Mawuekom\Usercare\DataTransferObjects\CreateUserDTO $data
     *
     * @return array
     */
    public function create(CreateUserDTO $storeUserDTO): array
    {
        $user = app(CreateUserAction::class) ->execute($storeUserDTO);

        return success_response(trans('lang-resources::commons.messages.entity.created', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]), $user, 201);
    }

    /**
     * Get all users with trashed too
     * 
     * @param boolean $paginate
     * @param array $columns
     * @param array $relations
     * 
     * @return array
     */
    public function getWithTrashed($paginate = true, $columns = ['*'], $relations = [])
    {
        $data = $this ->userRepository ->withTrashed();

        $results = ($paginate) ? $data ->paginate(null, $columns) : $data ->get($columns);

        if ($results ->count() > 0) {
            return success_response(
                trans('lang-resources::commons.messages.entity.list_with_deleted', [
                    'Entity' => trans_choice('usercare::entity.user', 2)
                ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_found_trashed'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Get all users without trashed too
     * 
     * @param boolean $paginate
     * @param array $columns
     * @param array $relations
     * 
     * @return array
     */
    public function getWithoutTrashed($paginate = true, $columns = ['*'], $relations = [])
    {
        $data = $this ->userRepository ->with($relations);

        $results = ($paginate) ? $data ->paginate(null, $columns) : $data ->get($columns);

        if ($results ->count() > 0) {
            return success_response(trans('lang-resources::messages.entity.list', [
                'Entity' => trans_choice('usercare::entity.user', 2)
            ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_available'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Get only trashed users too
     * 
     * @param boolean $paginate
     * @param array $columns
     * @param array $relations
     * 
     * @return array
     */
    public function getOnlyTrashed($paginate = true, $columns = ['*'], $relations = [])
    {
        $data = $this ->userRepository ->onlyTrashed();

        $results = ($paginate) ? $data ->paginate(null, $columns) : $data ->get($columns);

        if ($results ->count() > 0) {
            return success_response(trans('lang-resources::messages.entity.deleted_list', [
                'Entity' => trans_choice('usercare::entity.user', 2)
            ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_available'), null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Search user
     * 
     * @param string $searchTerm
     * @param boolean $paginate
     * @param array $columns
     * @param array $relations
     * 
     * @return array
     */
    public function search(string $searchTerm, $paginate = true, $columns = ['*'], $relations = [])
    {
        $data = $this ->userRepository ->search($searchTerm, $columns);

        $results = ($paginate) ? $data ->paginate() : $data;

        if ($results ->count() > 0) {
            return success_response(trans('lang-resources::messages.entity.search_results', [
                'Entity' => trans_choice('usercare::entity.user', 2)
            ]), $results);
        }

        else {
            return failure_response(trans('lang-resources::messages.records.not_found'), null, Response::HTTP_NO_CONTENT);
        }
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
            return failure_response(trans('lang-resources::messages.resource.not_found'), null, Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response(trans('lang-resources::messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]), $user);
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
            return failure_response(trans('lang-resources::messages.resource.not_found'), null, Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response(trans('lang-resources::messages.entity.resource', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]), $user);
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

        return success_response(trans('lang-resources::commons.messages.completed.update'), $user);
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

        return success_response(trans('lang-resources::commons.messages.completed.update'), $user);
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

        return success_response(trans('passauth::messages.password_changed'));
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

        return success_response(trans('lang-resources::messages.entity.deleted', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
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

        return success_response(trans('lang-resources::messages.entity.restored', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
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

        return success_response(trans('lang-resources::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]));
    }
}