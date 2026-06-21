@props([
    'product',
    'variant' => 'compact',
    'delay'   => null,
])

@php
$delayStyle = $delay ? "transition-delay: {$delay}" : '';

$labelBadges = [
    'sale'            => ['text' => __('product.badge_sale'),    'bg' => 'bg-error',      'text_color' => 'text-white'],
    'limited_edition' => ['text' => __('product.badge_limited'), 'bg' => 'bg-secondary',  'text_color' => 'text-on-secondary'],
    'new_arrival'     => ['text' => __('product.badge_new'),     'bg' => 'bg-primary',    'text_color' => 'text-on-primary'],
    'best_seller'     => ['text' => __('product.badge_best'),    'bg' => 'bg-transparent border border-secondary', 'text_color' => 'text-secondary'],
];

$activeBadge = null;
if (!empty($product['discount_percent'])) {
    $activeBadge = ['text' => '-' . $product['discount_percent'] . '%', 'bg' => 'bg-error', 'text_color' => 'text-white'];
} else {
    foreach (['sale', 'limited_edition', 'new_arrival', 'best_seller'] as $key) {
        if (in_array($key, $product['labels'] ?? [])) {
            $activeBadge = $labelBadges[$key];
            break;
        }
    }
}
@endphp

{{-- ── Compact (Home Best Sellers) ─────────────────────────────────────────── --}}
@if($variant === 'compact')

<a href="{{ route('product.show', $product['slug']) }}"
   class="group product-hover reveal block"
   style="{{ $delayStyle }}">
    <div class="aspect-[3/4] overflow-hidden bg-surface mb-3 md:mb-4 relative border border-outline-variant">
        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 mix-blend-multiply transition-all duration-700"
             alt="{{ $product['name'] }}"
             src="{{ asset('storage/' . $product['image']) }}"/>

        @if($activeBadge)
            <div class="absolute top-3 start-3 {{ $activeBadge['bg'] }} {{ $activeBadge['text_color'] }}
                        px-2 py-0.5 font-label-sm text-[9px] tracking-widest z-10">
                {{ $activeBadge['text'] }}
            </div>
        @endif
    </div>
    <h4 class="text-[11px] md:text-[14px] font-bold uppercase text-primary leading-tight">{{ $product['name'] }}</h4>
    <p class="text-[13px] md:text-[16px] text-secondary mt-1 font-bold flex items-center gap-2">
        @if(!empty($product['original_price']))
            <s class="text-outline text-[11px] md:text-[13px] font-normal opacity-70">{{ $product['original_price'] }}</s>
        @endif
        {{ $product['price'] }}
    </p>
    <button data-slug="{{ $product['slug'] }}"
            data-name="{{ $product['name'] }}"
            data-price="{{ $product['price'] }}"
            data-original-price="{{ $product['original_price'] ?? '' }}"
            data-image="{{ $product['image'] }}"
            onclick="event.preventDefault(); cartAddFromBtn(this)"
            class="mt-3 w-full bg-primary text-on-primary py-2 md:py-2.5 flex items-center justify-center gap-2
                   font-label-sm text-[9px] md:text-[10px] tracking-widest uppercase hover:bg-secondary transition-colors">
        <span class="material-symbols-outlined text-sm md:text-base">add_shopping_cart</span>
        {{ __('common.add_to_cart') }}
    </button>
</a>

{{-- ── Gallery (Collections) ────────────────────────────────────────────────── --}}
@elseif($variant === 'gallery')

