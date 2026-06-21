<?php

namespace App\Services;

use App\Contracts\Services\AboutServiceInterface;
use App\Contracts\Services\ContentServiceInterface;

class AboutService implements AboutServiceInterface
{
    public function __construct(
        private readonly ContentServiceInterface $content
    ) {}

    public function getPillars(): array
    {
        return [
            [
                'number'      => '01',
                'title'       => $this->content->text('about', 'pillar_1_title', __('about.pillar_1_title')),
                'description' => $this->content->text('about', 'pillar_1_desc', __('about.pillar_1_desc')),
            ],
            [
                'number'      => '02',
                'title'       => $this->content->text('about', 'pillar_2_title', __('about.pillar_2_title')),
                'description' => $this->content->text('about', 'pillar_2_desc', __('about.pillar_2_desc')),
            ],
            [
                'number'      => '03',
                'title'       => $this->content->text('about', 'pillar_3_title', __('about.pillar_3_title')),
                'description' => $this->content->text('about', 'pillar_3_desc', __('about.pillar_3_desc')),
            ],
        ];
    }

    public function getPhilosophy(): array
    {
        $before    = $this->content->text('about', 'philosophy_headline_before');
        $highlight = $this->content->text('about', 'philosophy_headline_highlight');
        $after     = $this->content->text('about', 'philosophy_headline_after');

        $headline = e($before) . ' <span class="text-secondary">' . e($highlight) . '</span>' . e($after);

        return [
            'headline'    => $headline,
            'description' => $this->content->text('about', 'philosophy_description', __('about.philosophy_description')),
            'image'       => $this->content->imagePath('about', 'philosophy_image', 'images/about-craftsmanship.jpg'),
        ];
    }
}
