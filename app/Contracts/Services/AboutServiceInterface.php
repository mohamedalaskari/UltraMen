<?php

namespace App\Contracts\Services;

interface AboutServiceInterface
{
    public function getPillars(): array;
    public function getPhilosophy(): array;
}
