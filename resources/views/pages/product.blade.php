@extends('layouts.app')

@section('title', 'ULTRA | ' . $product['name'])

@section('content')

<main class="pt-32 pb-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">

    {{-- Breadcrumbs --}}
    <nav class="mb-8 flex items-center gap-2 font-label-sm text-label-sm text-on-surface-variant/60">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">{{ __('product.home') }}</a>
        <span class="material-symbols-outlined text-[12px] rtl:rotate-180">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('collections') }}">{{ $product['category'] }}</a>
        <span class="material-symbols-outlined text-[12px] rtl:rotate-180">chevron_right</span>
        <span class="text-primary">{{ $product['name'] }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        {{-- ── Product Gallery ─────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-7 flex flex-col-reverse md:flex-row gap-gutter">

            {{-- Thumbnails (only when multiple gallery images) --}}
            @if(count($product['gallery']) > 1)
            <div class="flex md:flex-col gap-4 overflow-x-auto md:overflow-y-auto md:max-h-[600px] scrollbar-hide md:w-24 shrink-0">
                @foreach($product['gallery'] as $index => $thumb)
                <button class="thumb-btn border
                               {{ $index === 0 ? 'border-secondary' : 'border-outline-variant hover:border-secondary' }}
                               w-20 h-20 md:w-24 md:h-24 shrink-0 bg-surface-container overflow-hidden transition-colors"
                        data-src="{{ asset('storage/' . $thumb['image']) }}">
                    <img class="w-full h-full object-cover"
                         src="{{ asset('storage/' . $thumb['image']) }}"
                         alt="{{ $product['name'] }}"/>
                </button>
                @endforeach
            </div>
            @endif

            {{-- Main Image --}}
            <div class="relative w-full aspect-[4/5] bg-surface-container-low border border-outline-variant/10 overflow-hidden group">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                     id="main-product-image"
                     src="{{ asset('storage/' . $product['gallery'][0]['image']) }}"
                     alt="{{ $product['name'] }}"/>
                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 pointer-events-none
                            transition-opacity duration-300 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-4xl drop-shadow-lg">zoom_in</span>
                </div>
            </div>
        </div>

        {{-- ── Product Details ─────────────────────────────────────────────────────── --}}
        <div class="lg:col-span-5">
            <div class="sticky top-40">

                <h1 class="font-headline-lg text-headline-lg text-primary mb-2">{{ $product['name'] }}</h1>
                <p class="font-label-sm text-label-sm text-secondary mb-8 tracking-[0.2em]">{{ $product['subtitle'] }}</p>

                <div class="flex items-center gap-4 mb-8">
                    @if(!empty($product['original_price']))
                        <span class="text-xl font-light text-outline line-through opacity-70">{{ $product['original_price'] }}</span>
                    @endif
                    <span class="text-3xl font-light text-primary">{{ $product['price'] }}</span>
                    @if(!empty($product['discount_percent']))
                    <span class="px-3 py-1 bg-error text-white font-label-sm text-[10px]">
                        -{{ $product['discount_percent'] }}%
                    </span>
                    @elseif($product['badge'])
                    <span class="px-3 py-1 border border-secondary text-secondary font-label-sm text-[10px]">
                        {{ $product['badge'] }}
                    </span>
                    @endif
                </div>

                <div class="space-y-6 mb-10">
                    <p class="text-on-surface-variant leading-relaxed">{{ $product['description'] }}</p>

                    {{-- Trust Badges --}}
                    <div class="flex flex-wrap gap-6 py-4 border-y border-outline-variant/20">
                        @foreach($product['trust'] as $trust)
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary scale-75">{{ $trust['icon'] }}</span>
                            <span class="font-label-sm text-[10px] uppercase tracking-widest">{{ $trust['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Options --}}
                <div class="space-y-8 mb-10">

                    {{-- Finish Selection --}}
                    <div>
                        <span class="font-label-sm text-label-sm block mb-4">
                            {{ __('product.finish') }} <span class="text-on-surface-variant font-normal" id="selected-finish">{{ $product['finishes'][0]['label'] }}</span>
                        </span>
                        <div class="flex gap-3">
                            @foreach($product['finishes'] as $i => $finish)
                            <button class="finish-btn w-10 h-10 border-2 transition-all
                                           {{ $i === 0 ? 'border-primary ring-offset-2 ring-1 ring-primary/20' : 'border-outline-variant hover:border-primary' }}"
                                    style="background-color: {{ $finish['color'] }}"
                                    data-label="{{ $finish['label'] }}">
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Size Selection --}}
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-label-sm text-label-sm">{{ __('product.select_size') }}</span>
                            <button class="font-label-sm text-[10px] text-secondary border-b border-secondary">{{ __('product.size_guide') }}</button>
                        </div>
                        <div class="grid gap-2 {{ count($product['sizes']) <= 3 ? 'grid-cols-3' : 'grid-cols-4' }}">
                            @foreach($product['sizes'] as $i => $size)
                            <button class="size-btn py-3 font-label-sm text-xs transition-colors
                                           {{ $i === 0
                                               ? 'border border-primary text-primary'
                                               : 'border border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary' }}">
                                {{ $size }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col gap-4">
                    <button data-slug="{{ $slug }}"
                            data-name="{{ $product['name'] }}"
                            data-price="{{ $product['price'] }}"
                            data-original-price="{{ $product['original_price'] ?? '' }}"
                            data-image="{{ $product['gallery'][0]['image'] }}"
                            onclick="cartAddFromBtn(this)"
                            class="w-full bg-primary text-background py-5 font-label-sm tracking-[0.3em]
                                   hover:bg-secondary transition-colors duration-500
                                   group flex justify-center items-center gap-4">
                        {{ __('product.add_to_bag') }}
                        <span class="material-symbols-outlined scale-75 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform rtl:rotate-180">arrow_forward</span>
                    </button>
                </div>

                {{-- Accordions --}}
                <div class="mt-12 border-t border-outline-variant/20">
                    @foreach($product['accordions'] as $accordion)
                    <div class="border-b border-outline-variant/20">
                        <button class="w-full py-6 flex justify-between items-center accordion-trigger"
                                data-target="{{ Str::slug($accordion['title']) }}-content">
                            <span class="font-label-sm text-label-sm">{{ $accordion['title'] }}</span>
                            <span class="material-symbols-outlined transition-transform accordion-icon">expand_more</span>
                        </button>
                        <div class="hidden pb-6 text-on-surface-variant text-sm leading-relaxed"
                             id="{{ Str::slug($accordion['title']) }}-content">
                            {{ $accordion['content'] }}
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    {{-- ── Style It With ────────────────────────────────────────────────────────── --}}
    <section class="mt-32">
        <div class="flex items-end justify-between mb-12 border-b border-primary/10 pb-6">
            <div>
                <h2 class="font-headline-lg text-headline-lg mb-2">{{ __('product.style_it_with') }}</h2>
                <p class="font-label-sm text-[10px] text-on-surface-variant tracking-[0.2em]">{{ __('product.curated_complements') }}</p>
            </div>
            <a href="{{ route('collections') }}"
               class="font-label-sm text-label-sm text-secondary flex items-center gap-2 hover:gap-4 transition-all">
                {{ __('product.view_all_accessories') }}
                <span class="material-symbols-outlined scale-75 rtl:rotate-180">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            @foreach($related as $item)
                <x-product-card :product="$item" variant="gallery"/>
            @endforeach
        </div>
    </section>

</main>

@endsection

@push('scripts')
<script>
// Thumbnail switcher
document.querySelectorAll('.thumb-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('main-product-image').src = this.dataset.src;
        document.querySelectorAll('.thumb-btn').forEach(b => {
            b.classList.remove('border-secondary');
            b.classList.add('border-outline-variant');
        });
        this.classList.add('border-secondary');
        this.classList.remove('border-outline-variant');
    });
});

// Finish selector
document.querySelectorAll('.finish-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('selected-finish').textContent = this.dataset.label;
        document.querySelectorAll('.finish-btn').forEach(b => {
            b.classList.remove('border-primary');
            b.classList.add('border-outline-variant');
        });
        this.classList.add('border-primary');
        this.classList.remove('border-outline-variant');
    });
});

// Size selector
document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.size-btn').forEach(b => {
            b.classList.remove('border-primary', 'text-primary');
            b.classList.add('border-outline-variant', 'text-on-surface-variant');
        });
        this.classList.add('border-primary', 'text-primary');
        this.classList.remove('border-outline-variant', 'text-on-surface-variant');
    });
});

// Accordion
document.querySelectorAll('.accordion-trigger').forEach(btn => {
    btn.addEventListener('click', function () {
        const content = document.getElementById(this.dataset.target);
        const icon    = this.querySelector('.accordion-icon');
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    });
});
</script>
@endpush
