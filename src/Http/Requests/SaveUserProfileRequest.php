<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\Usercare\Persistables\UserProfileManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class SaveUserProfileRequest extends FormRequestCustomizer
{
    use UserProfileManager;

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
            'location'      => 'string',
            'bio'           => 'string'
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
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->saveDatas($this ->route('id'), $this ->validated());
    }
}
