<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CollectionServiceInterface;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct(
        private readonly CollectionServiceInterface $collectionService
    ) {}

    public function index(Request $request)
    {
        $products = $this->collectionService->getProducts($request);

        if ($request->ajax()) {
            return view('pages.partials.collections-grid', compact('products'));
        }

        return view('pages.collections', [
            'products'    => $products,
            'filters'     => $this->collectionService->getFilters(),
            'sortOptions' => $this->collectionService->getSortOptions(),
        ]);
    }
}
