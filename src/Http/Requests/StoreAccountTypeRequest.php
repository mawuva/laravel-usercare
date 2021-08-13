<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;
use Mawuekom\Usercare\Persistables\AccountTypeManager;

class StoreAccountTypeRequest extends FormRequestCustomizer
{
    use AccountTypeManager;

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
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.config('usercare.account_type.table.name').',slug'
            ],
            'description'   => 'string',
        ];
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
                Capitalize::class,
            ],
        ];
    }

    /**
     * Fulfill the create account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->createAccountType($this ->validated());
    }
}