<?php

namespace App\Services;

use App\Contracts\Services\ArchiveServiceInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArchiveService implements ArchiveServiceInterface
{
    private const PER_PAGE = 5;

    private ?LengthAwarePaginator $paginator = null;

    public function getFeaturedProduct(): ?array
    {
        $p = $this->page()->first();

        return $p ? $this->formatFeatured($p) : null;
    }

    public function getGridProducts(): array
    {
        return $this->page()
            ->skip(1)
            ->map(fn($p) => $this->formatGridItem($p))
            ->values()
            ->toArray();
    }

    public function getFilters(): array
    {
        return [
            'total' => Product::whereJsonContains('labels', 'best_seller')->count(),
        ];
    }

    public function getPagination(): array
    {
        $paginator = $this->paginator();

        return [
            'current'  => $paginator->currentPage(),
            'total'    => $paginator->lastPage(),
            'prev_url' => $paginator->previousPageUrl(),
            'next_url' => $paginator->nextPageUrl(),
        ];
    }

    private function page(): Collection
    {
        return collect($this->paginator()->items());
    }

    private function paginator(): LengthAwarePaginator
    {
        if ($this->paginator === null) {
            $this->paginator = Product::whereJsonContains('labels', 'best_seller')
                ->orderBy('sort_order')
                ->paginate(self::PER_PAGE);
        }

        return $this->paginator;
    }

    private function formatFeatured(Product $p): array
    {
        return [
            'name'             => $p->name,
            'subtitle'         => $p->subtitle,
            'price'            => $p->price_formatted,
            'original_price'   => $p->original_price_formatted,
            'discount_percent' => $p->discount_percent,
            'image'            => $p->image,
            'slug'             => $p->slug,
        ];
    }

    private function formatGridItem(Product $p): array
    {
        return [
            'name'             => $p->name,
            'subtitle'         => $p->subtitle,
            'price'            => $p->price_formatted,
            'original_price'   => $p->original_price_formatted,
            'discount_percent' => $p->discount_percent,
            'image'            => $p->image,
            'badge'            => $p->badge,
            'slug'             => $p->slug,
        ];
    }
}
