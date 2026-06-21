@extends('layouts.app')

@section('title', 'ULTRA | ' . __('about.manifesto'))

@section('content')

{{-- ── Hero ───────────────────────────────────────────────────────────────────── --}}
<section class="relative h-screen min-h-[560px] md:h-[921px] flex items-center justify-center overflow-hidden pt-20">
    <div class="absolute inset-0 z-0">
        <img class="w-full h-full object-cover grayscale opacity-40"
             alt="Brand Philosophy Hero"
             src="{{ content_image('about', 'hero_image', 'images/about-hero.jpg') }}"/>
    </div>
    <div class="relative z-10 text-center px-margin-mobile section-fade">
        <span class="font-label-sm text-label-sm text-secondary uppercase mb-6 block tracking-[0.4em]">
            {{ __('about.manifesto') }}
        </span>
        <h1 class="font-display text-5xl md:text-[96px] uppercase leading-[0.9] max-w-4xl mx-auto mb-8 kerning-tight">
            {{ content_text('about', 'hero_title_before') }}
            <span class="text-secondary italic">{{ content_text('about', 'hero_title_highlight') }}</span>{{ content_text('about', 'hero_title_after') }}
        </h1>
        <div class="w-px h-24 bg-primary mx-auto"></div>
    </div>
</section>

{{-- ── Philosophy ──────────────────────────────────────────────────────────────── --}}
<section class="py-32 max-w-container-max mx-auto px-margin-desktop grid grid-cols-1 md:grid-cols-12 gap-gutter">
    <div class="md:col-span-5 flex flex-col justify-center section-fade">
        <h2 class="font-headline-lg text-headline-lg uppercase mb-8">
            {!! $philosophy['headline'] !!}
        </h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-12">
            {{ $philosophy['description'] }}
        </p>
        <div class="flex flex-wrap items-center gap-4">
            <button class="px-8 py-4 bg-primary text-on-primary font-label-sm text-label-sm uppercase
                           hover:bg-transparent hover:text-primary border border-primary transition-all duration-300">
                {{ __('about.explore_ethos') }}
            </button>
            <button class="px-8 py-4 border border-secondary text-secondary font-label-sm text-label-sm uppercase
                           hover:bg-secondary hover:text-on-secondary transition-all duration-300">
                {{ __('about.join_circle') }}
            </button>
        </div>
    </div>
    <div class="md:col-span-6 md:col-start-8 section-fade">
        <div class="image-reveal-container aspect-[3/4] bg-surface-container border border-surface-variant p-4">
            <img class="w-full h-full object-cover grayscale"
                 alt="Craftsmanship"
                 src="{{ asset('storage/' . $philosophy['image']) }}"/>
        </div>
    </div>
</section>

{{-- ── Three Pillars ────────────────────────────────────────────────────────────── --}}
<section class="bg-surface-container-low py-32 border-y border-surface-variant">
    <div class="max-w-container-max mx-auto px-margin-desktop">
        <div class="flex flex-col md:flex-row justify-between items-baseline mb-16 gap-8 section-fade">
            <h2 class="font-display text-5xl uppercase leading-none">
                {{ content_text('about', 'pillars_title') }}
            </h2>
            <p class="max-w-md font-body-md text-on-surface-variant">
                {{ content_text('about', 'pillars_subtitle', __('about.pillars_subtitle')) }}
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            @foreach($pillars as $pillar)
                <div class="group border border-surface-variant p-10 hover:border-secondary transition-colors duration-500 section-fade">
                    <span class="text-secondary font-display text-display opacity-10 block mb-4
                                 group-hover:opacity-100 transition-opacity duration-500">
                        {{ $pillar['number'] }}
                    </span>
                    <h3 class="font-headline-lg text-headline-lg uppercase mb-4">{{ $pillar['title'] }}</h3>
                    <p class="text-on-surface-variant leading-relaxed">{{ $pillar['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Atmospheric Full-screen Image ───────────────────────────────────────────── --}}
<section class="h-screen relative flex items-center overflow-hidden group">
    <div class="absolute inset-0 z-0">
        <img class="w-full h-full object-cover grayscale brightness-50 transition-transform duration-[3s] group-hover:scale-110"
             alt="Lifestyle"
             src="{{ content_image('about', 'lifestyle_image', 'images/about-lifestyle.jpg') }}"/>
    </div>
    <div class="relative z-10 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop w-full flex justify-end">
        <div class="max-w-xl w-full sm:w-auto bg-background/90 p-6 md:p-12 backdrop-blur-sm border-s-4 border-secondary section-fade">
            <h3 class="font-headline-lg text-headline-lg uppercase mb-6">{{ content_text('about', 'new_standard', __('about.new_standard')) }}</h3>
            <p class="font-body-lg text-body-lg mb-8">
                "{{ content_text('about', 'quote', __('about.quote')) }}"
            </p>
            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-widest">
                {{ content_text('about', 'quote_author', __('about.quote_author')) }}
            </span>
        </div>
    </div>
</section>

{{-- ── Call to Action / Newsletter ─────────────────────────────────────────────── --}}
<section class="py-32 text-center max-w-3xl mx-auto px-margin-mobile">
    <div class="section-fade">
        <h2 class="font-display text-5xl uppercase mb-8">{{ content_text('about', 'cta_title', __('about.cta_title')) }}</h2>
        <p class="text-on-surface-variant mb-12">
            {{ content_text('about', 'cta_body', __('about.cta_body')) }}
        </p>
        <form class="flex flex-col md:flex-row gap-4 items-end" method="POST" action="#">
            @csrf
            <div class="flex-grow w-full text-start">
                <label class="font-label-sm text-label-sm uppercase block mb-2 opacity-60">
                    {{ __('about.email_address') }}
                </label>
                <input type="email"
                       name="email"
                       placeholder="{{ __('about.email_placeholder') }}"
                       class="w-full bg-transparent border-0 border-b border-primary py-3 px-0
                              focus:ring-0 focus:border-secondary transition-colors
                              font-label-sm placeholder:opacity-30"/>
            </div>
            <button type="submit"
                    class="whitespace-nowrap px-10 py-4 bg-primary text-on-primary
                           font-label-sm text-label-sm uppercase
                           hover:bg-secondary transition-colors duration-300
                           w-full md:w-auto">
                {{ __('about.subscribe') }}
            </button>
        </form>
    </div>
</section>

@endsection
