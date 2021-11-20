<?php

namespace Mawuekom\Usercare\DataTransferObjects;

use Mawuekom\CustomUser\DataTransferObjects\StoreUserDTO;

class CreateUserDTO extends StoreUserDTO
{
    public string|null $account_type;
}