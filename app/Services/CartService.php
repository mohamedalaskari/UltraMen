<?php

namespace App\Services;

use App\Contracts\Services\CartServiceInterface;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;

class CartService implements CartServiceInterface
{
    public function getCartItems(): array
    {
        return array_values(session('cart', []));
    }

    public function getRelatedProducts(): array
    {
        $inCart = array_keys(session('cart', []));

        return Product::when(!empty($inCart), fn($q) => $q->whereNotIn('slug', $inCart))
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->map(fn($p) => [
                'slug'             => $p->slug,
                'name'             => $p->name,
                'price'            => $p->price_formatted,
                'original_price'   => $p->original_price_formatted,
                'discount_percent' => $p->discount_percent,
                'image'            => $p->image,
            ])
            ->toArray();
    }

    public function getOrderSummary(): array
    {
        $summary = $this->cartSummary(session('cart', []));

        return [
            'subtotal'    => $summary['subtotal'],
            'shipping'    => 'Complimentary',
            'discount'    => $summary['discount'],
            'coupon_code' => $summary['coupon_code'],
            'tax'         => $summary['tax'],
            'total'       => $summary['total'],
        ];
    }

    public function cartSummary(array $cart): array
    {
        $items    = array_values($cart);
        $subtotal = array_reduce($items, function ($carry, $item) {
            return $carry + (float) str_replace(['$', ','], '', $item['price']) * $item['qty'];
        }, 0.0);

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

        $taxEnabled     = (bool) Setting::get('tax_enabled', false);
        $taxRate        = (float) Setting::get('tax_rate', 0);
        $taxableAmount  = max($subtotal - $discount, 0);
        $tax            = $taxEnabled ? $taxableAmount * ($taxRate / 100) : 0;
        $total          = $taxableAmount + $tax;

        return [
            'items'       => $items,
            'count'       => array_sum(array_column($items, 'qty')),
            'subtotal'    => '$' . number_format($subtotal, 2),
            'discount'    => '$' . number_format($discount, 2),
            'coupon_code' => $couponCode,
            'tax'         => '$' . number_format($tax, 2),
            'total'       => '$' . number_format($total, 2),
        ];
    }
}
