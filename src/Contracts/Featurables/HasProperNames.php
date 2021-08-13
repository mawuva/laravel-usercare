<?php

namespace Mawuekom\Usercare\Contracts\Featurables;

interface HasProperNames
{
    /**
     * Set last name to uppercase.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setLastNameAttribute($value): void;

    /**
     * Set each first name first letter to uppercase.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setFirstNameAttribute($value): void;

    /**
     * Get user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string;
}