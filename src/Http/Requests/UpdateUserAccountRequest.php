<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\Usercare\Persistables\UserAccountManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;
use Mawuekom\RequestSanitizer\Sanitizers\Uppercase;

class UpdateUserAccountRequest extends FormRequestCustomizer
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
        $resource = config('usercare.user.resource_name');
        $user = $this ->validateAndGetResourceById($this ->route('id'), $resource);

        $users_table = config('usercare.user.table.name');
        $users_table_pk = config('usercare.user.table.primary_key');

        $email_is_optional = config('usercare.user.email_is_optional');

        $proper_names_rules = (proper_names_is_enabled_and_exists())
                                ? ['last_name' => 'required|string', 'first_name' => 'required|string']
                                : [];

        $email_rules = ($email_is_optional)
                        ? ['email' => 'string|email|unique:'.$users_table.',email,'.$user ->{$users_table_pk}]
                        : ['email' => 'required|string|email|unique:'.$users_table.',email,'.$user ->{$users_table_pk}];
        
        $phone_number_rules = (phone_number_is_enabled_and_exists())
                                ? ['phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:'.$users_table.',phone_number,'.$user ->{$users_table_pk}]
                                : ['phone_number' => 'string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:'.$users_table.',phone_number,'.$user ->{$users_table_pk}];
        
        $account_type_rules = (account_type_is_enabled_and_exists())
                                ? ['account_type_id'   => 'nullable|int']
                                : [];

        return array_merge([
            'name'              => 'string|unique:'.$users_table.',name,'.$user ->{$users_table_pk},
            'gender'            => 'string'
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
        return $this ->updateUser($this ->route('id'), $this ->validated());
    }
}
