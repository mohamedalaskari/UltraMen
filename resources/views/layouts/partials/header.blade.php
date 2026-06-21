@php
    $navLinks = [
        ['route' => 'home',        'label' => __('nav.home')],
        ['route' => 'collections', 'label' => __('nav.collections')],
        ['route' => 'about',       'label' => __('nav.about')],
        ['route' => 'best-sellers', 'label' => __('nav.best_sellers')],
        ['route' => 'contact',     'label' => __('nav.contact')],
    ];
@endphp

<header class="fixed top-0 w-full z-50 border-b border-outline-variant bg-surface/80 backdrop-blur-md transition-all duration-300 ease-in-out"
        id="main-nav">
    <nav class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop flex justify-between items-center h-20">

        <div class="flex items-center gap-10">
            <a class="block w-12" href="{{ route('home') }}">
                <img alt="ULTRA" class="w-full h-auto" src="{{ asset('storage/images/logo.png') }}"/>
            </a>
            <div class="hidden md:flex gap-8">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="nav-link transition-colors
                           {{ request()->routeIs($link['route'])
                               ? 'text-primary border-b-2 border-secondary pb-1'
                               : 'text-on-surface-variant hover:text-secondary' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-6">
            <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
               class="text-on-surface-variant hover:text-secondary transition-colors font-label-sm text-[11px] tracking-widest uppercase">
                {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
            </a>
            <button class="text-primary hover:text-secondary transition-colors" onclick="toggleSearch()" aria-label="{{ __('common.search_placeholder') }}">
                <span class="material-symbols-outlined">search</span>
            </button>
            <button class="text-primary hover:text-secondary transition-colors relative" onclick="toggleCart()">
                <span class="material-symbols-outlined">shopping_cart</span>
                @php $cartCount = array_sum(array_column(session('cart', []), 'qty')); @endphp
                <span id="cartBadge"
                      class="absolute -top-1 -end-1 bg-secondary text-on-secondary text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center {{ $cartCount === 0 ? 'hidden' : '' }}">
                    {{ $cartCount }}
                </span>
            </button>
            <button class="md:hidden text-primary transition-colors hover:text-secondary"
                    onclick="toggleMobileMenu()"
                    id="mobileMenuBtn">
                <span class="material-symbols-outlined" id="mobileMenuIcon">menu</span>
            </button>
        </div>

    </nav>

    {{-- Mobile Menu --}}
    <div id="mobileMenu"
         class="md:hidden overflow-hidden max-h-0 transition-all duration-500 ease-in-out bg-surface border-t border-outline-variant">
        <div class="px-margin-mobile py-6 flex flex-col space-y-1">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="nav-link py-4 border-b border-outline-variant/50 transition-colors flex items-center justify-between
                       {{ request()->routeIs($link['route'])
                           ? 'text-primary'
                           : 'text-on-surface-variant hover:text-secondary' }}">
                    {{ $link['label'] }}
                    @if(request()->routeIs($link['route']))
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu    = document.getElementById('mobileMenu');
    const icon    = document.getElementById('mobileMenuIcon');
    const isOpen  = menu.style.maxHeight && menu.style.maxHeight !== '0px';

    if (isOpen) {
        menu.style.maxHeight = '0px';
        icon.textContent = 'menu';
    } else {
        menu.style.maxHeight = menu.scrollHeight + 'px';
        icon.textContent = 'close';
    }
}
</script>
