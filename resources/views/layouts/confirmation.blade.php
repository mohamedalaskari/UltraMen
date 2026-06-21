<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'ULTRA | Order Confirmed')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary-fixed-dim": "#ccc7ad",
                        "error": "#ba1a1a",
                        "surface-container-highest": "#e4e2e2",
                        "inverse-surface": "#303030",
                        "on-primary-container": "#858383",
                        "on-surface-variant": "#444748",
                        "primary-fixed-dim": "#c8c6c5",
                        "outline": "#747878",
                        "on-tertiary": "#ffffff",
                        "surface-container-high": "#eae8e7",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed-variant": "#4a4733",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#f5f3f3",
                        "surface-variant": "#e4e2e2",
                        "outline-variant": "#c4c7c7",
                        "on-secondary": "#ffffff",
                        "on-surface": "#1b1c1c",
                        "surface-tint": "#5f5e5e",
                        "primary": "#000000",
                        "on-secondary-fixed-variant": "#5d4201",
                        "inverse-on-surface": "#f2f0f0",
                        "on-tertiary-container": "#88846d",
                        "surface": "#fbf9f8",
                        "surface-bright": "#fbf9f8",
                        "background": "#fbf9f8",
                        "primary-container": "#1c1b1b",
                        "inverse-primary": "#c8c6c5",
                        "surface-container": "#efeded",
                        "secondary-fixed": "#ffdea5",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#e9e3c7",
                        "on-secondary-container": "#785a1a",
                        "on-primary-fixed": "#1c1b1b",
                        "on-primary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#fed488",
                        "tertiary": "#000000",
                        "secondary-fixed-dim": "#e9c176",
                        "surface-dim": "#dbd9d9",
                        "on-background": "#1b1c1c",
                        "primary-fixed": "#e5e2e1",
                        "on-tertiary-fixed": "#1e1c0b",
                        "on-primary-fixed-variant": "#474646",
                        "tertiary-container": "#1e1c0b",
                        "secondary": "#775a19",
                        "on-secondary-fixed": "#261900"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "gutter": "24px",
                        "unit": "8px",
                        "margin-desktop": "64px",
                        "margin-mobile": "16px",
                        "container-max": "1280px"
                    },
                    fontFamily: {
                        "headline-lg-mobile": ["Montserrat"],
                        "label-sm": ["Montserrat"],
                        "body-lg": ["Montserrat"],
                        "body-md": ["Montserrat"],
                        "headline-lg": ["Montserrat"],
                        "display": ["Montserrat"]
                    },
                    fontSize: {
                        "headline-lg-mobile": ["24px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "label-sm": ["12px", {"lineHeight": "1.0", "letterSpacing": "0.15em", "fontWeight": "700"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "display": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    @stack('styles')
</head>
<body class="font-body-md text-on-surface">

    @include('layouts.partials.header')
    @include('layouts.partials.cart-drawer')

    {{-- ── Progress Stepper (all completed + step 3 active) ────────────────────── --}}
    <div class="border-b border-outline-variant pt-20 pb-8">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="flex items-center justify-center gap-4 md:gap-12">

                {{-- Step 1: Completed --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">check</span>
                    </div>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary hidden sm:inline">Shopping Bag</span>
                </div>

                <div class="h-px w-12 md:w-24 bg-primary"></div>

                {{-- Step 2: Completed --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">check</span>
                    </div>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary hidden sm:inline">Checkout</span>
                </div>

                <div class="h-px w-12 md:w-24 bg-primary"></div>

                {{-- Step 3: Active --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full border-2 border-secondary flex items-center justify-center text-secondary font-bold">
                        3
                    </div>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary font-bold hidden sm:inline">Confirmation</span>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    @include('layouts.partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
