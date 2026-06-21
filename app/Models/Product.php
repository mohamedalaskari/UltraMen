<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug', 'name_en', 'name_ar', 'category', 'subtitle_en', 'subtitle_ar',
        'price', 'original_price', 'badge',
        'description_en', 'description_ar', 'image', 'secondary_image',
        'gallery', 'finishes', 'sizes', 'trust', 'accordions',
        'is_best_seller', 'in_collections', 'is_archive_featured', 'in_archive',
        'labels', 'sort_order',
    ];

    protected $casts = [
        'gallery'             => 'array',
        'finishes'            => 'array',
        'sizes'               => 'array',
        'trust'               => 'array',
        'accordions'          => 'array',
        'labels'              => 'array',
        'is_best_seller'      => 'boolean',
        'in_collections'      => 'boolean',
        'is_archive_featured' => 'boolean',
        'in_archive'          => 'boolean',
        'price'               => 'decimal:2',
        'original_price'      => 'decimal:2',
    ];

    public const LABELS = [
        'best_seller'     => 'Best Seller',
        'new_arrival'     => 'New Arrival',
        'featured'        => 'Featured',
        'limited_edition' => 'Limited Edition',
        'sale'            => 'Sale',
    ];

    public function hasLabel(string $label): bool
    {
        return in_array($label, $this->labels ?? []);
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->attributes["name_{$locale}"] ?: $this->attributes['name_en'];
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->attributes["subtitle_{$locale}"] ?: $this->attributes['subtitle_en'];
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->attributes["description_{$locale}"] ?: $this->attributes['description_en'];
    }

    public function getCategoryNameAttribute(): ?string
    {
        return Category::where('slug', $this->attributes['category'])->first()?->name;
    }

    public function getPriceFormattedAttribute(): string
    {
        return '$' . number_format((float) $this->price, 2);
    }

    public function getHasDiscountAttribute(): bool
    {
        return !empty($this->original_price) && (float) $this->original_price > (float) $this->price;
    }

    public function getOriginalPriceFormattedAttribute(): ?string
    {
        return $this->has_discount ? '$' . number_format((float) $this->original_price, 2) : null;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (!$this->has_discount) {
            return null;
        }

        return (int) round((1 - ((float) $this->price / (float) $this->original_price)) * 100);
    }
}
