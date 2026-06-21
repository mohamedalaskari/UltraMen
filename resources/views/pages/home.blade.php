@extends('layouts.app')

@section('title', 'ULTRA | Modern Heirloom')

@section('content')

{{-- ── Hero ──────────────────────────────────────────────────────────────────── --}}
<section class="relative h-screen w-full flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/10 to-transparent z-10"></div>
        <img class="w-full h-full object-cover grayscale brightness-90 contrast-125"
             alt="A high-fashion editorial portrait of a confident man in premium luxury streetwear."
             src="{{ content_image('home', 'hero_image', 'images/hero.jpg') }}"/>
    </div>
    <div class="relative z-20 text-center px-margin-mobile">
        <h1 class="font-display text-4xl md:text-7xl uppercase tracking-tighter mb-4 charcoal-gradient">
            {{ content_text('home', 'hero_title', __('home.hero_title')) }}
        </h1>
        <p class="text-[12px] font-bold tracking-[0.3em] text-secondary mb-12 uppercase">
            {{ content_text('home', 'hero_subtitle', __('home.hero_subtitle')) }}
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a class="w-full sm:w-auto bg-primary text-on-primary px-10 py-4 text-[14px] font-bold uppercase transition-all hover:bg-secondary active:scale-95"
               href="{{ route('collections') }}">
                {{ __('common.explore_collection') }}
            </a>
            <a class="w-full sm:w-auto border-2 border-outline text-primary px-10 py-4 text-[14px] font-bold uppercase transition-all hover:bg-surface-container active:scale-95"
               href="{{ route('about') }}">
                {{ __('common.the_story') }}
            </a>
        </div>
    </div>
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce">
        <span class="material-symbols-outlined text-secondary opacity-50">keyboard_double_arrow_down</span>
    </div>
</section>

{{-- ── Brand Intro ───────────────────────────────────────────────────────────── --}}
<section class="py-16 md:py-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center">
    <div class="reveal">
        <span class="text-[12px] font-bold tracking-[0.2em] text-outline block mb-4 uppercase">{{ content_text('home', 'philosophy_label', __('home.philosophy_label')) }}</span>
        <h2 class="font-headline-lg text-2xl md:text-4xl max-w-4xl mx-auto leading-tight mb-8 text-primary">
            {{ content_text('home', 'philosophy_title_before') }}
            <span class="italic text-secondary">{{ content_text('home', 'philosophy_title_highlight') }}</span>{{ content_text('home', 'philosophy_title_after') }}
        </h2>
        <div class="editorial-line w-24 mx-auto mb-8"></div>
        <p class="font-body-lg text-on-surface-variant max-w-2xl mx-auto">
            {{ content_text('home', 'philosophy_body', __('home.philosophy_body')) }}
        </p>
    </div>
</section>

{{-- ── Categories Bento Grid ─────────────────────────────────────────────────── --}}
<section class="py-16 md:py-24 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="flex justify-between items-end mb-8 reveal">
        <div>
            <span class="text-[12px] font-bold tracking-widest text-outline block mb-2 uppercase">{{ __('home.shop_by') }}</span>
            <h2 class="text-2xl md:text-3xl font-bold text-primary uppercase">{{ __('home.categories') }}</h2>
        </div>
        <a class="text-[12px] font-bold uppercase border-b-2 border-secondary text-primary hover:text-secondary transition-colors pb-1"
           href="{{ route('collections') }}">
            {{ __('common.show_all') }}
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-6 md:grid-rows-2 gap-3 md:gap-4 md:h-[800px]">
        @foreach($categories as $category)
            <a href="{{ route('collections', ['category' => $category['slug']]) }}"
               class="{{ $category['span'] }} relative group overflow-hidden bg-surface-container reveal aspect-square md:aspect-auto block"
               style="transition-delay: {{ $category['delay'] }}">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale"
                     alt="{{ $category['name'] }}"
                     src="{{ asset('storage/' . $category['image']) }}"/>
                <div class="absolute inset-0 bg-primary/20 group-hover:bg-primary/40 transition-colors flex flex-col justify-end p-4 md:p-8">
                    <h3 class="text-base md:text-2xl font-bold text-surface uppercase">{{ $category['name'] }}</h3>
                    <span class="text-[10px] font-bold text-secondary-fixed mt-2 flex items-center uppercase tracking-widest">
                        SHOP NOW
                        <span class="material-symbols-outlined text-xs ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- ── Best Sellers ──────────────────────────────────────────────────────────── --}}
