<?php

namespace App\Services;

use App\Contracts\Services\HomePageServiceInterface;
use App\Models\Category;
use App\Models\Product;

class HomePageService implements HomePageServiceInterface
{
    public function getCategories(): array
    {
        return Category::orderBy('sort_order')
            ->limit(4)
            ->get()
            ->map(fn($c) => [
                'name'  => $c->name,
                'slug'  => $c->slug,
                'image' => $c->image,
                'span'  => $c->span,
                'delay' => $c->delay,
            ])
            ->toArray();
    }

    public function getBestSellers(): array
    {
        $delays = ['0ms', '100ms', '200ms', '300ms'];

        return Product::whereJsonContains('labels', 'best_seller')
            ->orderBy('sort_order')
            ->get()
            ->values()
            ->map(fn($p, $i) => [
                'name'             => $p->name,
                'price'            => $p->price_formatted,
                'original_price'   => $p->original_price_formatted,
                'discount_percent' => $p->discount_percent,
                'image'            => $p->image,
                'slug'             => $p->slug,
                'labels'           => $p->labels ?? [],
                'delay'            => $delays[$i] ?? '0ms',
            ])
            ->toArray();
    }
}
