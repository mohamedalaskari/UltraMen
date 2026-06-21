<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value',
        'min_order_amount', 'max_uses', 'used_count',
        'expires_at', 'is_active',
    ];

    protected $casts = [
        'value'             => 'decimal:2',
        'min_order_amount'  => 'decimal:2',
        'max_uses'          => 'integer',
        'used_count'        => 'integer',
        'expires_at'        => 'date',
        'is_active'         => 'boolean',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isUsageLimitReached(): bool
    {
        return $this->max_uses !== null && $this->used_count >= $this->max_uses;
    }

    public function isValidFor(float $subtotal): bool
    {
        if (!$this->is_active || $this->isExpired() || $this->isUsageLimitReached()) {
            return false;
        }

        return $this->min_order_amount === null || $subtotal >= (float) $this->min_order_amount;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            return round($subtotal * ((float) $this->value / 100), 2);
        }

        return min((float) $this->value, $subtotal);
    }

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        if ($this->isExpired()) {
            return 'Expired';
        }
        if ($this->isUsageLimitReached()) {
            return 'Limit Reached';
        }

        return 'Active';
    }
}
