<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ProductServiceInterface;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductServiceInterface $service
    ) {}

    public function show(string $slug)
    {
        $product = $this->service->getProduct($slug);
        $related = $this->service->getRelatedProducts();

        return view('pages.product', compact('product', 'related', 'slug'));
    }
}
