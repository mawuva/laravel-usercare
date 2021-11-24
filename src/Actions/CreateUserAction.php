<?php

namespace Mawuekom\Usercare\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\CustomUser\Facades\CustomUser;
use Mawuekom\Usercare\DataTransferObjects\CreateUserDTO;

class CreateUserAction
{
    /**
     * Execute action
     *
     * @param \Mawuekom\CustomUser\DataTransferObjects\createUserDTO|Mawuekom\Usercare\DataTransferObjects\CreateUserDTO $createUserDTO
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(CreateUserDTO $createUserDTO): Model
    {
        $user = app(config('custom-user.user.model'));

        $user ->name        = $createUserDTO ->name;
        $user ->email       = $createUserDTO ->email;
        $user ->password    = CustomUser::handlePassword($createUserDTO ->password);

        if (get_attribute('first_name', 'enabled') && $createUserDTO ->first_name !== null) {
            $user ->first_name  = $createUserDTO ->first_name;
        }

        if (get_attribute('username', 'enabled') && $createUserDTO ->username !== null) {
            $user ->username  = $createUserDTO ->username;
        }

        if (get_attribute('phone_number', 'enabled') && $createUserDTO ->phone_number !== null) {
            $user ->phone_number  = $createUserDTO ->phone_number;
        }

        if (get_attribute('gender', 'enabled') && $createUserDTO ->gender !== null) {
            $user ->{get_attribute('gender', 'name')}  = $createUserDTO ->gender;
        }

        if (get_attribute('is_admin', 'enabled') && $createUserDTO ->is_admin !== null) {
            $user ->{get_attribute('is_admin', 'name')}  = $createUserDTO ->is_admin;
        }

        if (config('usercare.account_type.enabled') && $createUserDTO ->account_type !== null) {
            $user ->{config('usercare.user.table.account_type_foreign_key')}  = $createUserDTO ->account_type;
        }

        $user ->save();

        if (config('custom-user.password_history.enabled')) {
            $user ->updatePasswordHistory();
        }

        return $user;
    }
}