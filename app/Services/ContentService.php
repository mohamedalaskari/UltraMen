<?php

namespace App\Services;

use App\Contracts\Services\ContentServiceInterface;
use App\Models\ContentBlock;
use Illuminate\Support\Facades\Storage;

class ContentService implements ContentServiceInterface
{
    private array $cache = [];

    public function text(string $page, string $key, string $default = ''): string
    {
        $block = $this->blockFor($page, $key);
        $locale = app()->getLocale();
        $value = $block?->{"value_{$locale}"};

        if ($value !== null && $value !== '') {
            return $value;
        }

        return $default !== '' ? $default : $this->schemaDefault($page, $key, $locale);
    }

    public function image(string $page, string $key, string $defaultPath = ''): string
    {
        return asset('storage/' . $this->imagePath($page, $key, $defaultPath));
    }

    public function url(string $page, string $key, string $default = ''): string
    {
        $block = $this->blockFor($page, $key);

        return $block?->value_en ?: $default;
    }

    public function imagePath(string $page, string $key, string $defaultPath = ''): string
    {
        $block = $this->blockFor($page, $key);

        return $block?->value_en ?: $defaultPath;
    }

    public function getPageFields(string $page): array
    {
        $schema = config("content_schema.{$page}", []);

        return array_map(function (array $field) use ($page) {
            $block = $this->blockFor($page, $field['key']);

            if ($field['type'] === 'image') {
                $field['current_path'] = $block?->value_en ?: $field['default_path'];
            } elseif ($field['type'] === 'url') {
                $field['value'] = $block?->value_en ?: $field['default'];
            } else {
                $field['value_en'] = $block?->value_en ?: $field['default_en'];
                $field['value_ar'] = $block?->value_ar ?: $field['default_ar'];
            }

            return $field;
        }, $schema);
    }

    public function savePage(string $page, array $input, array $files): void
    {
        $schema = config("content_schema.{$page}", []);

        foreach ($schema as $field) {
            $key = $field['key'];

            if ($field['type'] === 'image') {
                if (!isset($files[$key])) {
                    continue;
                }

                $existing = ContentBlock::where('page', $page)->where('key', $key)->first();
                if ($existing?->value_en) {
                    Storage::disk('public')->delete($existing->value_en);
                }

                $path = $files[$key]->store('content', 'public');

                ContentBlock::updateOrCreate(
                    ['page' => $page, 'key' => $key],
                    ['type' => 'image', 'value_en' => $path, 'value_ar' => null]
                );
            } elseif ($field['type'] === 'url') {
                ContentBlock::updateOrCreate(
                    ['page' => $page, 'key' => $key],
                    ['type' => 'url', 'value_en' => $input[$key] ?? '', 'value_ar' => null]
                );
            } else {
                ContentBlock::updateOrCreate(
                    ['page' => $page, 'key' => $key],
                    [
                        'type' => $field['type'],
                        'value_en' => $input["{$key}_en"] ?? '',
                        'value_ar' => $input["{$key}_ar"] ?? '',
                    ]
                );
            }
        }
    }

    private function blockFor(string $page, string $key): ?ContentBlock
    {
        if (!isset($this->cache[$page])) {
            $this->cache[$page] = ContentBlock::where('page', $page)->get()->keyBy('key');
        }

        return $this->cache[$page]->get($key);
    }

    private function schemaDefault(string $page, string $key, string $locale): string
    {
        foreach (config("content_schema.{$page}", []) as $field) {
            if ($field['key'] === $key) {
                return $field["default_{$locale}"] ?? $field['default_en'] ?? '';
            }
        }

        return '';
    }
}
