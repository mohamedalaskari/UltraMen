<?php

namespace App\Services;

use App\Contracts\Services\CheckoutServiceInterface;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\ShippingZone;
use Illuminate\Support\Collection;

class CheckoutService implements CheckoutServiceInterface
{
    public function getOrderItems(): array
    {
        return array_values(session('cart', []));
    }

    public function getActiveZones(): Collection
    {
        return ShippingZone::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function getOrderTotals(?int $shippingZoneId = null, ?string $shippingMethod = null): array
    {
        $items    = array_values(session('cart', []));
        $subtotal = array_reduce($items, function ($carry, $item) {
            return $carry + (float) str_replace(['$', ','], '', $item['price']) * $item['qty'];
        }, 0.0);

        $shippingPrice = 0.0;
        $shippingLabel = 'Select shipping zone';

        if ($shippingZoneId && in_array($shippingMethod, ['standard', 'express'], true)) {
            $zone = ShippingZone::where('is_active', true)->find($shippingZoneId);

            if ($zone) {
                $shippingPrice = $shippingMethod === 'express' ? (float) $zone->express_price : (float) $zone->standard_price;
                $daysLabel      = $shippingMethod === 'express' ? $zone->express_days_label : $zone->standard_days_label;
                $shippingLabel  = $zone->name . ' · ' . ucfirst($shippingMethod) . ' (' . $daysLabel . ')';
            }
        }

        $discount   = 0.0;
        $couponCode = null;

        $appliedCoupon = session('coupon');
        if ($appliedCoupon) {
            $coupon = Coupon::find($appliedCoupon['id'] ?? null);
            if ($coupon && $coupon->isValidFor($subtotal)) {
                $discount   = $coupon->calculateDiscount($subtotal);
                $couponCode = $coupon->code;
            } else {
                session()->forget('coupon');
            }
        }

        $taxableAmount = max($subtotal - $discount, 0);
        $taxEnabled    = (bool) Setting::get('tax_enabled', false);
        $taxRate       = (float) Setting::get('tax_rate', 0);
        $tax           = $taxEnabled ? $taxableAmount * ($taxRate / 100) : 0;
        $total         = $taxableAmount + $shippingPrice + $tax;

        return [
            'subtotal'       => '$' . number_format($subtotal, 2),
            'discount'       => '$' . number_format($discount, 2),
            'coupon_code'    => $couponCode,
            'shipping'       => '$' . number_format($shippingPrice, 2),
            'shipping_label' => $shippingLabel,
            'tax'            => '$' . number_format($tax, 2),
            'total'          => '$' . number_format($total, 2),
        ];
    }
}
