<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CartServiceInterface;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly CartServiceInterface $cartService
    ) {}

    public function index()
    {
        return view('pages.cart', [
            'cartItems'    => $this->cartService->getCartItems(),
            'related'      => $this->cartService->getRelatedProducts(),
            'orderSummary' => $this->cartService->getOrderSummary(),
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $slug  = $request->input('slug');
        $cart  = session('cart', []);

        if (isset($cart[$slug])) {
            $cart[$slug]['qty']++;
        } else {
            $cart[$slug] = [
                'slug'           => $slug,
                'name'           => $request->input('name'),
                'price'          => $request->input('price'),
                'original_price' => $request->input('original_price') ?: null,
                'image'          => $request->input('image'),
                'qty'            => 1,
            ];
        }

        session(['cart' => $cart]);

        return response()->json($this->cartService->cartSummary($cart));
    }

    public function remove(Request $request): JsonResponse
    {
        $cart = session('cart', []);
        unset($cart[$request->input('slug')]);
        session(['cart' => $cart]);

        return response()->json($this->cartService->cartSummary($cart));
    }

    public function update(Request $request): JsonResponse
    {
        $slug = $request->input('slug');
        $qty  = (int) $request->input('qty');
        $cart = session('cart', []);

        if ($qty <= 0) {
            unset($cart[$slug]);
        } elseif (isset($cart[$slug])) {
            $cart[$slug]['qty'] = $qty;
        }

        session(['cart' => $cart]);

        return response()->json($this->cartService->cartSummary($cart));
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $code = strtoupper(trim((string) $request->input('code')));
        $cart = session('cart', []);

        $subtotal = array_reduce(array_values($cart), function ($carry, $item) {
            return $carry + (float) str_replace(['$', ','], '', $item['price']) * $item['qty'];
        }, 0.0);

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.'], 422);
        }

        if (!$coupon->isValidFor($subtotal)) {
            $message = match (true) {
                !$coupon->is_active => 'This coupon is no longer active.',
                $coupon->isExpired() => 'This coupon has expired.',
                $coupon->isUsageLimitReached() => 'This coupon has reached its usage limit.',
                $coupon->min_order_amount !== null => 'This coupon requires a minimum order of $' . number_format((float) $coupon->min_order_amount, 2) . '.',
                default => 'This coupon cannot be applied to your order.',
            };

            return response()->json(['error' => $message], 422);
        }

        session(['coupon' => ['id' => $coupon->id, 'code' => $coupon->code]]);

        return response()->json($this->cartService->cartSummary($cart));
    }

    public function removeCoupon(): JsonResponse
    {
        session()->forget('coupon');

        return response()->json($this->cartService->cartSummary(session('cart', [])));
    }
}
