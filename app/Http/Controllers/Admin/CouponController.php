<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCoupon($request);
        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created.');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $this->validateCoupon($request, $coupon);
        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon \"{$coupon->code}\" updated.");
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted.');
    }

    private function validateCoupon(Request $request, ?Coupon $coupon = null): array
    {
        $validated = $request->validate([
            'code'              => 'required|string|max:50|unique:coupons,code,' . ($coupon?->id ?? 'NULL'),
            'type'              => 'required|in:fixed,percentage',
            'value'             => 'required|numeric|min:0.01|max:' . ($request->input('type') === 'percentage' ? '100' : '999999'),
            'min_order_amount'  => 'nullable|numeric|min:0',
            'max_uses'          => 'nullable|integer|min:1',
            'expires_at'        => 'nullable|date',
        ]);

        $validated['code']      = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
