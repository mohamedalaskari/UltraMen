<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AboutServiceInterface;

class AboutController extends Controller
{
    public function __construct(
        private readonly AboutServiceInterface $aboutService
    ) {}

    public function index()
    {
        return view('pages.about', [
            'pillars'    => $this->aboutService->getPillars(),
            'philosophy' => $this->aboutService->getPhilosophy(),
        ]);
    }
}
