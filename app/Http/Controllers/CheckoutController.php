<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CheckoutServiceInterface;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutServiceInterface $service
    ) {}

    public function index()
    {
        if (empty(session('cart', []))) {
            return redirect()->route('cart');
        }

        $items  = $this->service->getOrderItems();
        $totals = $this->service->getOrderTotals();
        $zones  = $this->service->getActiveZones();

        return view('pages.checkout', compact('items', 'totals', 'zones'));
    }

    public function calculateTotals(Request $request)
    {
        $validated = $request->validate([
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'shipping_method'  => 'required|in:standard,express',
        ]);

        $totals = $this->service->getOrderTotals(
            (int) $validated['shipping_zone_id'],
            $validated['shipping_method']
        );

        return response()->json($totals);
    }

    public function process(Request $request)
    {
        $request->validate([
            'full_name'         => 'required|string|max:255',
            'phone'             => 'required|string|max:30',
            'email'             => 'required|email|max:255',
            'address'           => 'required|string|max:500',
            'city'              => 'required|string|max:100',
            'state'             => 'required|string|max:100',
            'zip'               => 'required|string|max:20',
            'shipping_zone_id'  => 'required|exists:shipping_zones,id',
            'shipping_method'   => 'required|in:standard,express',
        ]);

        $zoneId   = (int) $request->input('shipping_zone_id');
        $method   = $request->input('shipping_method');
        $zone     = ShippingZone::where('is_active', true)->findOrFail($zoneId);

        $totals = $this->service->getOrderTotals($zoneId, $method);
        $items  = $this->service->getOrderItems();

        $payMethod    = ['icon' => 'payments', 'method' => 'Cash on Delivery'];
        $orderNumber  = 'ULTRA-' . strtoupper(Str::random(6));

        $toDecimal = fn(string $price) => (float) str_replace(['$', ','], '', $price);

        $order = Order::create([
            'order_number'       => $orderNumber,
            'full_name'          => $request->input('full_name'),
            'phone'              => $request->input('phone'),
            'email'              => $request->input('email'),
            'address'            => $request->input('address'),
            'city'               => $request->input('city'),
            'state'              => $request->input('state'),
            'zip'                => $request->input('zip'),
            'payment_method'     => 'cod',
            'subtotal'           => $toDecimal($totals['subtotal']),
            'coupon_code'        => $totals['coupon_code'],
            'discount'           => $toDecimal($totals['discount']),
            'tax'                => $toDecimal($totals['tax']),
            'shipping'           => $toDecimal($totals['shipping']),
            'shipping_zone_name' => $zone->name,
            'shipping_method'    => $method,
            'total'              => $toDecimal($totals['total']),
            'status'             => 'pending',
        ]);

        foreach ($items as $item) {
            $order->items()->create([
                'slug'  => $item['slug'],
                'name'  => $item['name'],
                'price' => $toDecimal($item['price']),
                'qty'   => $item['qty'],
                'image' => $item['image'],
            ]);
        }

        if ($totals['coupon_code']) {
            Coupon::where('code', $totals['coupon_code'])->increment('used_count');
        }

        session(['last_order' => [
            'order_number' => $orderNumber,
            'message'      => 'A confirmation has been sent to ' . $request->input('email') . '. Your heirloom pieces are being prepared with precision in our workshop.',
            'items'        => $items,
            'shipping'     => [
                'name'    => $request->input('full_name'),
                'line1'   => $request->input('address'),
                'line2'   => null,
                'city'    => $request->input('city') . ', ' . $request->input('state') . ' ' . $request->input('zip'),
                'country' => 'United States',
            ],
            'totals'       => [
                'subtotal'       => $totals['subtotal'],
                'discount'       => $totals['discount'],
                'coupon_code'    => $totals['coupon_code'],
                'shipping'       => $totals['shipping'],
                'shipping_label' => $totals['shipping_label'],
                'tax'            => $totals['tax'],
                'total'          => $totals['total'],
            ],
            'payment'      => $payMethod,
        ]]);

        session()->forget(['cart', 'coupon']);

        return redirect()->route('confirmation');
    }
}
