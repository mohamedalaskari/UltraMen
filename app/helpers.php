<?php

use App\Contracts\Services\ContentServiceInterface;

if (!function_exists('content_text')) {
    function content_text(string $page, string $key, string $default = ''): string
    {
        return app(ContentServiceInterface::class)->text($page, $key, $default);
    }
}

if (!function_exists('content_image')) {
    function content_image(string $page, string $key, string $defaultPath = ''): string
    {
        return app(ContentServiceInterface::class)->image($page, $key, $defaultPath);
    }
}

if (!function_exists('content_url')) {
    function content_url(string $page, string $key, string $default = ''): string
    {
        return app(ContentServiceInterface::class)->url($page, $key, $default);
    }
}
