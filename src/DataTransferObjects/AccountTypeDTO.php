<?php

namespace Mawuekom\Usercare\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class AccountTypeDTO extends DataTransferObject
{
    public string $name;
    public string|null $slug;
    public string|null $description;
}