<section class="py-16 md:py-24 bg-surface-container-lowest overflow-hidden">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="flex justify-between items-end mb-8 reveal">
            <div>
                <span class="text-[12px] font-bold tracking-widest text-outline block mb-2 uppercase">{{ __('home.curated_for_you') }}</span>
                <h2 class="text-2xl md:text-3xl font-bold text-primary uppercase">{{ __('home.best_sellers') }}</h2>
            </div>
            <div class="flex items-center gap-6">
                @if(count($bestSellers) > 4)
                <div class="flex items-center gap-2">
                    <button type="button" onclick="scrollBestSellers(-1)" id="bsScrollLeft"
                            class="w-9 h-9 md:w-10 md:h-10 border border-outline-variant flex items-center justify-center
                                   hover:border-primary hover:bg-primary hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-lg rtl:rotate-180">chevron_left</span>
                    </button>
                    <button type="button" onclick="scrollBestSellers(1)" id="bsScrollRight"
                            class="w-9 h-9 md:w-10 md:h-10 border border-outline-variant flex items-center justify-center
                                   hover:border-primary hover:bg-primary hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-lg rtl:rotate-180">chevron_right</span>
                    </button>
                </div>
                @endif
                <a class="text-[12px] font-bold uppercase border-b-2 border-secondary text-primary hover:text-secondary transition-colors pb-1"
                   href="{{ route('collections') }}">
                    {{ __('common.view_all') }}
                </a>
            </div>
        </div>
        @if(count($bestSellers) > 4)
            {{-- ── Horizontal scroll (more than 4 products) ──────────────────────── --}}
            <div id="bestSellersScroll"
                 class="flex gap-4 md:gap-gutter mt-8 md:mt-12 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar pb-2">
                @foreach($bestSellers as $product)
                    <div class="w-[calc(50%-8px)] lg:w-[calc(25%-18px)] flex-shrink-0 snap-start">
                        <x-product-card :product="$product" variant="compact" :delay="$product['delay']" />
                    </div>
                @endforeach
            </div>
        @else
            {{-- ── Static grid (4 or fewer products) ────────────────────────────── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-gutter mt-8 md:mt-12">
                @foreach($bestSellers as $product)
                    <x-product-card :product="$product" variant="compact" :delay="$product['delay']" />
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ── Newsletter ────────────────────────────────────────────────────────────── --}}
<section class="py-16 md:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-secondary/10 z-0"></div>
    <div class="max-w-4xl mx-auto px-margin-mobile text-center relative z-10 reveal">
        <h2 class="text-4xl md:text-6xl uppercase mb-8 charcoal-gradient leading-none font-bold">{{ content_text('home', 'newsletter_title', __('home.newsletter_title')) }}</h2>
        <p class="font-body-lg text-on-surface-variant mb-12">
            {{ content_text('home', 'newsletter_body', __('home.newsletter_body')) }}
        </p>
        <form class="flex flex-col sm:flex-row max-w-lg mx-auto border-b-2 border-secondary pb-2 group focus-within:border-primary transition-colors">
            @csrf
            <input class="bg-transparent border-none focus:ring-0 flex-grow font-bold text-[12px] uppercase placeholder:text-outline text-primary py-4 px-0"
                   placeholder="{{ __('home.newsletter_placeholder') }}"
                   type="email"
                   name="email"/>
            <button class="text-[14px] font-bold uppercase tracking-widest text-primary hover:text-secondary py-4 sm:pl-8 transition-colors"
                    type="submit">
                {{ __('home.newsletter_button') }}
            </button>
        </form>
        <p class="text-[10px] text-outline mt-8 uppercase font-bold tracking-widest">
            {{ __('home.newsletter_disclaimer') }}
        </p>
    </div>
</section>

@endsection

@push('styles')
<style>
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endpush

@push('scripts')
<script>
function scrollBestSellers(direction) {
    const container = document.getElementById('bestSellersScroll');
    if (!container) return;
    const rtlSign = document.documentElement.dir === 'rtl' ? -1 : 1;
    container.scrollBy({ left: container.clientWidth * 0.85 * direction * rtlSign, behavior: 'smooth' });
}

(function () {
    const container = document.getElementById('bestSellersScroll');
    const leftBtn    = document.getElementById('bsScrollLeft');
    const rightBtn   = document.getElementById('bsScrollRight');
    if (!container || !leftBtn || !rightBtn) return;

    function updateArrows() {
        const maxScroll = container.scrollWidth - container.clientWidth;
        const scrollPos = Math.abs(container.scrollLeft);
        const atStart   = scrollPos <= 4;
        const atEnd     = scrollPos >= maxScroll - 4;
        leftBtn.classList.toggle('opacity-30', atStart);
        leftBtn.classList.toggle('pointer-events-none', atStart);
        rightBtn.classList.toggle('opacity-30', atEnd);
        rightBtn.classList.toggle('pointer-events-none', atEnd);
    }

    container.addEventListener('scroll', updateArrows);
    window.addEventListener('resize', updateArrows);
    updateArrows();
})();
</script>
@endpush
