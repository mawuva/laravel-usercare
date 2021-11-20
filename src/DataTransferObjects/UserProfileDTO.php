<?php

namespace Mawuekom\Usercare\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class UserProfileDTO extends DataTransferObject
{
    public string|null $location;
    public string|null $bio;
    public string|null $description;
}