<?php

namespace App\Contracts\Services;

interface ContentServiceInterface
{
    public function text(string $page, string $key, string $default = ''): string;

    public function image(string $page, string $key, string $defaultPath = ''): string;

    public function imagePath(string $page, string $key, string $defaultPath = ''): string;

    public function url(string $page, string $key, string $default = ''): string;

    public function getPageFields(string $page): array;

    public function savePage(string $page, array $input, array $files): void;
}
