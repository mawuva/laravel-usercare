<?php

namespace Mawuekom\Usercare\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Slugable
{
    /**
     * Set slug attributes
     *
     * @param string $value
     *
     * @return void
     */
    public function setSlugAttribute(string $value): void
    {
        $this ->attributes['slug'] = Str::slug($value, config('userly.separator'));
    }

    /**
     * Scope a query to check slug existence
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckSlug(Builder $query, string $slug): Builder
    {
        return $query ->where('slug', $slug);
    }
}