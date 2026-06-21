@extends('admin.layouts.admin')
@section('title', __('admin_orders.title'))
@section('breadcrumb', __('admin_orders.breadcrumb'))

@section('content')

{{-- ── Filters ──────────────────────────────────────────────────────────────── --}}
<div class="flex flex-col sm:flex-row gap-3 mb-4">
    <div class="relative flex-1">
        <span class="absolute start-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-[18px]">search</span>
        <input type="text" id="orderSearchInput" value="{{ request('search') }}"
               placeholder="{{ __('admin_orders.search_placeholder') }}"
               autocomplete="off"
               class="w-full border border-gray-300 ps-10 pe-10 py-2.5 text-[12px] focus:border-[#775a19] focus:outline-none font-sans"/>
        <div id="orderSearchSpinner"
             class="hidden absolute end-3 top-1/2 -translate-y-1/2 w-4 h-4
                    border border-[#775a19] border-t-transparent rounded-full animate-spin">
        </div>
    </div>
    <select id="orderStatusSelect"
            class="border border-gray-300 px-4 py-2.5 text-[11px] uppercase tracking-wider font-sans focus:border-[#775a19] focus:outline-none bg-white">
        <option value="">{{ __('admin_orders.all_statuses') }}</option>
        @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
            {{ __('order_status.' . $s) }}
        </option>
        @endforeach
    </select>
    <button type="button" id="orderClearBtn"
            onclick="clearOrderFilters()"
            class="{{ request()->hasAny(['search','status']) ? '' : 'hidden' }} flex items-center justify-center px-4 py-2.5 border border-gray-300 text-[10px] tracking-wider uppercase hover:border-black transition-colors">
        {{ __('admin_orders.clear') }}
    </button>
</div>

{{-- ── Table (AJAX-refreshed, includes result count) ───────────────────────── --}}
<div id="ordersTable" class="transition-opacity duration-200">
    @include('admin.orders.partials.orders-table', compact('orders'))
</div>

@endsection

@push('scripts')
<script>
let orderFilters = {
    search: '{{ addslashes(request('search', '')) }}',
    status: '{{ request('status', '') }}',
};

async function applyOrderFilters(overrides = {}, page = '') {
    Object.assign(orderFilters, overrides);
    if (page !== undefined) orderFilters.page = page;

    const params = new URLSearchParams();
    Object.entries(orderFilters).forEach(([k, v]) => { if (v) params.set(k, v); });

    history.pushState(null, '', '{{ route('admin.orders.index') }}?' + params.toString());

    const table = document.getElementById('ordersTable');
    table.style.opacity = '0.4';

    const res  = await fetch('{{ route('admin.orders.index') }}?' + params.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const html = await res.text();

    table.innerHTML   = html;
    table.style.opacity = '1';

    updateOrderClearButton();
}

function updateOrderClearButton() {
    const hasFilters = !!(orderFilters.search || orderFilters.status);
    document.getElementById('orderClearBtn').classList.toggle('hidden', !hasFilters);
}

function clearOrderFilters() {
    orderFilters = { search: '', status: '' };
    document.getElementById('orderSearchInput').value = '';
    document.getElementById('orderStatusSelect').value = '';
    applyOrderFilters({}, '');
}

// ── Real-time debounced search ─────────────────────────────────────────────────
let orderSearchTimer;
document.getElementById('orderSearchInput').addEventListener('input', function () {
    clearTimeout(orderSearchTimer);
    const spinner = document.getElementById('orderSearchSpinner');
    spinner.classList.remove('hidden');
    orderSearchTimer = setTimeout(() => {
        applyOrderFilters({ search: this.value.trim(), page: '' })
            .then(() => spinner.classList.add('hidden'));
    }, 400);
});

// ── Status filter ────────────────────────────────────────────────────────────
document.getElementById('orderStatusSelect').addEventListener('change', function () {
    applyOrderFilters({ status: this.value, page: '' });
});

// ── Pagination (delegated) ───────────────────────────────────────────────────
document.getElementById('ordersTable').addEventListener('click', e => {
    const btn = e.target.closest('.paginate-btn');
    if (btn) applyOrderFilters({}, btn.dataset.page);
});
</script>
@endpush
