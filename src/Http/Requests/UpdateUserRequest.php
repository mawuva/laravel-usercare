<?php

namespace Mawuekom\Usercare\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\CustomUser\DataTransferObjects\UpdateUserDTO;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;
use Mawuekom\Usercare\Services\UserService;

class UpdateUserRequest extends FormRequestCustomizer
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
        $userIDRouteParam = $this ->route(config('usercare.user.id_route_param'));
        $key = resolve_key(config('custom-user.user.slug'), $userIDRouteParam);

        $rules = [
            'name'                          => ['string'],

            'email'                         => [
                'required', 'string', 'email', 
                Rule::unique($usersTable, 'email') ->ignore($userIDRouteParam, $key)
            ],
            
            'password'      => 'string|min:6|confirmed',
            'first_name'    => 'string|nullable',
            'phone_number'  => 'string|nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'gender'        => 'string|nullable',
        ];

        (!get_attribute('name', 'optional'))
            ?? array_push($rules['name'], 'required');

        (get_attribute('phone_number', 'unique'))
            ?? array_push($rules['phone_number'], Rule::unique($usersTable, 'phone_number')->ignore($userIDRouteParam, $key));

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
     * @return \Mawuekom\CustomUser\DataTransferObjects\UpdateUserDTO
     */
    public function toDTO(): UpdateUserDTO
    {
        return new UpdateUserDTO([
            'name'          => $this ->name,
            'email'         => $this ->email,
            'password'      => $this ->password,
            'first_name'    => $this ->first_name,
            'phone_number'  => $this ->phone_number,
            'gender'        => $this ->gender,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        $userIDRouteParam = $this ->route(config('usercare.user.id_route_param'));

        return $this ->userService ->update($userIDRouteParam, $this ->toDTO());
    }
}