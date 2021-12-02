<?php

namespace Mawuekom\Usercare\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;
use Mawuekom\Usercare\DataTransferObjects\AccountTypeDTO;
use Mawuekom\Usercare\Services\AccountTypeService;

class UpdateAccountTypeRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Usercare\Services\AccountTypeService
     */
    protected $accountTypeService;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Usercare\Services\AccountTypeService $useaccountTypeServicerService
     */
    public function __construct(AccountTypeService $accountTypeService)
    {
        parent::__construct();
        $this ->accountTypeService = $accountTypeService;
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
        $accountTypesTable = config('usercare.account_type.table.name');
        $accountTypeIDRouteParam = $this ->route(config('usercare.account_type.id_route_param'));
        $key = resolve_key(config('usercare.account_type.model'), $accountTypeIDRouteParam);

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                Rule::unique($accountTypesTable, 'slug') ->ignore($accountTypeIDRouteParam, $key)
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
            ]
        ];
    }

    /**
     * Build and return a DTO
     *
     * @return \Mawuekom\Usercare\DataTransferObjects\AccountTypeDTO
     */
    public function toDTO(): AccountTypeDTO
    {
        return new AccountTypeDTO([
            'name'          => $this ->name,
            'slug'          => $this ->slug,
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
        $accountTypeIDRouteParam = $this ->route(config('usercare.account_type.id_route_param'));

        return $this ->accountTypeService ->update($accountTypeIDRouteParam, $this ->toDTO());
    }
}