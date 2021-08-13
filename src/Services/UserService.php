<?php

namespace Mawuekom\Usercare\Services;

use Mawuekom\Usercare\Contracts\Persistables\UserManager as UserManagerContract;
use Mawuekom\Usercare\Persistables\UserManager;
use Mawuekom\Usercare\Repositories\UserRepository;

class UserService implements UserManagerContract
{
    use UserManager;

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