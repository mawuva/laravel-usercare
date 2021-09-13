<?php

namespace Mawuekom\Usercare\Services;

use Mawuekom\Usercare\Contracts\Persistables\UserAccountManager as UserAccountManagerContract;
use Mawuekom\Usercare\Persistables\UserAccountManager;
use Mawuekom\Usercare\Repositories\UserRepository;

class UserAccountService implements UserAccountManagerContract
{
    use UserAccountManager;

    protected $resource;

    /**
     * @var \Mawuekom\Usercare\Repositories\UserRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Usercare\Repositories\UserRepository $userRepository
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this ->resource    = config('usercare.user.resource_name');
        $this ->repository  = $userRepository;
    }
}