<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'standard_price', 'standard_days_min', 'standard_days_max',
        'express_price', 'express_days_min', 'express_days_max',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'standard_price'     => 'decimal:2',
        'standard_days_min'  => 'integer',
        'standard_days_max'  => 'integer',
        'express_price'      => 'decimal:2',
        'express_days_min'   => 'integer',
        'express_days_max'   => 'integer',
        'is_active'          => 'boolean',
    ];

    public function getStandardDaysLabelAttribute(): string
    {
        return $this->formatDaysLabel($this->standard_days_min, $this->standard_days_max);
    }

    public function getExpressDaysLabelAttribute(): string
    {
        return $this->formatDaysLabel($this->express_days_min, $this->express_days_max);
    }

    private function formatDaysLabel(int $min, int $max): string
    {
        if ($min === $max) {
            return $min . ' ' . ($min === 1 ? 'day' : 'days');
        }

        return "{$min}-{$max} days";
    }
}
