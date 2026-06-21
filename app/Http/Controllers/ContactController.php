<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ContactServiceInterface;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactServiceInterface $contactService
    ) {}

    public function index()
    {
        return view('pages.contact', [
            'contactInfo' => $this->contactService->getContactInfo(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Your inquiry has been received. Our concierge will respond within 24 hours.');
    }
}
