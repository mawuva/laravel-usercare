<?php

namespace Mawuekom\Usercare\Services;

use Mawuekom\CustomUser\Actions\StoreUserAction;
use Mawuekom\CustomUser\DataTransferObjects\StoreUserDTO;
use Mawuekom\Usercare\Repositories\UserRepository;

class UserService
{
    /**
     * @var \Mawuekom\Usercare\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Entity name
     *
     * @var string
     */
    protected $slug;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Usercare\Repositories\UserRepository $userRepository
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this ->slug            = config('custom-user.user.slug');
        $this ->userRepository  = $userRepository;
    }

    /**
     * Create new user account.
     *
     * @param \Mawuekom\Usercare\DataTransferObjects\UserDTO $data
     *
     * @return array
     */
    public function create(StoreUserDTO $storeUserDTO): array
    {
        $user = app(StoreUserAction::class) ->execute($storeUserDTO);

        return success_response(trans('lang-resources::commons.messages.entity.created', [
                'Entity' => trans_choice('usercare::entity.user', 1)
            ]), $user, 201);
    }
}