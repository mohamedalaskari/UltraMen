<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>ULTRA Admin — @yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Noto+Kufi+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#775a19',
                        'gold-light': '#fed488',
                        sidebar: '#0a0a0a',
                        'sidebar-hover': '#1a1a1a',
                        'sidebar-active': '#1f1a10',
                    },
                    fontFamily: { sans: ['Montserrat', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Montserrat', sans-serif; }
        [dir="rtl"] *:not(.material-symbols-outlined) { font-family: 'Noto Kufi Arabic', 'Montserrat', sans-serif; }
        .nav-link { display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:11px; letter-spacing:0.12em; text-transform:uppercase; font-weight:600; color:#888; border-inline-start:2px solid transparent; transition:all .2s; }
        .nav-link:hover  { color:#fff; background:#1a1a1a; border-inline-start-color:#775a19; }
        .nav-link.active { color:#fed488; background:#1f1a10; border-inline-start-color:#775a19; }
        .nav-link .material-symbols-outlined { font-size:18px; flex-shrink:0; }
        .badge-pending    { background:#fef3c7; color:#92400e; }
        .badge-confirmed  { background:#dbeafe; color:#1e40af; }
        .badge-processing { background:#ede9fe; color:#5b21b6; }
        .badge-shipped    { background:#d1fae5; color:#065f46; }
        .badge-delivered  { background:#dcfce7; color:#166534; }
        .badge-cancelled  { background:#fee2e2; color:#991b1b; }
        .badge-status { display:inline-flex; align-items:center; padding:3px 10px; font-size:10px; letter-spacing:.1em; font-weight:700; text-transform:uppercase; border-radius:2px; }
        input[type=file]::file-selector-button { font-family:'Montserrat',sans-serif; font-size:10px; letter-spacing:.1em; text-transform:uppercase; padding:6px 12px; background:#0a0a0a; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

{{-- ── Mobile Overlay ────────────────────────────────────────────────────────── --}}
<div id="sidebarOverlay"
     class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"
     onclick="closeSidebar()"></div>

{{-- ── Sidebar ───────────────────────────────────────────────────────────────── --}}
<aside id="sidebar"
       class="fixed inset-y-0 start-0 z-50 w-60 bg-sidebar flex flex-col
              {{ app()->getLocale() === 'ar' ? 'translate-x-full' : '-translate-x-full' }} lg:translate-x-0 transition-transform duration-300">

    {{-- Logo --}}
    <div class="px-6 py-6 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="block">
            <span class="text-white font-black text-xl tracking-[.25em]">ULTRA</span>
            <span class="block text-gold text-[9px] tracking-[.2em] mt-0.5">{{ __('admin.admin_panel') }}</span>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 py-4 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined">dashboard</span>{{ __('admin.dashboard') }}
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">inventory_2</span>{{ __('admin.products') }}
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">category</span>{{ __('admin.categories') }}
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">receipt_long</span>{{ __('admin.orders') }}
            @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
            @if($pending > 0)
            <span class="ms-auto bg-gold text-white text-[9px] font-bold px-1.5 py-0.5 min-w-[18px] text-center">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.messages.index') }}"
           class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">mail</span>{{ __('admin.messages') }}
            @php $unread = \App\Models\ContactMessage::where('is_read',false)->count(); @endphp
            @if($unread > 0)
            <span class="ms-auto bg-red-600 text-white text-[9px] font-bold px-1.5 py-0.5 min-w-[18px] text-center">{{ $unread }}</span>
            @endif
        </a>
        <a href="{{ route('admin.shipping.index') }}"
           class="nav-link {{ request()->routeIs('admin.shipping*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">local_shipping</span>{{ __('admin.shipping_tax') }}
        </a>
        <a href="{{ route('admin.coupons.index') }}"
           class="nav-link {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">sell</span>{{ __('admin.coupons') }}
        </a>
        <a href="{{ route('admin.settings.index') }}"
           class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">tune</span>{{ __('admin_settings.title') }}
        </a>
    </nav>

    {{-- Footer --}}
    <div class="px-4 py-4 border-t border-white/10">
        <a href="{{ route('home') }}" target="_blank"
           class="nav-link text-[10px] mb-1">
            <span class="material-symbols-outlined">open_in_new</span>{{ __('admin.view_site') }}
        </a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-link w-full text-start">
                <span class="material-symbols-outlined">logout</span>{{ __('admin.logout') }}
            </button>
        </form>
    </div>
</aside>

{{-- ── Main ──────────────────────────────────────────────────────────────────── --}}
<div class="lg:ps-60 min-h-screen flex flex-col">

    {{-- Top bar --}}
    <header class="sticky top-0 z-30 bg-white border-b border-gray-200 px-4 md:px-8 py-4 flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-black">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
        <div class="flex-1">
            <h2 class="font-black text-[13px] uppercase tracking-widest text-gray-900">@yield('title', 'Dashboard')</h2>
            @hasSection('breadcrumb')
                <p class="text-[10px] text-gray-400 tracking-wider mt-0.5">@yield('breadcrumb')</p>
            @endif
        </div>
        <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
           class="text-[10px] font-bold text-gray-500 hover:text-gold tracking-widest uppercase border border-gray-200 px-2.5 py-1.5 rounded">
            {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
        </a>
        <div class="flex items-center gap-3 text-[10px] text-gray-500 tracking-wider">
            <span class="material-symbols-outlined text-[16px]">manage_accounts</span>
            <span class="hidden sm:inline uppercase">{{ __('admin.administrator') }}</span>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="mx-4 md:mx-8 mt-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-[11px] tracking-wider">
        <span class="material-symbols-outlined text-base text-green-600">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mx-4 md:mx-8 mt-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-[11px] tracking-wider">
        <span class="material-symbols-outlined text-base text-red-600">error</span>
        {{ session('error') }}
    </div>
    @endif

    {{-- Content --}}
    <main class="flex-1 px-4 md:px-8 py-6">
        @yield('content')
    </main>

</div>

<script>
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebarOverlay');
    const closedClass = document.documentElement.dir === 'rtl' ? 'translate-x-full' : '-translate-x-full';
    const open = s.classList.toggle(closedClass);
    o.classList.toggle('hidden', open);
}
function closeSidebar() {
    const closedClass = document.documentElement.dir === 'rtl' ? 'translate-x-full' : '-translate-x-full';
    document.getElementById('sidebar').classList.add(closedClass);
    document.getElementById('sidebarOverlay').classList.add('hidden');
}
</script>
@stack('scripts')
</body>
</html>
