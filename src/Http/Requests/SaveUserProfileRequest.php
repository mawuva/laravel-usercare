<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\Usercare\DataHelper\UserProfileHelper;
use Mawuekom\Usercare\DataTransferObjects\UserProfileDTO;
use Mawuekom\Usercare\Services\UserService;

class SaveUserProfileRequest extends FormRequestCustomizer
{
    use UserProfileHelper;

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
            'location'      => 'string|nullable',
            'bio'           => 'string|nullable',
            'description'   => 'string|nullable',
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
     * @return \Mawuekom\Usercare\DataTransferObjects\UserProfileDTO
     */
    public function toDTO(): UserProfileDTO
    {
        return new UserProfileDTO([
            'location'      => $this ->location,
            'bio'           => $this ->bio,
            'description'   => $this ->description,
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

        return $this ->updateProfile($userIDRouteParam, $this ->toDTO());
    }
}