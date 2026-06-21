<?php

namespace App\Http\Controllers;

use App\Contracts\Services\HomePageServiceInterface;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomePageServiceInterface $homePageService
    ) {}

    public function index()
    {
        return view('pages.home', [
            'categories'  => $this->homePageService->getCategories(),
            'bestSellers' => $this->homePageService->getBestSellers(),
        ]);
    }
}
