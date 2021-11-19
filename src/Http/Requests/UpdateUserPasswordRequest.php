<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\Usercare\DataTransferObjects\UpdateUserPasswordDTO;
use Mawuekom\Usercare\Services\UserService;

class UpdateUserPasswordRequest extends FormRequestCustomizer
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
        return [
            'old_password'  => 'string|min:6',
            'new_password'  => 'string|min:6|confirmed'
        ];
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [];
    }

    /**
     * Build and return a DTO
     *
     * @return \Mawuekom\Usercare\DataTransferObjects\UpdateUserPasswordDTO
     */
    public function toDTO(): UpdateUserPasswordDTO
    {
        return new UpdateUserPasswordDTO([
            'old_password'  => $this ->old_password,
            'new_password'  => $this ->new_password
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
        
        return $this ->userService ->updatePassword($userIDRouteParam, $this ->toDTO());
    }
}