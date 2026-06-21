@extends('layouts.app')

@section('title', 'ULTRA | ' . __('collections.title'))

@section('content')

@php $activeFilterCount = count(array_filter([request('category'), request('search'), request('min_price'), request('max_price'), request('label')])); @endphp

{{-- ── Mobile Filter Backdrop ──────────────────────────────────────────────────── --}}
<div id="filterBackdrop"
     class="hidden fixed inset-0 bg-black/60 z-40"
     onclick="closeFilterDrawer()">
</div>

<main class="pt-24 md:pt-32 pb-16 md:pb-24 max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop">

    {{-- ── Page Header ──────────────────────────────────────────────────────── --}}
    <section class="mb-6 md:mb-8 border-b border-outline-variant pb-6 md:pb-8">

        {{-- Row 1: Title + mobile filter btn --}}
        <div class="flex items-start justify-between gap-4 mb-5 md:mb-0">
            <div>
                <span class="font-label-sm text-[9px] md:text-label-sm text-secondary block mb-1 md:mb-2 tracking-widest">{{ __('collections.curated_gallery') }}</span>
                <h1 class="font-headline-lg text-[22px] md:text-headline-lg text-primary uppercase tracking-wider leading-tight">
                    {{ __('collections.title') }}
                    <span class="text-outline font-normal text-[14px] md:text-body-lg ms-1" id="totalCount">({{ $products->total() }})</span>
                </h1>
            </div>

            {{-- Mobile filter button (top-right) --}}
            <button type="button" onclick="openFilterDrawer()"
                    class="md:hidden flex-shrink-0 flex items-center gap-2 border border-outline-variant px-3 py-2 hover:border-primary transition-colors mt-1">
                <span class="material-symbols-outlined text-[16px] text-primary">tune</span>
                <span class="font-label-sm text-[9px] tracking-widest text-primary">{{ __('collections.filters') }}</span>
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-secondary text-on-secondary font-label-sm text-[9px] flex items-center justify-center">
                        {{ $activeFilterCount }}
                    </span>
                @endif
            </button>
        </div>

        {{-- Row 2: Search + Sort (desktop: part of flex row) --}}
        <div class="flex items-center gap-4 flex-wrap md:justify-end">

            {{-- Search --}}
            <div class="relative flex-1 md:flex-none">
                <span class="absolute start-0 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">search</span>
                <input type="text" id="searchInput"
                       value="{{ request('search') }}"
                       placeholder="{{ __('collections.search_products') }}"
                       autocomplete="off"
                       class="bg-transparent border-b border-outline focus:border-secondary focus:ring-0
                              font-label-sm text-[10px] md:text-label-sm text-primary placeholder:text-outline/40
                              ps-7 pe-8 py-2 w-full md:w-44 lg:w-52 transition-all md:focus:w-64"/>
                <div id="searchSpinner"
                     class="hidden absolute end-0 top-1/2 -translate-y-1/2 w-4 h-4
                            border border-secondary border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            {{-- Sort Dropdown --}}
            <div class="relative flex-shrink-0" id="sortDropdown">
                <button type="button" onclick="toggleSortDropdown()"
                        class="flex items-center gap-2 md:gap-3">
                    <span class="font-label-sm text-[9px] md:text-[10px] text-on-surface-variant tracking-widest hidden sm:inline">{{ __('collections.sort_by') }}</span>
                    <div class="flex items-center gap-1.5 md:gap-2 border-b border-primary pb-1.5 min-w-[110px] md:min-w-[140px] justify-between">
                        <span class="font-label-sm text-[10px] md:text-label-sm text-primary tracking-widest" id="sortLabel">
                            {{ strtoupper($sortOptions[request('sort', 'default')]) }}
                        </span>
                        <span class="material-symbols-outlined text-sm text-primary transition-transform duration-200" id="sortArrow">
                            expand_more
                        </span>
                    </div>
                </button>
                <div id="sortPanel"
                     class="hidden absolute end-0 top-full mt-1 w-52 md:w-56 bg-surface border border-outline-variant z-50
                            shadow-[0_8px_40px_rgba(0,0,0,0.12)]">
                    @foreach($sortOptions as $value => $label)
                    <button type="button"
                            onclick="selectSort('{{ $value }}', '{{ strtoupper($label) }}')"
                            class="sort-option w-full flex items-center justify-between px-5 md:px-6 py-3.5 md:py-4 text-start
                                   font-label-sm text-[10px] md:text-[11px] tracking-widest transition-colors
                                   hover:bg-surface-container-low
                                   {{ request('sort', 'default') === $value ? 'text-secondary' : 'text-primary' }}">
                        {{ strtoupper($label) }}
                        <span class="material-symbols-outlined text-sm {{ request('sort', 'default') === $value ? 'opacity-100' : 'opacity-0' }}">check</span>
                    </button>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ── Quick Filter Pills ────────────────────────────────────────────────── --}}
    @if(count($filters['labels']) > 0)
    <div class="flex items-center gap-2 md:gap-3 mb-6 md:mb-8 pb-5 md:pb-6 border-b border-surface-container overflow-x-auto no-scrollbar">
        <span class="font-label-sm text-[9px] text-on-surface-variant tracking-widest flex-shrink-0 whitespace-nowrap hidden sm:inline">{{ __('collections.quick_filter') }}</span>
        <button type="button"
                data-label-key=""
                onclick="toggleLabelFilter('')"
                class="quick-label-pill flex-shrink-0 flex items-center gap-1.5 px-4 py-2
                       font-label-sm text-[9px] tracking-widest border transition-colors whitespace-nowrap
                       {{ !request('label') ? 'bg-primary text-on-primary border-primary' : 'border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary' }}">
            <span class="material-symbols-outlined text-[13px]">apps</span>
            {{ __('collections.all') }}
        </button>
        @foreach($filters['labels'] as $lbl)
        <button type="button"
                data-label-key="{{ $lbl['key'] }}"
                onclick="toggleLabelFilter('{{ $lbl['key'] }}')"
                class="quick-label-pill flex-shrink-0 flex items-center gap-1.5 px-4 py-2
                       font-label-sm text-[9px] tracking-widest border transition-colors whitespace-nowrap
                       {{ request('label') === $lbl['key'] ? 'bg-primary text-on-primary border-primary' : 'border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary' }}">
            <span class="material-symbols-outlined text-[13px]">{{ $lbl['icon'] }}</span>
            {{ strtoupper($lbl['label']) }}
            <span class="opacity-50">({{ $lbl['count'] }})</span>
        </button>
        @endforeach
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-start">

        {{-- ── Sidebar ──────────────────────────────────────────────────────── --}}
        <aside id="filterSidebar"
               class="fixed inset-y-0 start-0 z-50 w-[85vw] max-w-xs bg-surface overflow-y-auto p-6
                      {{ app()->getLocale() === 'ar' ? 'translate-x-full' : '-translate-x-full' }} transition-transform duration-300
                      md:static md:translate-x-0 md:w-52 md:flex-shrink-0 md:p-0 md:bg-transparent md:overflow-visible md:max-w-none">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-label-sm text-label-sm text-primary tracking-widest">{{ __('collections.filters') }}</h3>
                <div class="flex items-center gap-3">
                    <span id="filterBadge"
                          class="{{ $activeFilterCount > 0 ? '' : 'hidden' }}
                                 w-5 h-5 rounded-full bg-secondary text-on-secondary font-label-sm text-[10px]
                                 flex items-center justify-center">
                        {{ $activeFilterCount }}
                    </span>
                    <button type="button" onclick="closeFilterDrawer()"
                            class="md:hidden text-outline hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">close</span>
                    </button>
                </div>
            </div>

            {{-- CATEGORY ──────────────────────────────────────────────────── --}}
            <div class="mb-10">
                <h4 class="font-label-sm text-[10px] text-on-surface-variant mb-4 tracking-widest">{{ __('collections.category') }}</h4>
                <div class="space-y-0.5">
                    <button type="button" onclick="applyFilters({category:'',page:''})"
                            class="filter-pill category-pill w-full text-start {{ !request('category') ? 'active' : '' }}"
                            data-category="">
                        <span>{{ __('collections.all_categories') }}</span>
                        <span class="ms-auto text-[9px] text-outline opacity-50">{{ array_sum(array_column($filters['categories'], 'count')) }}</span>
                    </button>
                    @foreach($filters['categories'] as $cat)
                    <button type="button" onclick="applyFilters({category:'{{ $cat['slug'] }}',page:''})"
                            class="filter-pill category-pill w-full text-start {{ request('category') === $cat['slug'] ? 'active' : '' }}"
                            data-category="{{ $cat['slug'] }}">
                        <span>{{ $cat['name'] }}</span>
                        <span class="ms-auto text-[9px] text-outline opacity-50">{{ $cat['count'] }}</span>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- LABELS ─────────────────────────────────────────────────────── --}}
            @if(count($filters['labels']) > 0)
            <div class="mb-10">
                <h4 class="font-label-sm text-[10px] text-on-surface-variant mb-4 tracking-widest">{{ __('collections.collection') }}</h4>
                <div class="space-y-0.5">
                    <button type="button" onclick="toggleLabelFilter('')"
                            class="filter-pill label-pill w-full text-start {{ !request('label') ? 'active' : '' }}"
                            data-label-key="">
                        <span class="material-symbols-outlined text-[14px] opacity-40">layers</span>
                        <span>{{ __('collections.all_collections') }}</span>
                    </button>
                    @foreach($filters['labels'] as $lbl)
                    <button type="button"
                            onclick="toggleLabelFilter('{{ $lbl['key'] }}')"
                            class="filter-pill label-pill w-full text-start {{ request('label') === $lbl['key'] ? 'active' : '' }}"
                            data-label-key="{{ $lbl['key'] }}">
                        <span class="material-symbols-outlined text-[14px]">{{ $lbl['icon'] }}</span>
                        <span>{{ $lbl['label'] }}</span>
                        <span class="ms-auto text-[9px] text-outline opacity-50">{{ $lbl['count'] }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- PRICE ────────────────────────────────────────────────────── --}}
            <div class="mb-10">
                <h4 class="font-label-sm text-[10px] text-on-surface-variant mb-4 tracking-widest">{{ __('collections.price_range') }}</h4>
                <div class="space-y-4">
                    <input type="range" id="priceSlider"
                           min="{{ $filters['price_min'] }}" max="{{ $filters['price_max'] }}" step="50"
                           value="{{ request('max_price', $filters['price_max']) }}"
                           class="w-full h-px bg-outline-variant appearance-none cursor-pointer accent-secondary"/>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 border-b border-outline">
                            <input type="number" id="minPriceInput"
                                   placeholder="{{ __('collections.min') }}"
                                   value="{{ request('min_price') }}"
                                   class="w-full bg-transparent border-none focus:ring-0 font-body-md text-xs text-primary py-1 px-0 placeholder:text-outline/50"/>
                        </div>
                        <span class="text-outline text-xs">—</span>
                        <div class="flex-1 border-b border-outline">
                            <input type="number" id="maxPriceInput"
                                   placeholder="{{ __('collections.max') }}"
                                   value="{{ request('max_price') }}"
                                   class="w-full bg-transparent border-none focus:ring-0 font-body-md text-xs text-primary py-1 px-0 placeholder:text-outline/50"/>
                        </div>
                    </div>
                    <button type="button" onclick="applyPriceFilter()"
                            class="w-full py-2.5 border border-primary font-label-sm text-[10px] tracking-widest
                                   text-primary hover:bg-primary hover:text-on-primary transition-colors">
                        {{ __('collections.apply_price') }}
                    </button>
                </div>
            </div>

            {{-- Clear --}}
            <button type="button" onclick="clearFilters()"
                    id="clearBtn"
                    class="{{ $activeFilterCount > 0 ? '' : 'hidden' }}
                           w-full py-2 font-label-sm text-[10px] tracking-widest text-outline
                           border border-outline-variant hover:text-primary hover:border-primary transition-colors">
                {{ __('collections.clear_all') }}
            </button>

        </aside>

        {{-- ── Products Grid ─────────────────────────────────────────────── --}}
        <div class="flex-grow min-w-0 transition-opacity duration-300" id="collectionsGrid">
            @include('pages.partials.collections-grid', compact('products'))
        </div>

    </div>
