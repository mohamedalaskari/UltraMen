@extends('layouts.app')

@section('title', __('contact.inquiry_form') . ' | ULTRA LUXURY')

@section('content')

<main class="pt-24 pb-16 md:pt-32 md:pb-32">

    {{-- ── Hero Section ─────────────────────────────────────────────────────────── --}}
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mb-12 md:mb-24">
        <div class="grid grid-cols-12 gap-6 md:gap-gutter items-center">

            <div class="col-span-12 md:col-span-6 lg:col-span-5">
                <h1 class="font-display text-4xl sm:text-5xl md:text-display uppercase mb-4 md:mb-8 leading-none">
                    {{ content_text('contact', 'get_in_touch') }}
                </h1>
                <p class="font-body-lg text-[15px] md:text-body-lg text-on-surface-variant max-w-md">
                    {{ content_text('contact', 'hero_body', __('contact.hero_body')) }}
                </p>
            </div>

            <div class="col-span-12 md:col-span-6 lg:col-span-7 mt-8 md:mt-0">
                <div class="aspect-[16/9] w-full overflow-hidden bg-surface-container">
                    <img class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                         alt="ULTRA Showroom"
                         src="{{ content_image('contact', 'showroom_image', 'images/contact-showroom.jpg') }}"/>
                </div>
            </div>

        </div>
    </section>

    {{-- ── Success Message ──────────────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mb-8">
            <div class="border border-secondary bg-secondary/5 px-5 md:px-8 py-4 md:py-5 flex items-center gap-3 md:gap-4">
                <span class="material-symbols-outlined text-secondary text-xl md:text-2xl flex-shrink-0">check_circle</span>
                <p class="font-label-sm text-[11px] md:text-label-sm text-secondary uppercase tracking-widest">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    {{-- ── Contact Grid ─────────────────────────────────────────────────────────── --}}
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mb-16 md:mb-32">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-gutter">

            {{-- Contact Form --}}
            <div class="md:col-span-7 lg:col-span-8 order-2 md:order-1">
                <h2 class="font-label-sm text-label-sm uppercase mb-8 md:mb-12 tracking-widest text-secondary">
                    {{ __('contact.inquiry_form') }}
                </h2>

                <form id="contact-form"
                      method="POST"
                      action="{{ route('contact.store') }}"
                      class="space-y-8 md:space-y-12">
                    @csrf

                    {{-- Name + Email row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-gutter">
                        <div class="flex flex-col">
                            <label class="font-label-sm text-[11px] md:text-label-sm uppercase text-on-surface-variant mb-2">
                                {{ __('contact.full_name') }}
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="{{ __('contact.name_placeholder') }}"
                                   class="custom-input font-body-md text-body-md @error('name') border-b-error @enderror"/>
                            @error('name')
                                <span class="font-label-sm text-[10px] text-error mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label class="font-label-sm text-[11px] md:text-label-sm uppercase text-on-surface-variant mb-2">
                                {{ __('contact.email_address') }}
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('contact.email_placeholder') }}"
                                   class="custom-input font-body-md text-body-md @error('email') border-b-error @enderror"/>
                            @error('email')
                                <span class="font-label-sm text-[10px] text-error mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-gutter">
                        <div class="flex flex-col">
                            <label class="font-label-sm text-[11px] md:text-label-sm uppercase text-on-surface-variant mb-2">
                                {{ __('contact.phone_number') }} <span class="text-outline">{{ __('contact.optional') }}</span>
                            </label>
                            <input type="tel"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="{{ __('contact.phone_placeholder') }}"
                                   class="custom-input font-body-md text-body-md @error('phone') border-b-error @enderror"/>
                            @error('phone')
                                <span class="font-label-sm text-[10px] text-error mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="flex flex-col">
                        <label class="font-label-sm text-[11px] md:text-label-sm uppercase text-on-surface-variant mb-2">
                            {{ __('contact.message') }}
                        </label>
                        <textarea name="message"
                                  rows="4"
                                  placeholder="{{ __('contact.message_placeholder') }}"
                                  class="custom-input font-body-md text-body-md resize-none @error('message') border-b-error @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="font-label-sm text-[10px] text-error mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full sm:w-auto bg-primary text-on-primary px-12 py-4
                                   font-label-sm text-label-sm uppercase tracking-widest
                                   hover:bg-transparent hover:text-primary
                                   border border-primary transition-all duration-300">
                        {{ __('contact.send_inquiry') }}
                    </button>
                </form>
            </div>

            {{-- Brand Details --}}
            <div class="md:col-span-5 lg:col-span-4 order-1 md:order-2 space-y-10 md:space-y-16">

                <div>
                    <h3 class="font-label-sm text-label-sm uppercase mb-4 md:mb-6 tracking-widest text-secondary">
                        {{ __('contact.showroom') }}
                    </h3>
                    <p class="font-body-lg text-[15px] md:text-body-lg leading-relaxed">
                        {{ $contactInfo['showroom']['address'] }}<br/>
                        {{ $contactInfo['showroom']['city'] }}<br/>
                        {{ $contactInfo['showroom']['country'] }}
                    </p>
                </div>

                <div>
                    <h3 class="font-label-sm text-label-sm uppercase mb-4 md:mb-6 tracking-widest text-secondary">
                        {{ __('contact.direct_reach') }}
                    </h3>
                    <div class="space-y-3 md:space-y-4">
                        <a href="mailto:{{ $contactInfo['email'] }}" class="flex items-center gap-3 md:gap-4 group">
                            <span class="material-symbols-outlined text-secondary flex-shrink-0">mail</span>
                            <span class="font-body-lg text-[15px] md:text-body-lg break-all group-hover:text-secondary transition-colors">{{ $contactInfo['email'] }}</span>
                        </a>
                        <a href="tel:{{ $contactInfo['phone'] }}" class="flex items-center gap-3 md:gap-4 group">
                            <span class="material-symbols-outlined text-secondary flex-shrink-0">call</span>
                            <span class="font-body-lg text-[15px] md:text-body-lg group-hover:text-secondary transition-colors">{{ $contactInfo['phone'] }}</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-label-sm text-label-sm uppercase mb-4 md:mb-6 tracking-widest text-secondary">
                        {{ __('contact.hours') }}
                    </h3>
                    <p class="font-body-lg text-[15px] md:text-body-lg leading-relaxed">
                        @foreach($contactInfo['hours'] as $hour)
                            {{ $hour }}<br/>
                        @endforeach
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ── Lifestyle Imagery ────────────────────────────────────────────────────── --}}
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-gutter">

            <div class="aspect-[4/5] bg-surface-container overflow-hidden luxury-card">
                <img class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                     alt="Craftsmanship"
                     src="{{ content_image('contact', 'craftsman_image', 'images/contact-craftsman.jpg') }}"/>
            </div>

            <div class="aspect-[4/5] bg-surface-container overflow-hidden luxury-card mt-0 md:mt-24">
                <img class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                     alt="ULTRA Gentleman"
                     src="{{ content_image('contact', 'gentleman_image', 'images/contact-gentleman.jpg') }}"/>
            </div>

        </div>
    </section>

</main>

@endsection
