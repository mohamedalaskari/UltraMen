@extends('admin.layouts.admin')
@section('title', __('admin_shipping.title'))
@section('breadcrumb', __('admin_shipping.breadcrumb'))

@section('content')

{{-- ── Shipping Zones ───────────────────────────────────────────────────────── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-[13px] font-bold text-gray-900 uppercase tracking-wider">{{ __('admin_shipping.shipping_zones') }}</h3>
        <p class="text-[11px] text-gray-400 mt-0.5">{{ __('admin_shipping.shipping_zones_hint') }}</p>
    </div>
    <button type="button" onclick="openZoneModal()"
            class="inline-flex items-center gap-2 bg-black text-white px-5 py-2.5
                   font-bold text-[10px] tracking-[.15em] uppercase hover:bg-[#775a19] transition-colors">
        <span class="material-symbols-outlined text-base">add</span> {{ __('admin_shipping.add_zone') }}
    </button>
</div>

<div class="bg-white border border-gray-200 overflow-hidden mb-10">
    <div class="overflow-x-auto">
        <table class="w-full text-[11px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_shipping.zone') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_shipping.standard') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_shipping.express') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden sm:table-cell">{{ __('admin_shipping.status') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($zones as $zone)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <p class="font-bold text-gray-900">{{ $zone->name }}</p>
                        <p class="text-gray-400 text-[10px] sm:hidden mt-0.5">{{ $zone->is_active ? __('admin_shipping.active') : __('admin_shipping.inactive') }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-700">
                        ${{ number_format($zone->standard_price, 2) }}
                        <span class="text-gray-400">· {{ $zone->standard_days_label }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-700">
                        ${{ number_format($zone->express_price, 2) }}
                        <span class="text-gray-400">· {{ $zone->express_days_label }}</span>
                    </td>
                    <td class="px-4 py-3 hidden sm:table-cell">
                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider
                                     {{ $zone->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $zone->is_active ? __('admin_shipping.active') : __('admin_shipping.inactive') }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1">
                            <button type="button"
                                    onclick='openZoneModal(@json($zone))'
                                    class="p-1.5 text-gray-400 hover:text-black transition-colors" title="{{ __('admin_products.edit') }}">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.shipping.zones.destroy', $zone) }}"
                                  onsubmit="return confirm('{{ addslashes(__('admin_shipping.delete_zone_confirm', ['name' => $zone->name])) }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="{{ __('admin_products.delete') }}">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-gray-400 text-[11px] tracking-wider">
                        {{ __('admin_shipping.no_zones_yet') }}
                        <button type="button" onclick="openZoneModal()" class="text-[#775a19] hover:underline ms-1">{{ __('admin_shipping.add_first_one') }}</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Tax Settings ─────────────────────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-6 max-w-xl">
    <h3 class="text-[13px] font-bold text-gray-900 uppercase tracking-wider">{{ __('admin_shipping.tax') }}</h3>
    <p class="text-[11px] text-gray-400 mt-0.5 mb-5">{{ __('admin_shipping.tax_hint') }}</p>

    <form method="POST" action="{{ route('admin.shipping.tax.update') }}" class="space-y-4">
        @csrf

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="tax_enabled" value="1" {{ $taxEnabled ? 'checked' : '' }}
                   class="w-4 h-4 accent-[#775a19]"/>
            <span class="text-[12px] font-semibold text-gray-700">{{ __('admin_shipping.enable_tax') }}</span>
        </label>

        <div>
            <label class="admin-label">{{ __('admin_shipping.tax_rate') }}</label>
            <input type="number" name="tax_rate" value="{{ old('tax_rate', $taxRate) }}"
                   step="0.01" min="0" max="100" class="admin-input max-w-[160px]"/>
            @error('tax_rate')<p class="admin-error">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="bg-black hover:bg-[#775a19] text-white font-bold
                       text-[10px] tracking-[.2em] uppercase px-6 py-3 transition-colors">
            {{ __('admin_shipping.save_tax_settings') }}
        </button>
    </form>
</div>

{{-- ── Add/Edit Zone Modal ──────────────────────────────────────────────────── --}}
<div id="zoneModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60" onclick="closeZoneModal()"></div>
    <div class="relative bg-white w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 id="zoneModalTitle" class="text-[11px] font-bold uppercase tracking-widest">{{ __('admin_shipping.add_zone_title') }}</h3>
            <button onclick="closeZoneModal()" class="text-gray-400 hover:text-black">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="zoneForm" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="zoneMethod" value="POST"/>

            <div>
                <label class="admin-label">{{ __('admin_shipping.zone_name') }}</label>
                <input type="text" name="name" id="zoneName" required class="admin-input" placeholder="{{ __('admin_shipping.zone_name_placeholder') }}"/>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="admin-label">{{ __('admin_shipping.standard_price') }}</label>
                    <input type="number" name="standard_price" id="zoneStandardPrice" required step="0.01" min="0" class="admin-input"/>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="admin-label">{{ __('admin_shipping.days_min') }}</label>
                        <input type="number" name="standard_days_min" id="zoneStandardDaysMin" required min="0" class="admin-input"/>
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_shipping.days_max') }}</label>
                        <input type="number" name="standard_days_max" id="zoneStandardDaysMax" required min="0" class="admin-input"/>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="admin-label">{{ __('admin_shipping.express_price') }}</label>
                    <input type="number" name="express_price" id="zoneExpressPrice" required step="0.01" min="0" class="admin-input"/>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="admin-label">{{ __('admin_shipping.days_min') }}</label>
                        <input type="number" name="express_days_min" id="zoneExpressDaysMin" required min="0" class="admin-input"/>
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_shipping.days_max') }}</label>
                        <input type="number" name="express_days_max" id="zoneExpressDaysMax" required min="0" class="admin-input"/>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 items-end">
                <div>
                    <label class="admin-label">{{ __('admin_shipping.sort_order') }}</label>
                    <input type="number" name="sort_order" id="zoneSortOrder" min="0" value="0" class="admin-input"/>
                </div>
                <label class="flex items-center gap-2 cursor-pointer pb-2">
                    <input type="checkbox" name="is_active" id="zoneIsActive" value="1" checked class="w-4 h-4 accent-[#775a19]"/>
                    <span class="text-[12px] font-semibold text-gray-700">{{ __('admin_shipping.active') }}</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-black hover:bg-[#775a19] text-white font-bold
                           text-[10px] tracking-[.2em] uppercase py-3.5 transition-colors">
                {{ __('admin_shipping.save_zone') }}
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
const __i18n = {
    addZone: @json(__('admin_shipping.add_zone_title')),
    editZone: @json(__('admin_shipping.edit_zone_title')),
};

function openZoneModal(zone = null) {
    const form = document.getElementById('zoneForm');

    if (zone) {
        document.getElementById('zoneModalTitle').textContent = __i18n.editZone;
        form.action = '/admin/shipping/zones/' + zone.id;
        document.getElementById('zoneMethod').value = 'PUT';
        document.getElementById('zoneName').value             = zone.name;
        document.getElementById('zoneStandardPrice').value    = zone.standard_price;
        document.getElementById('zoneStandardDaysMin').value  = zone.standard_days_min;
        document.getElementById('zoneStandardDaysMax').value  = zone.standard_days_max;
        document.getElementById('zoneExpressPrice').value     = zone.express_price;
        document.getElementById('zoneExpressDaysMin').value   = zone.express_days_min;
        document.getElementById('zoneExpressDaysMax').value   = zone.express_days_max;
        document.getElementById('zoneSortOrder').value        = zone.sort_order;
        document.getElementById('zoneIsActive').checked       = !!zone.is_active;
    } else {
        document.getElementById('zoneModalTitle').textContent = __i18n.addZone;
        form.action = '{{ route('admin.shipping.zones.store') }}';
        document.getElementById('zoneMethod').value = 'POST';
        form.reset();
        document.getElementById('zoneIsActive').checked = true;
    }

    const modal = document.getElementById('zoneModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeZoneModal() {
    const modal = document.getElementById('zoneModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush

<style>
.admin-label { display:block; font-size:10px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:6px; }
.admin-input { display:block; width:100%; border:1px solid #e5e7eb; padding:8px 12px; font-size:12px; font-family:'Montserrat',sans-serif; color:#111827; background:white; outline:none; border-radius:0; }
.admin-input:focus { border-color:#775a19; box-shadow:none; }
.admin-error { color:#dc2626; font-size:10px; margin-top:4px; letter-spacing:.05em; }
</style>

@endsection
