<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CollectionServiceInterface
{
    public function getProducts(Request $request): LengthAwarePaginator;
    public function getFilters(): array;
    public function getSortOptions(): array;
    public function quickSearch(string $term, int $limit = 6): array;
}
