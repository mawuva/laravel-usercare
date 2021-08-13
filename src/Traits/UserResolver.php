<?php

namespace Mawuekom\Usercare\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait UserResolver
{
    /**
     * Resolve user's username
     *
     * @param array $data
     *
     * @return string
     */
    protected function resolveUsername(array $data): string
    {
        if (check_key_in_array($data, 'name') !== null) {
            return $data['name'];
        }

        elseif (check_key_in_array($data, 'username') !== null) {
            return $data['username'];
        }

        elseif (check_key_in_array($data, 'email') != null) {
            return explode('@', $data['email'])[0].'-'.generate_random_username(3, 6, false);
        }

        else {
            return generate_random_username();
        }
    }

    /**
     * Resolve user's password.
     *
     * @param string $password
     *
     * @return string
     */
    protected function resolvePassword(string $password): string
    {
        return (method_exists(config('usercare.user.model'), 'setPasswordAttribute'))
                    ? $password
                    : bcrypt($password);
    }

    /**
     * Resolve password changed at
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function updatePasswordChangedAt(Model $model)
    {
        if (password_changed_is_enabled_and_exists()) {
            $model ->password_changed_at = Carbon::now();
        }
    }
}