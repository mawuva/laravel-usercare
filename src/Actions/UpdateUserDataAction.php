<?php

namespace Mawuekom\Usercare\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\CustomUser\Facades\CustomUser;
use Mawuekom\Usercare\DataTransferObjects\UpdateUserDataDTO;

class UpdateUserDataAction
{
    /**
     * Execute action
     *
     * @param int|string $id
     * @param \Mawuekom\CustomUser\DataTransferObjects\UpdateUserDTO|Mawuekom\Usercare\DataTransferObjects\UpdateUserDataDTO $updateUserDTO
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute($id, UpdateUserDataDTO $updateUserDTO): Model
    {
        $user = CustomUser::getUserById($id);

        $user ->name        = $updateUserDTO ->name;
        $user ->email       = $updateUserDTO ->email;

        if (get_attribute('first_name', 'enabled') && $updateUserDTO ->first_name !== null) {
            $user ->first_name  = $updateUserDTO ->first_name;
        }

        if (get_attribute('username', 'enabled') && $updateUserDTO ->username !== null) {
            $user ->username  = $updateUserDTO ->username;
        }

        if (get_attribute('phone_number', 'enabled') && $updateUserDTO ->phone_number !== null) {
            $user ->phone_number  = $updateUserDTO ->phone_number;
        }

        if (get_attribute('gender', 'enabled') && $updateUserDTO ->gender !== null) {
            $user ->{get_attribute('gender', 'name')}  = $updateUserDTO ->gender;
        }

        if (config('usercare.account_type.enabled') && $updateUserDTO ->account_type !== null) {
            $user ->{config('usercare.user.table.account_type_foreign_key')}  = $updateUserDTO ->account_type;
        }

        $user ->save();

        return $user;
    }
}