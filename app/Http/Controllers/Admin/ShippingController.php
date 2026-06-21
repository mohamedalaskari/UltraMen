<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::orderBy('sort_order')->orderBy('name')->get();

        $taxEnabled = (bool) Setting::get('tax_enabled', false);
        $taxRate    = Setting::get('tax_rate', '0');

        return view('admin.shipping.index', compact('zones', 'taxEnabled', 'taxRate'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateZone($request);
        ShippingZone::create($validated);

        return redirect()->route('admin.shipping.index')->with('success', 'Shipping zone added.');
    }

    public function update(Request $request, ShippingZone $zone)
    {
        $validated = $this->validateZone($request);
        $zone->update($validated);

        return redirect()->route('admin.shipping.index')->with('success', "Shipping zone \"{$zone->name}\" updated.");
    }

    public function destroy(ShippingZone $zone)
    {
        $zone->delete();

        return redirect()->route('admin.shipping.index')->with('success', 'Shipping zone deleted.');
    }

    public function updateTax(Request $request)
    {
        $validated = $request->validate([
            'tax_enabled' => 'nullable|boolean',
            'tax_rate'    => 'required|numeric|min:0|max:100',
        ]);

        Setting::set('tax_enabled', $request->boolean('tax_enabled') ? '1' : '0');
        Setting::set('tax_rate', $validated['tax_rate']);

        return redirect()->route('admin.shipping.index')->with('success', 'Tax settings updated.');
    }

    private function validateZone(Request $request): array
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'standard_price'     => 'required|numeric|min:0',
            'standard_days_min'  => 'required|integer|min:0',
            'standard_days_max'  => 'required|integer|gte:standard_days_min',
            'express_price'      => 'required|numeric|min:0',
            'express_days_min'   => 'required|integer|min:0',
            'express_days_max'   => 'required|integer|gte:express_days_min',
            'sort_order'         => 'nullable|integer|min:0',
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
