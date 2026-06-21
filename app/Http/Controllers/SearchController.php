<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CollectionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function __construct(
        private readonly CollectionServiceInterface $collectionService
    ) {}

    public function suggest(Request $request): JsonResponse
    {
        $term = (string) $request->query('q', '');

        return response()->json([
            'results' => $this->collectionService->quickSearch($term),
        ]);
    }
}
