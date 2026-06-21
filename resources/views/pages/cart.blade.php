@extends('layouts.app')

@section('title', 'ULTRA | ' . __('cart.step_bag'))

@section('content')

<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop pt-32 pb-24">

    {{-- ── Progress Indicator ───────────────────────────────────────────────────── --}}
    <div class="relative flex justify-between items-center mb-16 max-w-2xl mx-auto">
        <div class="progress-line"></div>

        <div class="flex flex-col items-center gap-2 bg-surface px-4">
            <div class="w-8 h-8 rounded-full bg-primary text-on-primary text-xs font-bold flex items-center justify-center">1</div>
            <span class="font-label-sm text-label-sm text-primary">{{ __('cart.step_bag') }}</span>
        </div>

        <div class="flex flex-col items-center gap-2 bg-surface px-4">
            <div class="w-8 h-8 rounded-full border border-outline text-outline text-xs flex items-center justify-center">2</div>
            <span class="font-label-sm text-label-sm text-outline">{{ __('cart.step_checkout') }}</span>
        </div>

        <div class="flex flex-col items-center gap-2 bg-surface px-4">
            <div class="w-8 h-8 rounded-full border border-outline text-outline text-xs flex items-center justify-center">3</div>
            <span class="font-label-sm text-label-sm text-outline">{{ __('cart.step_confirmation') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        {{-- ── Items Section ────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-8">

            <h1 class="font-headline-lg text-headline-lg mb-8 tracking-tighter">
                {{ __('cart.your_bag') }}
                <span class="text-outline text-body-lg font-normal ms-2">
                    ({{ count($cartItems) }} {{ count($cartItems) === 1 ? __('cart.item') : __('cart.items') }})
                </span>
            </h1>

            @if(count($cartItems) === 0)
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-24 text-center border border-outline-variant">
                    <span class="material-symbols-outlined text-6xl text-outline mb-6">shopping_bag</span>
                    <h3 class="font-headline-lg text-xl text-primary mb-3 uppercase tracking-wider">{{ __('cart.bag_empty') }}</h3>
                    <p class="font-body-md text-on-surface-variant mb-8">{{ __('cart.discover_collections') }}</p>
                    <a href="{{ route('collections') }}"
                       class="bg-primary text-on-primary px-10 py-4 font-label-sm text-label-sm uppercase tracking-widest hover:bg-secondary transition-colors">
                        {{ __('cart.explore_collection') }}
                    </a>
                </div>
            @else
                <div class="space-y-gutter" id="cartPageItems">
                    @foreach($cartItems as $item)
                        <div class="flex flex-col sm:flex-row gap-gutter border-b border-outline-variant pb-8 group">

                            {{-- Image --}}
                            <a href="{{ route('product.show', $item['slug']) }}"
                               class="w-full sm:w-40 aspect-[3/4] bg-surface-container overflow-hidden flex-shrink-0 block">
                                <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700"
                                     alt="{{ $item['name'] }}"
                                     src="{{ asset('storage/' . $item['image']) }}"/>
                            </a>

                            {{-- Info --}}
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <a href="{{ route('product.show', $item['slug']) }}"
                                           class="font-body-lg text-body-lg font-semibold text-primary hover:text-secondary transition-colors">
                                            {{ $item['name'] }}
                                        </a>
                                        <p class="font-label-sm text-label-sm text-outline mt-2 uppercase tracking-wider flex items-center gap-2">
                                            @if(!empty($item['original_price']))
                                                <s class="opacity-60">{{ $item['original_price'] }}</s>
                                            @endif
                                            {{ $item['price'] }}
                                        </p>
                                    </div>
                                    <span class="font-body-lg font-bold text-primary whitespace-nowrap">
                                        ${{ number_format((float) str_replace(['$', ','], '', $item['price']) * $item['qty'], 2) }}
                                    </span>
                                </div>

                                {{-- Qty + Remove --}}
                                <div class="flex justify-between items-center mt-6">
                                    <div class="flex items-center border border-outline-variant">
                                        <button onclick="cartPageUpdate('{{ $item['slug'] }}', {{ $item['qty'] - 1 }})"
                                                class="p-3 hover:text-secondary hover:bg-surface-container transition-colors">
                                            <span class="material-symbols-outlined text-sm">remove</span>
                                        </button>
                                        <span class="px-5 font-label-sm text-label-sm min-w-[3rem] text-center">
                                            {{ str_pad($item['qty'], 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <button onclick="cartPageUpdate('{{ $item['slug'] }}', {{ $item['qty'] + 1 }})"
                                                class="p-3 hover:text-secondary hover:bg-surface-container transition-colors">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                        </button>
                                    </div>
                                    <button onclick="cartPageRemove('{{ $item['slug'] }}')"
                                            class="text-outline hover:text-error transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                        <span class="font-label-sm text-label-sm">{{ __('common.remove') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ── You May Also Like ───────────────────────────────────────────── --}}
            @if(count($related) > 0)
            <div class="mt-16 flex flex-col gap-6">
                <h4 class="font-label-sm text-label-sm text-primary tracking-widest">{{ __('cart.you_may_also_like') }}</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
                    @foreach($related as $relItem)
                        <x-product-card :product="$relItem" variant="compact"/>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ── Order Summary Sidebar ────────────────────────────────────────────── --}}
        <div class="lg:col-span-4">
            <div class="bg-surface-container-low border border-outline-variant p-gutter sticky top-32">

                <h2 class="font-label-sm text-label-sm text-primary mb-8 tracking-widest border-b border-outline-variant pb-4">
                    {{ __('cart.order_summary') }}
                </h2>

                <div class="space-y-4">
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">{{ __('common.subtotal') }}</span>
                        <span class="text-primary" id="summarySubtotal">{{ $orderSummary['subtotal'] }}</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md" id="summaryDiscountRow"
                         style="{{ $orderSummary['coupon_code'] ? '' : 'display:none' }}">
                        <span class="text-on-surface-variant">{{ __('common.discount') }} <span class="text-secondary" id="summaryCouponCode">{{ $orderSummary['coupon_code'] ? '(' . $orderSummary['coupon_code'] . ')' : '' }}</span></span>
                        <span class="text-error" id="summaryDiscount">-{{ $orderSummary['discount'] }}</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">{{ __('common.shipping') }}</span>
                        <span class="text-secondary font-semibold">{{ $orderSummary['shipping'] }}</span>
                    </div>
                    <div class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">{{ __('common.estimated_tax') }}</span>
                        <span class="text-primary" id="summaryTax">{{ $orderSummary['tax'] }}</span>
                    </div>
                    <div class="pt-6 mt-6 border-t border-outline-variant flex justify-between items-baseline">
                        <span class="font-label-sm text-label-sm text-primary uppercase">{{ __('common.total') }}</span>
                        <span class="font-headline-lg text-2xl text-primary tracking-tighter leading-none" id="summaryTotal">
                            {{ $orderSummary['total'] }}
                        </span>
                    </div>
                </div>

                @if(count($cartItems) > 0)
                <div class="mt-8 space-y-4">
                    <a href="{{ route('checkout') }}"
                       class="block w-full py-4 bg-primary text-on-primary font-label-sm text-label-sm tracking-widest transition-all duration-300 text-center hover:bg-secondary">
                        {{ __('common.proceed_to_checkout') }}
                    </a>
                </div>
                @endif

                <div class="mt-8 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary">verified_user</span>
                        <span class="font-label-sm text-[10px] text-outline uppercase tracking-wider">{{ __('cart.secure_payment') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary">local_shipping</span>
                        <span class="font-label-sm text-[10px] text-outline uppercase tracking-wider">{{ __('cart.insured_delivery') }}</span>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-outline-variant">
                    <label class="font-label-sm text-[10px] text-primary block mb-3 uppercase tracking-widest">
                        {{ __('cart.promo_code') }}
                    </label>

                    <div id="couponInputState" style="{{ $orderSummary['coupon_code'] ? 'display:none' : '' }}">
                        <div class="flex border-b border-primary">
                            <input type="text" id="couponCodeInput" placeholder="{{ __('cart.enter_code') }}"
                                   onkeydown="if(event.key==='Enter'){event.preventDefault();applyCoupon();}"
                                   class="bg-transparent border-none focus:ring-0 w-full font-label-sm text-label-sm placeholder:text-outline/50 px-0 uppercase"/>
                            <button type="button" onclick="applyCoupon()"
                                    class="font-label-sm text-label-sm text-primary px-2 hover:text-secondary transition-colors">{{ __('cart.apply') }}</button>
                        </div>
                        <p id="couponError" class="hidden text-error text-[11px] mt-2"></p>
                    </div>

                    <div id="couponAppliedState" class="flex items-center justify-between {{ $orderSummary['coupon_code'] ? '' : 'hidden' }}">
                        <span class="font-label-sm text-label-sm text-secondary flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">local_offer</span>
                            <span id="couponAppliedCode">{{ $orderSummary['coupon_code'] }}</span> {{ __('cart.applied') }}
                        </span>
                        <button type="button" onclick="removeCoupon()"
                                class="text-[10px] text-outline hover:text-error transition-colors uppercase tracking-wider">
                            {{ __('common.remove') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@endsection

@push('styles')
<style>
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endpush

@push('scripts')
<script>
function cartPageUpdate(slug, qty) {
    _cartPost('/cart/update', { slug, qty }).then(() => window.location.reload());
}
function cartPageRemove(slug) {
    _cartPost('/cart/remove', { slug }).then(() => window.location.reload());
}

function _updateCartSummary(data) {
    document.getElementById('summarySubtotal').textContent = data.subtotal;
    document.getElementById('summaryTax').textContent      = data.tax;
    document.getElementById('summaryTotal').textContent    = data.total;

    const discountRow = document.getElementById('summaryDiscountRow');
    if (data.coupon_code) {
        discountRow.style.display = '';
        document.getElementById('summaryDiscount').textContent   = '-' + data.discount;
        document.getElementById('summaryCouponCode').textContent = '(' + data.coupon_code + ')';
    } else {
        discountRow.style.display = 'none';
    }
}

function applyCoupon() {
    const input = document.getElementById('couponCodeInput');
    const errorEl = document.getElementById('couponError');
    const code = input.value.trim();

    if (!code) {
        errorEl.textContent = @json(__('cart.enter_coupon_error'));
        errorEl.classList.remove('hidden');
        return;
    }

    _cartPost('/cart/coupon/apply', { code }).then(data => {
        if (data.error) {
            errorEl.textContent = data.error;
            errorEl.classList.remove('hidden');
            return;
        }

        errorEl.classList.add('hidden');
        _updateCartSummary(data);
        document.getElementById('couponAppliedCode').textContent = data.coupon_code;
        document.getElementById('couponInputState').style.display = 'none';
        document.getElementById('couponAppliedState').classList.remove('hidden');
    });
}

function removeCoupon() {
    _cartPost('/cart/coupon/remove', {}).then(data => {
        _updateCartSummary(data);
        document.getElementById('couponCodeInput').value = '';
        document.getElementById('couponInputState').style.display = '';
        document.getElementById('couponAppliedState').classList.add('hidden');
    });
}
</script>
@endpush
