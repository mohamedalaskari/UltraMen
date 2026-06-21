@extends('layouts.app')

@section('title', 'ULTRA | ' . __('archive.title'))

@section('content')

{{-- ── Hero ───────────────────────────────────────────────────────────────────── --}}
<header class="relative w-full h-[420px] sm:h-[500px] md:h-[614px] overflow-hidden flex items-center justify-center mt-20">
    <div class="absolute inset-0 z-0">
        <img class="w-full h-full object-cover"
             alt="The Apparel Archive Hero"
             src="{{ asset('storage/images/archive-hero.jpg') }}"/>
        <div class="absolute inset-0 bg-primary/30"></div>
    </div>
    <div class="relative z-10 text-center px-margin-mobile">
        <p class="font-label-sm text-label-sm text-white/80 tracking-[0.3em] mb-4 uppercase">
            {{ __('archive.most_coveted', ['year' => now()->format('Y')]) }}
        </p>
        <h1 class="font-display text-5xl md:text-display text-white uppercase">
            {{ __('archive.title') }}
        </h1>
        <div class="mt-8 flex justify-center">
            <div class="w-px h-16 bg-white/40"></div>
        </div>
    </div>
</header>

{{-- ── Main Content ─────────────────────────────────────────────────────────────── --}}
<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-20">

    {{-- Filter & Utility Bar --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center
                mb-12 border-b border-outline-variant pb-6 gap-6">

        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-secondary">workspace_premium</span>
            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">
                {{ __('archive.coveted_pieces') }}
            </span>
        </div>

        <div class="flex items-center gap-4">
            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                {{ $filters['total'] }} {{ __('archive.items') }}
            </span>
            <div class="w-px h-4 bg-outline-variant"></div>
            <div class="flex items-center gap-2 cursor-pointer font-label-sm text-label-sm
                        uppercase tracking-wider hover:text-secondary transition-colors">
                {{ __('archive.sort_by') }}
                <span class="material-symbols-outlined text-base">sort</span>
            </div>
        </div>
    </div>

    {{-- ── Asymmetric Bento Product Grid ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">

        {{-- Featured Product (col-span-8) --}}
        @if($featured)
        <a href="{{ route('product.show', $featured['slug']) }}" class="md:col-span-8 group block">
            <div class="product-image-container relative aspect-[16/10] overflow-hidden
                        bg-surface-container border border-outline-variant">
                <img class="w-full h-full object-cover hover-zoom"
                     alt="{{ $featured['name'] }}"
                     src="{{ asset('storage/' . $featured['image']) }}"/>
                <div class="absolute bottom-6 end-6
                               opacity-0 group-hover:opacity-100 transition-opacity
                               bg-primary text-on-primary px-8 py-3
                               font-label-sm text-label-sm uppercase tracking-widest">
                    {{ __('archive.view_product') }}
                </div>
            </div>
            <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                <div>
                    <h3 class="font-headline-lg text-headline-lg uppercase text-primary">
                        {{ $featured['name'] }}
                    </h3>
                    <p class="font-body-md text-on-surface-variant mt-1">{{ $featured['subtitle'] }}</p>
                </div>
                <span class="font-body-lg text-body-lg text-primary whitespace-nowrap">
                    {{ $featured['price'] }}
                </span>
            </div>
        </a>
        @endif

        {{-- Grid Products (col-span-4 each) --}}
        @foreach($products as $product)
            <div class="md:col-span-4">
                <x-product-card :product="$product" variant="archive" />
            </div>
        @endforeach

    </div>

    {{-- ── Pagination ───────────────────────────────────────────────────────────── --}}
    @if($pagination['total'] > 1)
    <div class="mt-12 md:mt-20 flex justify-center items-center gap-4">
        @if($pagination['prev_url'])
            <a href="{{ $pagination['prev_url'] }}"
               class="w-12 h-12 flex items-center justify-center
                      border border-outline-variant hover:border-primary transition-colors">
                <span class="material-symbols-outlined rtl:rotate-180">chevron_left</span>
            </a>
        @else
            <span class="w-12 h-12 flex items-center justify-center
                         border border-outline-variant opacity-30 cursor-not-allowed">
                <span class="material-symbols-outlined rtl:rotate-180">chevron_left</span>
            </span>
        @endif

        <span class="font-label-sm text-label-sm">
            {{ $pagination['current'] }} / {{ $pagination['total'] }}
        </span>

        @if($pagination['next_url'])
            <a href="{{ $pagination['next_url'] }}"
               class="w-12 h-12 flex items-center justify-center
                      border border-outline-variant hover:border-primary transition-colors">
                <span class="material-symbols-outlined rtl:rotate-180">chevron_right</span>
            </a>
        @else
            <span class="w-12 h-12 flex items-center justify-center
                         border border-outline-variant opacity-30 cursor-not-allowed">
                <span class="material-symbols-outlined rtl:rotate-180">chevron_right</span>
            </span>
        @endif
    </div>
    @endif

</main>

{{-- ── Newsletter CTA ───────────────────────────────────────────────────────────── --}}
<section class="bg-surface-container-high py-16 md:py-24 px-margin-mobile md:px-margin-desktop">
    <div class="max-w-container-max mx-auto text-center">
        <h2 class="font-headline-lg text-headline-lg uppercase tracking-widest text-primary mb-6">
            {{ __('archive.be_first_to_know') }}
        </h2>
        <p class="font-body-md text-on-surface-variant max-w-lg mx-auto mb-10">
            {{ __('archive.newsletter_body') }}
        </p>
        <form class="flex flex-col md:flex-row max-w-xl mx-auto gap-4" method="POST" action="#">
            @csrf
            <input type="email"
                   name="email"
                   placeholder="{{ __('archive.email_placeholder') }}"
                   class="flex-1 bg-transparent border-b border-primary py-3 px-2
                          font-label-sm text-label-sm placeholder:text-outline
                          focus:outline-none focus:border-secondary transition-colors uppercase"/>
            <button type="submit"
                    class="bg-primary text-on-primary px-10 py-3
                           font-label-sm text-label-sm tracking-widest uppercase
                           hover:bg-secondary transition-colors">
                {{ __('archive.subscribe') }}
            </button>
        </form>
    </div>
</section>

@endsection
