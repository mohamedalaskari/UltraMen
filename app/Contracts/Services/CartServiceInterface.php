<?php

namespace App\Contracts\Services;

interface CartServiceInterface
{
    public function getCartItems(): array;
    public function getRelatedProducts(): array;
    public function getOrderSummary(): array;
    public function cartSummary(array $cart): array;
}
