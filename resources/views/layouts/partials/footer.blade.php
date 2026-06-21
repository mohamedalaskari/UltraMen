<footer class="w-full bg-surface-container-low border-t border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-16
                grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-gutter">

        {{-- Brand Column --}}
        <div class="md:col-span-4">
            <a href="{{ route('home') }}" class="inline-block mb-6">
                <img alt="ULTRA" class="h-12 w-auto grayscale hover:grayscale-0 transition-all duration-500"
                     src="{{ asset('storage/images/logo.png') }}"/>
            </a>
            <p class="font-body-md text-on-surface-variant max-w-xs leading-relaxed">
                {{ content_text('footer', 'footer_tagline', __('nav.footer_tagline')) }}
            </p>
        </div>

        {{-- Shop Column --}}
        <div class="md:col-span-2">
            <h4 class="font-label-sm text-label-sm uppercase mb-6 text-primary">{{ __('nav.footer_shop') }}</h4>
            <ul class="space-y-4">
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="{{ route('collections') }}">{{ __('nav.collections') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">{{ __('nav.footer_new_arrivals') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">{{ __('nav.footer_essentials') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="{{ route('best-sellers') }}">{{ __('nav.best_sellers') }}</a></li>
            </ul>
        </div>

        {{-- Information Column --}}
        <div class="md:col-span-2">
            <h4 class="font-label-sm text-label-sm uppercase mb-6 text-primary">{{ __('nav.footer_information') }}</h4>
            <ul class="space-y-4">
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">{{ __('nav.footer_privacy') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">{{ __('nav.footer_terms') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">{{ __('nav.footer_shipping') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="{{ route('about') }}">{{ __('nav.footer_about') }}</a></li>
                <li><a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="{{ route('contact') }}">{{ __('nav.contact') }}</a></li>
            </ul>
        </div>

        {{-- Connect Column --}}
        <div class="md:col-span-4 flex flex-col justify-between">
            <div>
                <h4 class="font-label-sm text-label-sm uppercase mb-6 text-primary">{{ __('nav.footer_connect') }}</h4>
                <div class="flex gap-3 flex-wrap">
                    @if($instagram = content_url('footer', 'social_instagram'))
                        <a href="{{ $instagram }}" target="_blank" rel="noopener" aria-label="Instagram"
                           class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary transition-colors">
                            <svg viewBox="0 0 24 24" class="w-[18px] h-[18px]" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if($twitter = content_url('footer', 'social_twitter'))
                        <a href="{{ $twitter }}" target="_blank" rel="noopener" aria-label="X (Twitter)"
                           class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary transition-colors">
                            <svg viewBox="0 0 24 24" class="w-[16px] h-[16px]" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    @if($linkedin = content_url('footer', 'social_linkedin'))
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn"
                           class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary transition-colors">
                            <svg viewBox="0 0 24 24" class="w-[17px] h-[17px]" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.114 20.452H3.558V9h3.556v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    @endif
                    @if($facebook = content_url('footer', 'social_facebook'))
                        <a href="{{ $facebook }}" target="_blank" rel="noopener" aria-label="Facebook"
                           class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary transition-colors">
                            <svg viewBox="0 0 24 24" class="w-[16px] h-[16px]" fill="currentColor"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"/></svg>
                        </a>
                    @endif
                    @if($tiktok = content_url('footer', 'social_tiktok'))
                        <a href="{{ $tiktok }}" target="_blank" rel="noopener" aria-label="TikTok"
                           class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface-variant hover:border-secondary hover:text-secondary transition-colors">
                            <svg viewBox="0 0 24 24" class="w-[16px] h-[16px]" fill="currentColor"><path d="M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6 0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64 0 3.33 2.76 5.7 5.69 5.7 3.16 0 5.71-2.55 5.71-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.25-1.48z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
            <p class="font-label-sm text-[10px] text-outline uppercase tracking-[0.2em] mt-12">
                &copy; {{ date('Y') }} ULTRA LUXURY. {{ content_text('footer', 'footer_rights', __('nav.footer_rights')) }}
            </p>
        </div>

    </div>
</footer>
