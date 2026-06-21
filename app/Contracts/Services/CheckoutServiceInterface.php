<?php

namespace App\Contracts\Services;

interface CheckoutServiceInterface
{
    public function getOrderItems(): array;
    public function getOrderTotals(?int $shippingZoneId = null, ?string $shippingMethod = null): array;
    public function getActiveZones(): \Illuminate\Support\Collection;
}
