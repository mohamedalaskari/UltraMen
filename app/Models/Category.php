<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'slug', 'name_en', 'name_ar', 'image', 'span', 'delay', 'sort_order',
    ];

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->attributes["name_{$locale}"] ?: $this->attributes['name_en'];
    }
}
