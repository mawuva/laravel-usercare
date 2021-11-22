<?php

namespace Mawuekom\Usercare\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;
use Mawuekom\Usercare\DataTransferObjects\CreateUserDTO;
use Mawuekom\Usercare\Services\UserService;

class StoreUserRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Usercare\Services\UserService
     */
    protected $userService;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Usercare\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this ->userService = $userService;
    }

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
        $usersTable = config('custom-user.user.table.name');

        $rules = [
            'name'                          => ['string'],

            'email'                         => [
                'required', 'string', 'email', Rule::unique($usersTable, 'email')
            ],
            
            'password'      => 'string|min:6|confirmed',
            'first_name'    => 'string|nullable',
            'phone_number'  => 'string|nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'account_type'  => 'integer|nullable',
            'is_admin'      => 'integer|nullable',
        ];

        (!get_attribute('name', 'optional'))
            ?? array_push($rules['name'], 'required');

        (get_attribute('phone_number', 'unique'))
            ?? array_push($rules['phone_number'], Rule::unique($usersTable, 'phone_number'));

        return $rules;
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [
            'name' => [
                CapitalizeEachWords::class,
            ],
            'first_name' => [
                CapitalizeEachWords::class,
            ],
        ];
    }

    /**
     * Build and return a DTO
     *
     * @return \Mawuekom\CustomUser\DataTransferObjects\StoreUserDTO|Mawuekom\Usercare\DataTransferObjects\CreateUserDTO
     */
    public function toDTO(): CreateUserDTO
    {
        return new CreateUserDTO([
            'name'          => $this ->name,
            'email'         => $this ->email,
            'password'      => $this ->password,
            'first_name'    => $this ->first_name,
            'phone_number'  => $this ->phone_number,
            'gender'        => $this ->gender,
            'account_type'  => $this ->account_type,
            'is_admin'      => $this ->is_admin,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->userService ->create($this ->toDTO());
    }
}