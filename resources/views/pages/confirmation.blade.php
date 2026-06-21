@extends('layouts.app')

@section('title', 'ULTRA | ' . __('confirmation.thank_you'))

@section('content')

{{-- ── Progress Stepper (all completed + step 3 active) ────────────────────── --}}
<div class="bg-surface-container-low border-b border-outline-variant pt-28 pb-8">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="flex items-center justify-center gap-4 md:gap-12">

            {{-- Step 1: Completed --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">check</span>
                </div>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary hidden sm:inline">{{ __('checkout.shopping_bag') }}</span>
            </div>

            <div class="h-px w-12 md:w-24 bg-primary"></div>

            {{-- Step 2: Completed --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">check</span>
                </div>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary hidden sm:inline">{{ __('checkout.checkout') }}</span>
            </div>

            <div class="h-px w-12 md:w-24 bg-primary"></div>

            {{-- Step 3: Active --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full border-2 border-secondary flex items-center justify-center text-secondary font-bold">
                    3
                </div>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold hidden sm:inline">{{ __('checkout.confirmation') }}</span>
            </div>
        </div>
    </div>
</div>

<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">

    {{-- ── Confirmation Hero ────────────────────────────────────────────────────── --}}
    <div class="flex flex-col items-center text-center mb-16 reveal-animation">

        {{-- Check icon --}}
        <div class="mb-6">
            <div class="w-16 h-16 rounded-full border border-secondary flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-4xl">check</span>
            </div>
        </div>

        <h1 class="font-display text-headline-lg md:text-display uppercase tracking-tight mb-4">
            {{ __('confirmation.thank_you') }}
        </h1>

        <p class="font-label-sm text-label-sm text-secondary tracking-widest uppercase mb-6">
            {{ __('confirmation.order_number', ['number' => $order['order_number']]) }}
        </p>

        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
            {{ $order['message'] }}
        </p>
    </div>

    {{-- ── Bento Grid ───────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter reveal-animation" style="animation-delay: 0.2s;">

        {{-- ── Left: Items + Actions (col-span-8) ─────────────────────────────── --}}
        <div class="lg:col-span-8 flex flex-col gap-gutter">

            {{-- Items Purchased --}}
            <div class="confirmation-card p-8 bg-surface-container-lowest">
                <h3 class="font-label-sm text-label-sm uppercase tracking-widest mb-8 border-b border-outline-variant pb-4">
                    {{ __('confirmation.items_purchased') }}
                </h3>

                <div class="space-y-8">
                    @foreach($order['items'] as $item)
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-full sm:w-32 aspect-square bg-surface-container overflow-hidden shrink-0">
                            <img class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
                                 alt="{{ $item['name'] }}"
                                 src="{{ asset('storage/' . $item['image']) }}"/>
                        </div>
                        <div class="flex-grow flex flex-col justify-between py-1">
                            <div>
                                <h4 class="font-body-md text-body-md uppercase font-bold tracking-tight text-primary">
                                    {{ $item['name'] }}
                                </h4>
                                @if(!empty($item['variant']))
                                <p class="font-label-sm text-label-sm text-on-surface-variant mt-1">
                                    {{ $item['variant'] }}
                                </p>
                                @endif
                            </div>
                            <div class="flex justify-between items-end">
                                <p class="font-body-md text-body-md text-on-surface-variant">{{ __('confirmation.qty') }}: {{ $item['qty'] }}</p>
                                <p class="font-label-sm text-label-sm font-bold text-primary">{{ $item['price'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-gutter">
                <a href="{{ route('collections') }}"
                   class="flex-1 border border-primary text-primary py-6 px-8 font-label-sm text-label-sm uppercase tracking-widest
                          text-center hover:bg-primary hover:text-on-primary transition-all duration-300">
                    {{ __('confirmation.continue_shopping') }}
                </a>
            </div>
        </div>

        {{-- ── Right: Shipping + Financial (col-span-4) ───────────────────────── --}}
        <div class="lg:col-span-4 space-y-gutter">

            {{-- Shipping Address --}}
            <div class="confirmation-card p-8 bg-surface-container-lowest">
                <h3 class="font-label-sm text-label-sm uppercase tracking-widest mb-6 border-b border-outline-variant pb-4">
                    {{ __('confirmation.shipping_to') }}
                </h3>
                <div class="font-body-md text-body-md text-on-surface-variant leading-relaxed space-y-1">
                    <p class="font-bold text-primary">{{ $order['shipping']['name'] }}</p>
                    <p>{{ $order['shipping']['line1'] }}</p>
                    @if($order['shipping']['line2'])
                    <p>{{ $order['shipping']['line2'] }}</p>
                    @endif
                    <p>{{ $order['shipping']['city'] }}</p>
                    <p>{{ $order['shipping']['country'] }}</p>
                </div>
            </div>

            {{-- Financial Summary --}}
            <div class="confirmation-card p-8 bg-surface-container-lowest">
                <h3 class="font-label-sm text-label-sm uppercase tracking-widest mb-6 border-b border-outline-variant pb-4">
                    {{ __('confirmation.financial_summary') }}
                </h3>
                <div class="space-y-4 font-body-md text-body-md">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">{{ __('common.subtotal') }}</span>
                        <span>{{ $order['totals']['subtotal'] }}</span>
                    </div>
                    @if(!empty($order['totals']['coupon_code']))
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">{{ __('common.discount') }} <span class="text-secondary">({{ $order['totals']['coupon_code'] }})</span></span>
                        <span class="text-error">-{{ $order['totals']['discount'] }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">{{ $order['totals']['shipping_label'] }}</span>
                        <span class="text-secondary">{{ $order['totals']['shipping'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">{{ __('common.tax') }}</span>
                        <span>{{ $order['totals']['tax'] }}</span>
                    </div>
                    <div class="pt-4 border-t border-outline-variant flex justify-between font-bold text-headline-lg-mobile">
                        <span class="uppercase tracking-tight">{{ __('confirmation.total_paid') }}</span>
                        <span>{{ $order['totals']['total'] }}</span>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="mt-8 pt-8 border-t border-outline-variant">
                    <p class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-widest mb-2">
                        {{ __('confirmation.payment_method') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary">{{ $order['payment']['icon'] }}</span>
                        <span class="font-body-md text-body-md">{{ $order['payment']['method'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Assistance Links ─────────────────────────────────────────────────────── --}}
    <div class="mt-20 py-12 border-t border-outline-variant text-center reveal-animation" style="animation-delay: 0.4s;">
        <p class="font-body-md text-body-md text-on-surface-variant mb-6">{{ __('confirmation.need_assistance') }}</p>
        <div class="flex flex-wrap justify-center gap-12 font-label-sm text-label-sm uppercase tracking-widest">
            <a class="hover:text-secondary transition-colors underline underline-offset-8" href="#">{{ __('confirmation.concierge_services') }}</a>
            <a class="hover:text-secondary transition-colors underline underline-offset-8" href="#">{{ __('confirmation.shipping_faq') }}</a>
            <a class="hover:text-secondary transition-colors underline underline-offset-8" href="{{ route('contact') }}">{{ __('confirmation.return_policy') }}</a>
        </div>
    </div>

</main>

@endsection
