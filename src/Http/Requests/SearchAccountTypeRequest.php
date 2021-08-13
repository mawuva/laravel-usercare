<?php

namespace Mawuekom\Usercare\Http\Requests;

use Mawuekom\Usercare\Persistables\AccountTypeManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class SearchAccountTypeRequest extends FormRequestCustomizer
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
            'searchTerm'          => 'required|string',
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
     * Fulfill the create account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->searchAccountTypes($this ->searchTerm);
    }
}