<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ArchiveServiceInterface;

class ArchiveController extends Controller
{
    public function __construct(
        private readonly ArchiveServiceInterface $archiveService
    ) {}

    public function index()
    {
        return view('pages.archive', [
            'featured'   => $this->archiveService->getFeaturedProduct(),
            'products'   => $this->archiveService->getGridProducts(),
            'filters'    => $this->archiveService->getFilters(),
            'pagination' => $this->archiveService->getPagination(),
        ]);
    }
}
