<?php

namespace Mawuekom\Usercare\Persistables;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mawuekom\Usercare\Traits\ResourceDataManager;
use Mawuekom\Usercare\Traits\UserResolver;

trait UserAccountManager
{
    use ResourceDataManager, UserResolver;

    /**
     * Create new user account.
     *
     * @param array $data
     *
     * @return array
     */
    public function createUserAccount(array $data): array
    {
        $user = app() ->make(config('usercare.user.model'));

        $password = (check_key_in_array($data, 'password') !== null) 
                        ? $data['password']
                        : 'password';

        $user ->name        = $this ->resolveUsername($data);
        $user ->email       = check_key_in_array($data, 'email');

        if (proper_names_is_enabled_and_exists()) {
            $user ->last_name   = strtoupper(check_key_in_array($data, 'last_name'));
            $user ->first_name  = ucwords(check_key_in_array($data, 'first_name'));
        }

        if (phone_number_is_enabled_and_exists()) {
            $user ->phone_number    = check_key_in_array($data, 'phone_number');
        }

        if (schema_has_gender_column()) {
            $user ->gender    = check_key_in_array($data, 'gender');
        }

        $user ->password    = $this ->resolvePassword($password);

        if (account_type_is_enabled_and_exists()) {
            $users_table_account_type_fk            = config('usercare.user.table.account_type_foreign_key');
            $user ->{$users_table_account_type_fk}  = check_key_in_array($data, 'account_type_id');
        }

        $user ->save();

        return success_response(trans('usercare::messages.entity.created', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user, 201);
    }

    /**
     * Get user by ID
     * 
     * @param int|string $user_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getUserById($user_id, $deleted = false): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource, $deleted);

        return success_response(trans('usercare::messages.entity.resource', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
    }

    /**
     * Get user by username
     * 
     * @param string $username
     * 
     * @return array
     */
    public function getUserByUserName(string $username): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->getResourceItemBy(['name' => $username], $resource);

        $this ->checkDataResource($user, trans('usercare::messages.resource.not_found'));

        return success_response(trans('usercare::messages.entity.resource', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
    }

    /**
     * Update user data
     * 
     * @param int|string $user_id
     * @param array $data
     * 
     * @return array
     */
    public function updateUser(int|string $user_id, array $data): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);
        
        $infos = [];

        if (check_key_in_array($data, 'name') !== null) {
            $infos['name'] = $this ->resolveUsername($data);
        }

        if (check_key_in_array($data, 'email') !== null) {
            $infos['email'] = $data['email'];
        }

        if (proper_names_is_enabled_and_exists()) {
            (check_key_in_array($data, 'last_name') !== null)
                ?? $infos['last_name']   = strtoupper(check_key_in_array($data, 'last_name'));
            
            (check_key_in_array($data, 'first_name') !== null)
                ?? $infos['first_name']  = ucwords(check_key_in_array($data, 'first_name'));
        }

        if (phone_number_is_enabled_and_exists() && check_key_in_array($data, 'phone_number') !== null) {
            $infos['phone_number']    = check_key_in_array($data, 'phone_number');
        }

        if (schema_has_gender_column() && check_key_in_array($data, 'gender') !== null) {
            $infos['gender']    = check_key_in_array($data, 'gender');
        }

        $user ->update($infos);

        return success_response(trans('usercare::messages.entity.updated', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
    }

    /**
     * Change user email
     * 
     * @param int|string $user_id
     * @param string $email
     * 
     * @return array
     */
    public function changeUserEmail(int|string $user_id, string $email): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);
        $user ->update(['email' => $email]);

        return success_response(trans('usercare::messages.entity.changed', [
            'Entity' => trans('usercare::entity.attributes.email')
        ]), $user);
    }

    /**
     * Change user email
     * 
     * @param int|string $user_id
     * @param string $phone_number
     * 
     * @return array
     */
    public function changeUserPhoneNumber(int|string $user_id, string $phone_number): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);
        $user ->update(['phone_number' => $phone_number]);

        return success_response(trans('usercare::messages.entity.changed', [
            'Entity' => trans('usercare::entity.attributes.phone_number')
        ]), $user);
    }

    /**
     * Change user's username
     * 
     * @param int|string $user_id
     * @param string $username
     * 
     * @return array
     */
    public function changeUsername(int|string $user_id, string $username): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);
        $user ->update(['name' => $username]);

        return success_response(trans('usercare::messages.entity.changed', [
            'Entity' => trans('usercare::entity.attributes.username')
        ]), $user);
    }

    /**
     * Change user password
     * 
     * @param int|string $user_id
     * @param string $password
     * 
     * @return array
     */
    public function changePassword($user_id, string $password): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);

        $user ->password = $this ->resolvePassword($password);
        $this ->resolvePasswordChangedAt($user);
        $user ->save();

        return success_response(trans('usercare::messages.entity.changed', [
            'Entity' => trans('usercare::entity.attributes.password')
        ]), $user);
    }

    /**
     * Reset user password
     * 
     * @param int|string $user_id
     * @param string $old_password
     * @param string $new_password
     * 
     * @return array
     */
    public function resetPassword(int|string $user_id, string $old_password, string $new_password): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);

        if (!Hash::check($old_password, $user ->password)) {
            throw ValidationException::withMessages([
                'password'      => trans('usercare::messages.old_password_not_matching'),
                'old_password'  => trans('usercare::messages.old_password_not_matching'),
            ]);
        }

        $user ->password = $this ->resolvePassword($new_password);
        $this ->resolvePasswordChangedAt($user);
        $user ->save();

        return success_response(trans('usercare::messages.entity.changed', [
            'Entity' => trans('usercare::entity.attributes.password')
        ]), $user);
    }

    /**
     * Delete role
     * 
     * @param int|string $user_id
     * 
     * @return array
     */
    public function deleteUser(int|string $user_id): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource);

        if (Auth::check() && (Auth::user() ->id === $user ->id)) {
            throw new Exception(trans('usercare::messages.can_not_delete_yoursel'), Response::HTTP_FORBIDDEN);
        }

        $user ->delete();

        return success_response(trans('usercare::messages.entity.deleted', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
    }

    /**
     * Restore user account
     * 
     * @param int|string $user_id
     * 
     * @return array
     */
    public function restoreUser(int|string $user_id): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource, true);
        $user ->restore();

        return success_response(trans('usercare::messages.entity.restored', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), $user);
    }

    /**
     * Delete user permanently
     * 
     * @param int|string $user_id
     * 
     * @return array
     */
    public function destroyUser(int|string $user_id): array
    {
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($user_id, $resource, true);
        $user ->forceDelete();

        return success_response(trans('usercare::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('usercare::entity.user', 1)
        ]), null);
    }
}