<a href="{{ route('product.show', $product['slug']) }}" class="product-card group cursor-pointer block">
    <div class="relative overflow-hidden aspect-[3/4] sm:aspect-[4/5] bg-surface-container-low mb-3 md:mb-6">
        <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
             alt="{{ $product['name'] }}"
             src="{{ asset('storage/' . $product['image']) }}"/>

        @if(!empty($product['secondary_image']))
            <div class="secondary-image absolute inset-0 opacity-0 transition-opacity duration-500 bg-surface-container-low">
                <img class="w-full h-full object-cover"
                     alt="{{ $product['name'] }} Detail"
                     src="{{ asset('storage/' . $product['secondary_image']) }}"/>
            </div>
        @endif

        @if($activeBadge)
            <div class="absolute top-2 start-2 md:top-4 md:start-4 z-10 {{ $activeBadge['bg'] }} {{ $activeBadge['text_color'] }}
                        px-2 py-0.5 md:px-3 md:py-1 font-label-sm text-[8px] md:text-[9px] tracking-widest">
                {{ $activeBadge['text'] }}
            </div>
        @endif

        {{-- View product overlay — desktop hover only --}}
        <div class="hidden md:flex absolute bottom-6 left-1/2 -translate-x-1/2 w-4/5 bg-primary text-on-primary
                    font-label-sm text-label-sm py-4 text-center tracking-widest items-center justify-center
                    opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0
                    transition-all duration-300 z-10">
            {{ __('product.view_product') }}
        </div>
    </div>

    <div class="text-start">
        @if(!empty($product['category']))
            <span class="font-label-sm text-[9px] md:text-[10px] text-secondary mb-1 md:mb-2 block tracking-widest uppercase">
                {{ $product['category'] }}
            </span>
        @endif
        <h3 class="font-headline-lg text-[12px] md:text-[18px] lg:text-[20px] text-primary mb-1 md:mb-2 leading-tight">{{ $product['name'] }}</h3>
        <p class="font-body-md text-on-surface-variant font-semibold text-[11px] md:text-base flex items-center gap-2">
            @if(!empty($product['original_price']))
                <s class="text-outline opacity-70 font-normal">{{ $product['original_price'] }}</s>
            @endif
            {{ $product['price'] }}
        </p>
        <button data-slug="{{ $product['slug'] }}"
                data-name="{{ $product['name'] }}"
                data-price="{{ $product['price'] }}"
                data-original-price="{{ $product['original_price'] ?? '' }}"
                data-image="{{ $product['image'] }}"
                onclick="event.preventDefault(); cartAddFromBtn(this)"
                class="mt-3 md:mt-4 w-full bg-primary text-on-primary py-2.5 md:py-3 flex items-center justify-center gap-2
                       font-label-sm text-[10px] md:text-[11px] tracking-widest uppercase hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined text-base md:text-lg">add_shopping_cart</span>
            {{ __('common.add_to_cart') }}
        </button>
    </div>
</a>

{{-- ── Archive (Best Sellers Grid) ─────────────────────────────────────────── --}}
@elseif($variant === 'archive')

<a href="{{ route('product.show', $product['slug']) }}" class="group block">
    <div class="product-image-container relative aspect-[4/5] overflow-hidden bg-surface-container border border-outline-variant">
        <img class="w-full h-full object-cover hover-zoom"
             alt="{{ $product['name'] }}"
             src="{{ asset('storage/' . $product['image']) }}"/>

        @if($activeBadge)
            <div class="absolute top-4 start-4 z-10 {{ $activeBadge['bg'] }} {{ $activeBadge['text_color'] }}
                        px-3 py-1 font-label-sm text-[9px] tracking-widest">
                {{ $activeBadge['text'] }}
            </div>
        @elseif(!empty($product['badge']))
            <div class="absolute top-4 start-4">
                <span class="bg-secondary text-on-secondary px-3 py-1 font-label-sm text-[10px] tracking-widest uppercase">
                    {{ $product['badge'] }}
                </span>
            </div>
        @endif
    </div>
    <div class="mt-6">
        <h3 class="font-label-sm text-label-sm uppercase tracking-widest text-primary">{{ $product['name'] }}</h3>
        <div class="flex justify-between items-center mt-2">
            <p class="font-body-md text-on-surface-variant">{{ $product['subtitle'] ?? '' }}</p>
            <span class="font-body-md text-primary flex items-center gap-2">
                @if(!empty($product['original_price']))
                    <s class="text-outline opacity-70 text-sm">{{ $product['original_price'] }}</s>
                @endif
                {{ $product['price'] }}
            </span>
        </div>
        <button data-slug="{{ $product['slug'] }}"
                data-name="{{ $product['name'] }}"
                data-price="{{ $product['price'] }}"
                data-original-price="{{ $product['original_price'] ?? '' }}"
                data-image="{{ $product['image'] }}"
                onclick="event.preventDefault(); cartAddFromBtn(this)"
                class="mt-4 w-full bg-primary text-on-primary py-3 flex items-center justify-center gap-2
                       font-label-sm text-[11px] tracking-widest uppercase hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
            {{ __('common.add_to_cart') }}
        </button>
    </div>
</a>

@endif
