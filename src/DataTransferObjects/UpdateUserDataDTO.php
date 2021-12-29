<?php

namespace Mawuekom\Usercare\DataTransferObjects;

use Mawuekom\CustomUser\DataTransferObjects\UpdateUserDTO;

class UpdateUserDataDTO extends UpdateUserDTO
{
    public string|null $account_type;
    public string|null $role;
}