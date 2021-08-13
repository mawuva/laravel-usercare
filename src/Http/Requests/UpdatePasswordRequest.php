<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\Usercare\Persistables\UserAccountManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;
use Mawuekom\RequestSanitizer\Sanitizers\Uppercase;

class UpdatePasswordRequest extends FormRequestCustomizer
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
        return [
            'old_password'  => 'required|string|min:6',
            'new_password'  => 'required|string|min:6|confirmed'
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
        return $this ->resetPassword($this ->route('id'), $this ->old_password, $this ->new_password);
    }
}
