<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\Usercare\Persistables\UserAccountManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;
use Mawuekom\RequestSanitizer\Sanitizers\Uppercase;

class CreateUserAccountRequest extends FormRequestCustomizer
{
    use UserAccountManager;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $users_table = config('usercare.user.table.name');
        $email_is_optional = config('usercare.enable.optional.email');

        $proper_names_rules = (proper_names_is_enabled_and_exists())
                                ? ['last_name' => 'string', 'first_name' => 'string']
                                : [];

        $email_rules = ($email_is_optional)
                        ? ['email' => 'string|email|unique:'.$users_table]
                        : ['email' => 'required|string|email|unique:'.$users_table];
        
        $phone_number_rules = (phone_number_is_enabled_and_exists())
                                ? ['phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:'.$users_table]
                                : ['phone_number' => 'string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:'.$users_table];
        
        $account_type_rules = (account_type_is_enabled_and_exists())
                                ? ['account_type_id'   => 'nullable|int']
                                : [];

        return array_merge([
            'name'              => 'string|unique:'.$users_table,
            'gender'            => 'string',
            'password'          => 'string|min:6|confirmed',
        ], $email_rules, $phone_number_rules, $proper_names_rules, $account_type_rules);
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [
            'last_name' => [
                Uppercase::class,
            ],
            
            'first_name' => [
                CapitalizeEachWords::class,
            ],
        ];
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->createUserAccount($this ->validated());
    }
}