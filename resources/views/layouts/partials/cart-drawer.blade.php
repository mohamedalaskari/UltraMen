@php
    $sessionCart  = session('cart', []);
    $cartItems    = array_values($sessionCart);
    $cartCount    = array_sum(array_column($cartItems, 'qty'));
    $cartSubtotal = array_reduce($cartItems, function ($c, $item) {
        return $c + (float) str_replace(['$', ','], '', $item['price']) * $item['qty'];
    }, 0.0);
@endphp

<div class="fixed inset-0 z-[100] invisible" id="cartDrawer">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-500"
         id="cartOverlay"
         onclick="toggleCart()"></div>

    <div class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} top-0 h-full w-full max-w-md bg-surface-container-lowest {{ app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full' }} transition-transform duration-500 flex flex-col shadow-2xl"
         id="cartPanel">

        {{-- Header --}}
        <div class="p-8 border-b border-surface-container flex justify-between items-center flex-shrink-0">
            <h2 class="font-headline-lg text-2xl text-primary uppercase">
                {{ __('common.your_cart') }} <span id="cartCount">({{ $cartCount }})</span>
            </h2>
            <button class="text-primary hover:rotate-90 transition-transform duration-300" onclick="toggleCart()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Items --}}
        <div class="flex-grow overflow-y-auto p-8 space-y-8" id="cartItems">
            @if(count($cartItems) === 0)
                <div class="flex flex-col items-center justify-center h-40 text-center">
                    <span class="material-symbols-outlined text-4xl text-outline mb-4">shopping_bag</span>
                    <p class="font-label-sm text-[11px] text-outline uppercase tracking-widest">{{ __('common.empty_cart') }}</p>
                </div>
            @else
                @foreach($cartItems as $item)
                <div class="flex gap-6">
                    <div class="w-24 h-32 bg-surface-container flex-shrink-0">
                        <img alt="{{ $item['name'] }}"
                             class="w-full h-full object-cover"
                             src="{{ asset('storage/' . $item['image']) }}"/>
                    </div>
                    <div class="flex flex-col justify-between py-1 flex-grow min-w-0">
                        <div>
                            <h4 class="font-label-sm text-sm text-primary mb-1 uppercase leading-tight">{{ $item['name'] }}</h4>
                            <p class="font-label-sm text-[10px] text-secondary flex items-center gap-2">
                                @if(!empty($item['original_price']))
                                    <s class="text-outline opacity-60">{{ $item['original_price'] }}</s>
                                @endif
                                {{ $item['price'] }}
                            </p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button onclick="updateCartQty('{{ $item['slug'] }}', {{ $item['qty'] - 1 }})"
                                        class="w-6 h-6 border border-outline-variant flex items-center justify-center hover:border-primary transition-colors text-sm leading-none">−</button>
                                <span class="font-label-sm text-sm w-4 text-center">{{ $item['qty'] }}</span>
                                <button onclick="updateCartQty('{{ $item['slug'] }}', {{ $item['qty'] + 1 }})"
                                        class="w-6 h-6 border border-outline-variant flex items-center justify-center hover:border-primary transition-colors text-sm leading-none">+</button>
                            </div>
                            <button onclick="removeFromCart('{{ $item['slug'] }}')"
                                    class="text-[10px] font-label-sm text-outline hover:text-error transition-colors uppercase tracking-wider">
                                {{ __('common.remove') }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Footer --}}
        <div class="p-8 border-t border-surface-container bg-surface-container-low flex-shrink-0">
            <div class="flex justify-between mb-8">
                <span class="font-label-sm text-on-surface-variant uppercase tracking-widest">{{ __('common.subtotal') }}</span>
                <span class="font-headline-lg text-2xl text-primary" id="cartSubtotal">
                    ${{ number_format($cartSubtotal, 2) }}
                </span>
            </div>
            <a href="{{ route('checkout') }}"
               id="cartCheckout"
               class="block w-full bg-primary text-on-primary font-label-sm text-label-sm py-6 uppercase tracking-widest hover:bg-secondary transition-colors text-center {{ $cartCount === 0 ? 'hidden' : '' }}">
                {{ __('common.proceed_to_checkout') }}
            </a>
            <a href="{{ route('cart') }}"
               class="block w-full text-center mt-4 py-4 border border-secondary text-secondary
                      font-label-sm text-label-sm uppercase tracking-widest
                      hover:bg-secondary hover:text-on-secondary transition-colors">
                {{ __('common.your_cart') }}
            </a>
            <button class="w-full text-center mt-4 font-label-sm text-[10px] text-outline hover:text-primary transition-colors"
                    onclick="toggleCart()">
                {{ __('common.continue_shopping') }}
            </button>
        </div>
    </div>
</div>
