<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface;
use App\Models\Product;

class ProductService implements ProductServiceInterface
{
    public function getProduct(string $slug): array
    {
        $product = Product::where('slug', $slug)->first()
            ?? Product::where('slug', 'chronos-vii-titanium')->firstOrFail();

        return $this->toArray($product);
    }

    public function getRelatedProducts(): array
    {
        return Product::whereIn('slug', ['structured-wool-coat', 'forged-monolith-ring', 'core-leather-pack'])
            ->get()
            ->map(fn($p) => [
                'name'             => $p->name,
                'price'            => $p->price_formatted,
                'original_price'   => $p->original_price_formatted,
                'discount_percent' => $p->discount_percent,
                'image'            => $p->image,
                'slug'             => $p->slug,
            ])
            ->toArray();
    }

    private function toArray(Product $product): array
    {
        return [
            'slug'             => $product->slug,
            'name'             => $product->name,
            'category'         => $product->category_name,
            'subtitle'         => $product->subtitle,
            'price'            => $product->price_formatted,
            'original_price'   => $product->original_price_formatted,
            'discount_percent' => $product->discount_percent,
            'badge'            => $product->badge,
            'description'      => $product->description,
            'gallery'          => !empty($product->gallery) ? $product->gallery : [['image' => $product->image]],
            'trust'            => $product->trust,
            'finishes'         => $product->finishes,
            'sizes'            => $product->sizes,
            'accordions'       => $product->accordions,
        ];
    }
}
