<?php

namespace App\Contracts\Services;

interface ProductServiceInterface
{
    public function getProduct(string $slug): array;
    public function getRelatedProducts(): array;
}
