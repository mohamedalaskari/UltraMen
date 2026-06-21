<?php

namespace App\Contracts\Services;

interface HomePageServiceInterface
{
    public function getCategories(): array;
    public function getBestSellers(): array;
}
