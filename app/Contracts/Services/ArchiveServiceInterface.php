<?php

namespace App\Contracts\Services;

interface ArchiveServiceInterface
{
    public function getFeaturedProduct(): ?array;
    public function getGridProducts(): array;
    public function getFilters(): array;
    public function getPagination(): array;
}