</main>

@endsection

@push('styles')
<style>
.filter-pill {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.45rem 0.75rem;
    font-size: 11px; font-family: 'Montserrat', sans-serif;
    letter-spacing: 0.1em; text-transform: uppercase;
    cursor: pointer; transition: all 0.2s;
    color: #444748; border-inline-start: 2px solid transparent;
}
.filter-pill:hover  { color: #000; border-inline-start-color: #775a19; background: rgba(245,243,243,0.6); }
.filter-pill.active { color: #000; font-weight: 700; border-inline-start-color: #775a19; background: rgba(245,243,243,0.6); }

#sortPanel button:not(:last-child) { border-bottom: 1px solid #c4c7c7; }

#filterSidebar.open { transform: translateX(0) !important; }

.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.no-scrollbar::-webkit-scrollbar { display: none; }

@media (max-width: 767px) {
    /* Ensure sort panel doesn't clip off-screen on mobile */
    #sortPanel { inset-inline-end: 0; inset-inline-start: auto; max-width: calc(100vw - 2rem); }
}
</style>
@endpush

@push('scripts')
<script>
// ── State ──────────────────────────────────────────────────────────────────────
let filters = {
    search:    '{{ addslashes(request('search', '')) }}',
    category:  '{{ addslashes(request('category', '')) }}',
    min_price: '{{ request('min_price', '') }}',
    max_price: '{{ request('max_price', '') }}',
    label:     '{{ request('label', '') }}',
    sort:      '{{ request('sort', 'default') }}',
};

// ── AJAX core ──────────────────────────────────────────────────────────────────
async function applyFilters(overrides = {}, page = '') {
    Object.assign(filters, overrides);
    if (page !== undefined) filters.page = page;

    const params = new URLSearchParams();
    Object.entries(filters).forEach(([k, v]) => { if (v) params.set(k, v); });

    history.pushState(null, '', '/collections?' + params.toString());

    const grid = document.getElementById('collectionsGrid');
    grid.style.opacity = '0.3';
    grid.style.pointerEvents = 'none';

    const res  = await fetch('/collections?' + params.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const html = await res.text();

    grid.innerHTML = html;
    grid.style.opacity = '1';
    grid.style.pointerEvents = '';

    updateSidebarState();
    closeFilterDrawer();
}

function toggleLabelFilter(key) {
    applyFilters({ label: filters.label === key ? '' : key, page: '' });
}

function removeFilter(key) {
    applyFilters({ [key]: '' }, '');
}

function clearFilters() {
    filters = { search: '', category: '', min_price: '', max_price: '', label: '', sort: filters.sort };
    document.getElementById('searchInput').value  = '';
    document.getElementById('minPriceInput').value = '';
    document.getElementById('maxPriceInput').value = '';
    applyFilters({}, '');
}

// ── Search (debounced 400ms) ───────────────────────────────────────────────────
let searchTimer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(searchTimer);
    const spinner = document.getElementById('searchSpinner');
    spinner.classList.remove('hidden');
    searchTimer = setTimeout(() => {
        applyFilters({ search: this.value.trim(), page: '' })
            .then(() => spinner.classList.add('hidden'));
    }, 400);
});

// ── Price range ────────────────────────────────────────────────────────────────
const slider = document.getElementById('priceSlider');
slider.addEventListener('input', () => {
    document.getElementById('maxPriceInput').value = slider.value;
});

function applyPriceFilter() {
    const min = document.getElementById('minPriceInput').value;
    const max = document.getElementById('maxPriceInput').value;
    applyFilters({ min_price: min, max_price: max, page: '' });
}

// ── Sort dropdown ──────────────────────────────────────────────────────────────
function toggleSortDropdown() {
    const panel = document.getElementById('sortPanel');
    const arrow = document.getElementById('sortArrow');
    const nowHidden = panel.classList.toggle('hidden');
    arrow.style.transform = nowHidden ? 'rotate(0deg)' : 'rotate(180deg)';
}

function selectSort(value, label) {
    document.getElementById('sortLabel').textContent = label;
    document.getElementById('sortPanel').classList.add('hidden');
    document.getElementById('sortArrow').style.transform = 'rotate(0deg)';
    document.querySelectorAll('.sort-option').forEach(btn => {
        const check = btn.querySelector('.material-symbols-outlined');
        const match = btn.textContent.trim().startsWith(label);
        btn.classList.toggle('text-secondary', match);
        btn.classList.toggle('text-primary', !match);
        check.classList.toggle('opacity-100', match);
        check.classList.toggle('opacity-0', !match);
    });
    applyFilters({ sort: value });
}

document.addEventListener('click', e => {
    if (!document.getElementById('sortDropdown').contains(e.target)) {
        document.getElementById('sortPanel').classList.add('hidden');
        document.getElementById('sortArrow').style.transform = 'rotate(0deg)';
    }
});

// ── Mobile drawer ──────────────────────────────────────────────────────────────
function openFilterDrawer() {
    document.getElementById('filterSidebar').classList.add('open');
    document.getElementById('filterBackdrop').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeFilterDrawer() {
    document.getElementById('filterSidebar').classList.remove('open');
    document.getElementById('filterBackdrop').classList.add('hidden');
    document.body.style.overflow = '';
}

// ── Pagination (delegated) ─────────────────────────────────────────────────────
document.getElementById('collectionsGrid').addEventListener('click', e => {
    const btn = e.target.closest('.paginate-btn');
    if (btn) applyFilters({}, btn.dataset.page);
});

// ── Sidebar state sync after AJAX ──────────────────────────────────────────────
function updateSidebarState() {
    // Category pills
    document.querySelectorAll('.category-pill').forEach(pill => {
        const cat = pill.dataset.category;
        pill.classList.toggle('active', cat === filters.category);
    });

    // Label pills (sidebar)
    document.querySelectorAll('.label-pill').forEach(pill => {
        pill.classList.toggle('active', pill.dataset.labelKey === filters.label);
    });

    // Quick filter pills
    document.querySelectorAll('.quick-label-pill').forEach(pill => {
        const key = pill.dataset.labelKey;
        const active = key === filters.label;
        pill.classList.toggle('bg-primary', active);
        pill.classList.toggle('text-on-primary', active);
        pill.classList.toggle('border-primary', active);
        pill.classList.toggle('border-outline-variant', !active);
        pill.classList.toggle('text-on-surface-variant', !active);
    });

    // Filter badge + clear btn
    const activeCount = [filters.category, filters.search, filters.min_price, filters.max_price, filters.label]
        .filter(Boolean).length;
    const badge    = document.getElementById('filterBadge');
    const clearBtn = document.getElementById('clearBtn');
    badge.textContent = activeCount;
    badge.classList.toggle('hidden', activeCount === 0);
    clearBtn.classList.toggle('hidden', activeCount === 0);
}
</script>
@endpush
