<?php

namespace Mawuekom\Usercare\Services;

use Mawuekom\Usercare\Contracts\Persistables\AccountTypeManager as AccountTypeManagerContract;
use Mawuekom\Usercare\Persistables\AccountTypeManager;
use Mawuekom\Usercare\Repositories\AccountTypeRepository;

class AccountTypeService implements AccountTypeManagerContract
{
    use AccountTypeManager;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var \Mawuekom\Usercare\Repositories\AccountTypeRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Usercare\Repositories\AccountTypeRepository $accountTypeRepository
     * 
     * @return void
     */
    public function __construct(AccountTypeRepository $accountTypeRepository)
    {
        $this ->resource    = config('usercare.account_type.resource_name');
        $this ->repository  = $accountTypeRepository;
    }
}