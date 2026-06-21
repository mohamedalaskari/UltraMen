<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ConfirmationServiceInterface;

class ConfirmationController extends Controller
{
    public function __construct(
        private readonly ConfirmationServiceInterface $service
    ) {}

    public function index()
    {
        if (!session()->has('last_order')) {
            return redirect()->route('home');
        }

        $order = $this->service->getOrderData();

        return view('pages.confirmation', compact('order'));
    }
}
