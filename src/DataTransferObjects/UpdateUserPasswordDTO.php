<?php

namespace Mawuekom\Usercare\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateUserPasswordDTO extends DataTransferObject
{
    public string $old_password;
    public string $new_password;
}