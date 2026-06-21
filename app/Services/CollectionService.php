<?php

namespace App\Services;

use App\Contracts\Services\CollectionServiceInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CollectionService implements CollectionServiceInterface
{
    public function getProducts(Request $request): LengthAwarePaginator
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('name_en', 'like', "%{$term}%")
                  ->orWhere('name_ar', 'like', "%{$term}%")
                  ->orWhere('subtitle_en', 'like', "%{$term}%")
                  ->orWhere('subtitle_ar', 'like', "%{$term}%")
                  ->orWhere('description_en', 'like', "%{$term}%")
                  ->orWhere('description_ar', 'like', "%{$term}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        if ($request->filled('label')) {
            $query->whereJsonContains('labels', $request->input('label'));
        }

        $sort = $request->input('sort', 'default');
        if ($sort === 'price_asc') {
            $query->orderBy('price');
        } elseif ($sort === 'price_desc') {
            $query->orderByDesc('price');
        } elseif ($sort === 'popular') {
            $query->whereJsonContains('labels', 'best_seller')->orderBy('sort_order');
        } else {
            $query->orderBy('sort_order');
        }

        return $query->paginate(9)->withQueryString()->through(fn($p) => [
            'name'             => $p->name,
            'category'         => $p->category_name,
            'category_slug'    => $p->category,
            'price'            => $p->price_formatted,
            'original_price'   => $p->original_price_formatted,
            'discount_percent' => $p->discount_percent,
            'image'            => $p->image,
            'secondary_image'  => $p->secondary_image,
            'slug'             => $p->slug,
            'labels'           => $p->labels ?? [],
        ]);
    }

    public function getFilters(): array
    {
        $categoryNames = \App\Models\Category::all()->pluck('name', 'slug');

        $categories = Product::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get()
            ->map(fn($p) => [
                'slug'  => $p->category,
                'name'  => $categoryNames[$p->category] ?? $p->category,
                'count' => $p->total,
            ])
            ->sortBy('name')
            ->values()
            ->toArray();

        $labelMeta = [
            'new_arrival'     => ['label' => 'New Arrivals',    'icon' => 'new_releases'],
            'best_seller'     => ['label' => 'Best Sellers',    'icon' => 'workspace_premium'],
            'sale'            => ['label' => 'Sale',            'icon' => 'sell'],
            'limited_edition' => ['label' => 'Limited Edition', 'icon' => 'diamond'],
            'featured'        => ['label' => 'Featured',        'icon' => 'star'],
        ];

        $labels = collect($labelMeta)->map(fn($meta, $key) => array_merge($meta, [
            'key'   => $key,
            'count' => Product::whereJsonContains('labels', $key)->count(),
        ]))->values()->filter(fn($l) => $l['count'] > 0)->toArray();

        return [
            'categories' => $categories,
            'labels'     => $labels,
            'price_min'  => 0,
            'price_max'  => 1000000,
        ];
    }

    public function getSortOptions(): array
    {
        return [
            'default'    => 'Featured',
            'popular'    => 'Most Popular',
            'price_asc'  => 'Price: Low to High',
            'price_desc' => 'Price: High to Low',
        ];
    }

    public function quickSearch(string $term, int $limit = 6): array
    {
        $term = trim($term);

        if ($term === '') {
            return [];
        }

        return Product::query()
            ->where(function ($q) use ($term) {
                $q->where('name_en', 'like', "%{$term}%")
                  ->orWhere('name_ar', 'like', "%{$term}%")
                  ->orWhere('subtitle_en', 'like', "%{$term}%")
                  ->orWhere('subtitle_ar', 'like', "%{$term}%");
            })
            ->orderBy('sort_order')
            ->limit($limit)
            ->get()
            ->map(fn($p) => [
                'name'  => $p->name,
                'slug'  => $p->slug,
                'price' => $p->price_formatted,
                'image' => asset('storage/' . $p->image),
                'url'   => route('product.show', $p->slug),
            ])
            ->toArray();
    }
}
