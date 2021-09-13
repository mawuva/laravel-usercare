<?php

namespace Mawuekom\Usercare\Featurables;

trait HasProperNames
{
    /**
     * Set last name to uppercase.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setLastNameAttribute($value): void
    {
        $this ->attributes['last_name'] = strtoupper($value);
    }

    /**
     * Set each first name first letter to uppercase.
     *
     * @param string $value
     * 
     * @return void
     */
    public function setFirstNameAttribute($value): void
    {
        $this ->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Get user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return (proper_names_is_enabled_and_exists())
                ? "{$this->attributes['first_name']} {$this->attributes['last_name']}"
                : "{$this->attributes['name']}";
    }
}
