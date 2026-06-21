@extends('layouts.app')

@section('title', 'ULTRA | ' . __('checkout.checkout'))

@section('content')

{{-- ── Progress Stepper ────────────────────────────────────────────────────── --}}
<nav class="bg-surface-container-low border-b border-outline-variant pt-28 pb-8">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="flex items-center justify-center gap-4 md:gap-12">

            <a href="{{ route('cart') }}" class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary">check_circle</span>
                <span class="font-label-sm text-secondary uppercase tracking-widest hidden sm:inline">{{ __('checkout.shopping_bag') }}</span>
            </a>

            <div class="h-px w-8 md:w-16 bg-outline-variant"></div>

            <div class="flex items-center gap-3">
                <span class="font-label-sm text-on-primary bg-primary w-6 h-6 flex items-center justify-center rounded-full text-[10px]">02</span>
                <span class="font-label-sm text-primary uppercase tracking-widest font-bold hidden sm:inline">{{ __('checkout.checkout') }}</span>
            </div>

            <div class="h-px w-8 md:w-16 bg-outline-variant"></div>

            <div class="flex items-center gap-3 opacity-30">
                <span class="font-label-sm text-primary border border-primary w-6 h-6 flex items-center justify-center rounded-full text-[10px]">03</span>
                <span class="font-label-sm text-primary uppercase tracking-widest hidden sm:inline">{{ __('checkout.confirmation') }}</span>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-20">

    <div class="mb-12">
        <h1 class="font-display text-headline-lg md:text-display tracking-tight text-primary mb-2">{{ __('checkout.checkout') }}</h1>
        <p class="font-label-sm text-secondary uppercase tracking-widest">{{ __('checkout.guest_entry') }}</p>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}" id="checkoutForm">
    @csrf
    <input type="hidden" name="payment_method" value="cod"/>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter lg:gap-16 items-start">

        {{-- ── Left: Forms ────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-7 space-y-16">

            {{-- 01 Shipping Information --}}
            <section>
                <div class="flex items-center gap-4 mb-8">
                    <span class="font-label-sm text-on-primary bg-primary w-8 h-8 flex items-center justify-center rounded-full">01</span>
                    <h2 class="font-headline-lg text-primary uppercase tracking-wider text-xl">{{ __('checkout.shipping_information') }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    <div class="flex flex-col">
                        <label class="checkout-label" for="full_name">{{ __('checkout.full_name') }}</label>
                        <input id="full_name" name="full_name" type="text"
                               value="{{ old('full_name') }}"
                               class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('full_name') border-error @enderror"
                               placeholder="Johnathan Doe"/>
                        @error('full_name')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="checkout-label" for="phone">{{ __('checkout.phone_number') }}</label>
                        <input id="phone" name="phone" type="tel"
                               value="{{ old('phone') }}"
                               class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('phone') border-error @enderror"
                               placeholder="+1 (555) 000-0000"/>
                        @error('phone')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col md:col-span-2">
                        <label class="checkout-label" for="email">{{ __('checkout.email_address') }}</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}"
                               class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('email') border-error @enderror"
                               placeholder="email@example.com"/>
                        @error('email')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col md:col-span-2">
                        <label class="checkout-label" for="address">{{ __('checkout.shipping_address') }}</label>
                        <input id="address" name="address" type="text"
                               value="{{ old('address') }}"
                               class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('address') border-error @enderror"
                               placeholder="Street Address, Apartment, Suite"/>
                        @error('address')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="checkout-label" for="city">{{ __('checkout.city') }}</label>
                        <input id="city" name="city" type="text"
                               value="{{ old('city') }}"
                               class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('city') border-error @enderror"
                               placeholder="New York"/>
                        @error('city')
                            <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label class="checkout-label" for="state">{{ __('checkout.state') }}</label>
                            <input id="state" name="state" type="text"
                                   value="{{ old('state') }}"
                                   class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('state') border-error @enderror"
                                   placeholder="NY"/>
                            @error('state')
                                <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label class="checkout-label" for="zip">{{ __('checkout.zip') }}</label>
                            <input id="zip" name="zip" type="text"
                                   value="{{ old('zip') }}"
                                   class="input-underline py-3 font-body-md placeholder:text-outline/50 @error('zip') border-error @enderror"
                                   placeholder="10001"/>
                            @error('zip')
                                <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            {{-- 02 Delivery --}}
            <section>
                <div class="flex items-center gap-4 mb-8">
                    <span class="font-label-sm text-on-primary bg-primary w-8 h-8 flex items-center justify-center rounded-full">02</span>
                    <h2 class="font-headline-lg text-primary uppercase tracking-wider text-xl">{{ __('checkout.delivery') }}</h2>
                </div>

                <div class="flex flex-col mb-8">
                    <label class="checkout-label" for="shipping_zone_id">{{ __('checkout.shipping_zone') }}</label>
                    <select id="shipping_zone_id" name="shipping_zone_id" required
                            class="input-underline py-3 font-body-md bg-transparent @error('shipping_zone_id') border-error @enderror">
                        <option value="" disabled {{ old('shipping_zone_id') ? '' : 'selected' }}>{{ __('checkout.select_zone') }}</option>
                        @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ old('shipping_zone_id') == $zone->id ? 'selected' : '' }}>
                            {{ $zone->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('shipping_zone_id')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                    @if($zones->isEmpty())
                        <span class="text-error text-[11px] mt-1">{{ __('checkout.no_zones_configured') }}</span>
                    @endif
                </div>

                <div class="flex flex-col">
                    <label class="checkout-label mb-3">{{ __('checkout.shipping_method') }}</label>
                    <div id="shippingMethodOptions" class="grid grid-cols-1 sm:grid-cols-2 gap-4 opacity-40 pointer-events-none transition-opacity">
                        <label class="shipping-method-card border border-outline-variant p-5 flex items-start gap-3 cursor-pointer">
                            <input type="radio" name="shipping_method" value="standard" class="mt-1 accent-secondary" required
                                   {{ old('shipping_method') === 'standard' ? 'checked' : '' }}/>
                            <span>
                                <span class="block font-label-sm text-primary uppercase tracking-widest mb-1">{{ __('checkout.standard') }}</span>
                                <span class="block text-on-surface-variant text-sm" data-method-price="standard">{{ __('checkout.select_zone_first') }}</span>
                            </span>
                        </label>
                        <label class="shipping-method-card border border-outline-variant p-5 flex items-start gap-3 cursor-pointer">
                            <input type="radio" name="shipping_method" value="express" class="mt-1 accent-secondary" required
                                   {{ old('shipping_method') === 'express' ? 'checked' : '' }}/>
                            <span>
                                <span class="block font-label-sm text-primary uppercase tracking-widest mb-1">{{ __('checkout.express') }}</span>
                                <span class="block text-on-surface-variant text-sm" data-method-price="express">{{ __('checkout.select_zone_first') }}</span>
                            </span>
                        </label>
                    </div>
                    @error('shipping_method')
                        <span class="text-error text-[11px] mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </section>

            {{-- 03 Payment Method --}}
            <section>
                <div class="flex items-center gap-4 mb-8">
                    <span class="font-label-sm text-on-primary bg-primary w-8 h-8 flex items-center justify-center rounded-full">03</span>
                    <h2 class="font-headline-lg text-primary uppercase tracking-wider text-xl">{{ __('checkout.payment_method') }}</h2>
                </div>

                <div class="border border-primary p-8 flex items-center gap-6">
                    <div class="w-14 h-14 bg-primary text-on-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-3xl">payments</span>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-1">
                            {{ __('checkout.cash_on_delivery') }}
                        </p>
                        <p class="font-body-md text-on-surface-variant text-sm">
                            {{ __('checkout.cod_description') }}
                        </p>
                    </div>
                    <span class="material-symbols-outlined text-secondary ms-auto shrink-0">check_circle</span>
                </div>
            </section>
        </div>

        {{-- ── Right: Order Summary ─────────────────────────────────────────────── --}}
        <aside class="lg:col-span-5 bg-surface-container-low p-8 md:p-12 border border-outline-variant sticky top-24">

            <h3 class="font-label-sm text-primary uppercase tracking-widest text-base mb-10 pb-4 border-b border-outline-variant">
                {{ __('checkout.order_summary') }}
            </h3>

            <div class="space-y-8 mb-12">
                @foreach($items as $item)
                <div class="flex gap-6">
                    <div class="w-24 h-32 bg-surface-variant overflow-hidden shrink-0">
                        <img class="w-full h-full object-cover"
                             alt="{{ $item['name'] }}"
                             src="{{ asset('storage/' . $item['image']) }}"/>
                    </div>
                    <div class="flex flex-col justify-between py-1">
                        <h4 class="font-body-md font-bold text-primary uppercase text-sm tracking-tight">
                            {{ $item['name'] }}
                        </h4>
                        <div class="flex justify-between items-end w-full gap-4">
                            <span class="font-label-sm text-on-surface-variant">{{ __('checkout.qty') }}: {{ $item['qty'] }}</span>
                            <span class="font-body-md font-bold text-primary">{{ $item['price'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="border-t border-outline-variant pt-8 space-y-4">
                <div class="flex justify-between text-on-surface-variant">
                    <span class="font-label-sm uppercase tracking-widest">{{ __('common.subtotal') }}</span>
                    <span class="font-body-md" id="summarySubtotal">{{ $totals['subtotal'] }}</span>
                </div>
                <div class="flex justify-between text-on-surface-variant" id="summaryDiscountRow"
                     style="{{ $totals['coupon_code'] ? '' : 'display:none' }}">
                    <span class="font-label-sm uppercase tracking-widest">{{ __('common.discount') }} <span class="text-secondary" id="summaryCouponCode">{{ $totals['coupon_code'] ? '(' . $totals['coupon_code'] . ')' : '' }}</span></span>
                    <span class="font-body-md text-error" id="summaryDiscount">-{{ $totals['discount'] }}</span>
                </div>
                <div>
                    <div class="flex justify-between text-on-surface-variant">
                        <span class="font-label-sm uppercase tracking-widest">{{ __('common.shipping') }}</span>
                        <span class="font-body-md font-bold text-primary" id="summaryShipping">{{ $totals['shipping'] }}</span>
                    </div>
                    <p class="text-end text-[10px] text-on-surface-variant/70 mt-1" id="summaryShippingLabel">
                        {{ $totals['shipping_label'] }}
                    </p>
                </div>
                <div class="flex justify-between text-on-surface-variant pb-6 border-b border-outline-variant">
                    <span class="font-label-sm uppercase tracking-widest">{{ __('common.estimated_tax') }}</span>
                    <span class="font-body-md" id="summaryTax">{{ $totals['tax'] }}</span>
                </div>
                <div class="flex justify-between pt-2">
                    <span class="font-label-sm text-primary uppercase tracking-widest text-base font-bold">{{ __('common.total') }}</span>
                    <span class="font-headline-lg text-primary text-xl" id="summaryTotal">{{ $totals['total'] }}</span>
                </div>
            </div>

            <button type="submit" id="completePurchaseBtn" disabled
                    class="w-full mt-12 bg-primary text-on-primary py-6 font-label-sm uppercase tracking-[0.3em]
                           hover:bg-secondary transition-all duration-500
                           flex items-center justify-center gap-3 group
                           disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-primary">
                <span>{{ __('checkout.complete_purchase') }}</span>
                <span class="material-symbols-outlined transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1">arrow_forward</span>
            </button>

            <p class="text-center mt-6 font-label-sm text-on-surface-variant/60 text-[10px] leading-relaxed">
                {{ __('checkout.terms_notice') }}
            </p>
        </aside>

    </div>
    </form>

</main>

@endsection

@push('scripts')
<script>
const shippingZones = {{ \Illuminate\Support\Js::from($zones->map(fn($z) => [
    'id' => $z->id,
    'standard_price' => (float) $z->standard_price,
    'standard_days_label' => $z->standard_days_label,
    'express_price' => (float) $z->express_price,
    'express_days_label' => $z->express_days_label,
])->values()) }};

const zoneSelect      = document.getElementById('shipping_zone_id');
const methodOptions   = document.getElementById('shippingMethodOptions');
const methodRadios    = document.querySelectorAll('input[name="shipping_method"]');
const completeBtn     = document.getElementById('completePurchaseBtn');

function findZone(id) {
    return shippingZones.find(z => z.id === Number(id));
}

function updateMethodPrices() {
    const zone = findZone(zoneSelect.value);
    if (!zone) return;

    document.querySelector('[data-method-price="standard"]').textContent =
        '$' + zone.standard_price.toFixed(2) + ' · ' + zone.standard_days_label;
    document.querySelector('[data-method-price="express"]').textContent =
        '$' + zone.express_price.toFixed(2) + ' · ' + zone.express_days_label;
}

function checkFormReady() {
    const zoneChosen   = !!zoneSelect.value;
    const methodChosen = !!document.querySelector('input[name="shipping_method"]:checked');
    completeBtn.disabled = !(zoneChosen && methodChosen);
}

async function recalculateTotals() {
    const zoneId = zoneSelect.value;
    const method = document.querySelector('input[name="shipping_method"]:checked')?.value;
    if (!zoneId || !method) return;

    const res = await fetch('{{ route('checkout.calculate') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ shipping_zone_id: zoneId, shipping_method: method }),
    });
    if (!res.ok) return;

    const totals = await res.json();
    document.getElementById('summarySubtotal').textContent      = totals.subtotal;
    document.getElementById('summaryShipping').textContent      = totals.shipping;
    document.getElementById('summaryShippingLabel').textContent = totals.shipping_label;
    document.getElementById('summaryTax').textContent           = totals.tax;
    document.getElementById('summaryTotal').textContent         = totals.total;

    const discountRow = document.getElementById('summaryDiscountRow');
    if (totals.coupon_code) {
        discountRow.style.display = '';
        document.getElementById('summaryDiscount').textContent   = '-' + totals.discount;
        document.getElementById('summaryCouponCode').textContent = '(' + totals.coupon_code + ')';
    } else {
        discountRow.style.display = 'none';
    }
}

zoneSelect.addEventListener('change', () => {
    if (zoneSelect.value) {
        methodOptions.classList.remove('opacity-40', 'pointer-events-none');
        updateMethodPrices();
    } else {
        methodOptions.classList.add('opacity-40', 'pointer-events-none');
    }
    checkFormReady();
    recalculateTotals();
});

methodRadios.forEach(radio => {
    radio.addEventListener('change', () => {
        checkFormReady();
        recalculateTotals();
    });
});

// Re-hydrate state if the form was redisplayed after a validation error
if (zoneSelect.value) {
    methodOptions.classList.remove('opacity-40', 'pointer-events-none');
    updateMethodPrices();
}
checkFormReady();
if (zoneSelect.value && document.querySelector('input[name="shipping_method"]:checked')) {
    recalculateTotals();
}

function selectPaymentTab(tab) {
    ['card', 'pay', 'crypto', 'bank'].forEach(t => {
        const btn = document.getElementById('tab-' + t);
        const fields = document.getElementById('fields-' + t);
        const active = t === tab;

        btn.classList.toggle('border-primary',    active);
        btn.classList.toggle('bg-primary',        active);
        btn.classList.toggle('text-on-primary',   active);
        btn.classList.toggle('border-outline-variant', !active);

        if (fields) fields.classList.toggle('hidden', !active);
    });

    document.getElementById('paymentMethodInput').value = tab;
}

document.querySelectorAll('.input-underline').forEach(input => {
    const label = input.closest('.flex')?.querySelector('.checkout-label');
    if (!label) return;
    input.addEventListener('focus', () => {
        label.classList.add('text-secondary');
        label.classList.remove('text-on-surface-variant');
    });
    input.addEventListener('blur', () => {
        if (!input.value) {
            label.classList.remove('text-secondary');
            label.classList.add('text-on-surface-variant');
        }
    });
});
</script>
@endpush
