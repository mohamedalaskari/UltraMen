<?php

namespace App\Services;

use App\Contracts\Services\ConfirmationServiceInterface;

class ConfirmationService implements ConfirmationServiceInterface
{
    public function getOrderData(): array
    {
        return session('last_order', [
            'order_number' => 'N/A',
            'message'      => '',
            'items'        => [],
            'shipping'     => ['name' => '', 'line1' => '', 'line2' => null, 'city' => '', 'country' => ''],
            'totals'       => [
                'subtotal'       => '$0.00',
                'discount'       => '$0.00',
                'coupon_code'    => null,
                'shipping'       => '$0.00',
                'shipping_label' => 'Complimentary Shipping',
                'tax'            => '$0.00',
                'total'          => '$0.00',
            ],
            'payment'      => ['icon' => 'credit_card', 'method' => 'N/A'],
        ]);
    }
}
