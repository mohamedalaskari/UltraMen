<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'full_name', 'phone', 'email',
        'address', 'city', 'state', 'zip', 'country',
        'payment_method', 'subtotal', 'coupon_code', 'discount', 'tax', 'shipping',
        'shipping_zone_name', 'shipping_method', 'total', 'status',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax'      => 'decimal:2',
        'shipping' => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
