<?php

namespace App\Services;

use App\Contracts\Services\ContactServiceInterface;
use App\Contracts\Services\ContentServiceInterface;

class ContactService implements ContactServiceInterface
{
    public function __construct(
        private readonly ContentServiceInterface $content
    ) {}

    public function getContactInfo(): array
    {
        $hours = $this->content->text('contact', 'hours');

        return [
            'showroom' => [
                'address' => $this->content->text('contact', 'showroom_address'),
                'city'    => $this->content->text('contact', 'showroom_city'),
                'country' => $this->content->text('contact', 'showroom_country'),
            ],
            'email' => $this->content->text('contact', 'contact_email', 'concierge@ultra.luxury'),
            'phone' => $this->content->text('contact', 'contact_phone', '+1 (212) 555-0198'),
            'hours' => array_filter(array_map('trim', explode("\n", $hours))),
        ];
    }
}
