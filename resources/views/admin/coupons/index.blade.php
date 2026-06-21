@extends('admin.layouts.admin')
@section('title', __('admin_coupons.title'))
@section('breadcrumb', __('admin_coupons.breadcrumb'))

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <p class="text-[11px] text-gray-500 tracking-wider">{{ trans_choice('admin_coupons.coupons_total', $coupons->total(), ['count' => $coupons->total()]) }}</p>
    <button type="button" onclick="openCouponModal()"
            class="inline-flex items-center gap-2 bg-black text-white px-5 py-2.5
                   font-bold text-[10px] tracking-[.15em] uppercase hover:bg-[#775a19] transition-colors">
        <span class="material-symbols-outlined text-base">add</span> {{ __('admin_coupons.add_coupon') }}
    </button>
</div>

<div class="bg-white border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-[11px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_coupons.code') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_coupons.discount') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden sm:table-cell">{{ __('admin_coupons.min_order') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden sm:table-cell">{{ __('admin_coupons.usage') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden md:table-cell">{{ __('admin_coupons.expires') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_coupons.status') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <p class="font-black text-gray-900 tracking-wider">{{ $coupon->code }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-700">
                        @if($coupon->type === 'percentage')
                            {{ rtrim(rtrim(number_format($coupon->value, 2), '0'), '.') }}% {{ __('admin_coupons.off') }}
                        @else
                            ${{ number_format($coupon->value, 2) }} {{ __('admin_coupons.off') }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 hidden sm:table-cell">
                        {{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : '—' }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 hidden sm:table-cell">
                        {{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 hidden md:table-cell">
                        {{ $coupon->expires_at?->format('M d, Y') ?? '—' }}
                    </td>
                    <td class="px-4 py-3">
                        @php
                        $statusColors = [
                            'Active'         => 'bg-green-100 text-green-700',
                            'Inactive'       => 'bg-gray-100 text-gray-500',
                            'Expired'        => 'bg-red-100 text-red-600',
                            'Limit Reached'  => 'bg-amber-100 text-amber-700',
                        ];
                        $statusLangKeys = [
                            'Active'         => 'admin_coupons.status_active',
                            'Inactive'       => 'admin_coupons.status_inactive',
                            'Expired'        => 'admin_coupons.status_expired',
                            'Limit Reached'  => 'admin_coupons.status_limit_reached',
                        ];
                        @endphp
                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider {{ $statusColors[$coupon->status_label] }}">
                            {{ __($statusLangKeys[$coupon->status_label]) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1">
                            <button type="button"
                                    onclick='openCouponModal(@json($coupon))'
                                    class="p-1.5 text-gray-400 hover:text-black transition-colors" title="{{ __('admin_products.edit') }}">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}"
                                  onsubmit="return confirm('{{ addslashes(__('admin_coupons.delete_confirm', ['code' => $coupon->code])) }}')">
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
                    <td colspan="7" class="px-4 py-12 text-center text-gray-400 text-[11px] tracking-wider">
                        {{ __('admin_coupons.no_coupons_yet') }}
                        <button type="button" onclick="openCouponModal()" class="text-[#775a19] hover:underline ms-1">{{ __('admin_coupons.add_first_one') }}</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($coupons->hasPages())
    <div class="px-4 py-4 border-t border-gray-100">
        {{ $coupons->links() }}
    </div>
    @endif
</div>

{{-- ── Add/Edit Coupon Modal ────────────────────────────────────────────────── --}}
<div id="couponModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60" onclick="closeCouponModal()"></div>
    <div class="relative bg-white w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 id="couponModalTitle" class="text-[11px] font-bold uppercase tracking-widest">{{ __('admin_coupons.add_coupon_title') }}</h3>
            <button onclick="closeCouponModal()" class="text-gray-400 hover:text-black">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="couponForm" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="couponMethod" value="POST"/>

            <div>
                <label class="admin-label">{{ __('admin_coupons.coupon_code') }}</label>
                <input type="text" name="code" id="couponCode" required maxlength="50" class="admin-input uppercase" placeholder="{{ __('admin_coupons.coupon_code_placeholder') }}"/>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="admin-label">{{ __('admin_coupons.discount_type') }}</label>
                    <select name="type" id="couponType" required class="admin-input" onchange="onCouponTypeChange()">
                        <option value="fixed">{{ __('admin_coupons.fixed_amount') }}</option>
                        <option value="percentage">{{ __('admin_coupons.percentage') }}</option>
                    </select>
                </div>
                <div>
                    <label class="admin-label" id="couponValueLabel">{{ __('admin_coupons.value_dollar') }}</label>
                    <input type="number" name="value" id="couponValue" required step="0.01" min="0.01" class="admin-input"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="admin-label">{{ __('admin_coupons.min_order_amount') }} <span class="text-gray-400 font-normal">{{ __('admin_coupons.optional') }}</span></label>
                    <input type="number" name="min_order_amount" id="couponMinOrder" step="0.01" min="0" class="admin-input"/>
                </div>
                <div>
                    <label class="admin-label">{{ __('admin_coupons.max_uses') }} <span class="text-gray-400 font-normal">{{ __('admin_coupons.optional') }}</span></label>
                    <input type="number" name="max_uses" id="couponMaxUses" min="1" class="admin-input" placeholder="{{ __('admin_coupons.unlimited') }}"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 items-end">
                <div>
                    <label class="admin-label">{{ __('admin_coupons.expires_on') }} <span class="text-gray-400 font-normal">{{ __('admin_coupons.optional') }}</span></label>
                    <input type="date" name="expires_at" id="couponExpiresAt" class="admin-input"/>
                </div>
                <label class="flex items-center gap-2 cursor-pointer pb-2">
                    <input type="checkbox" name="is_active" id="couponIsActive" value="1" checked class="w-4 h-4 accent-[#775a19]"/>
                    <span class="text-[12px] font-semibold text-gray-700">{{ __('admin_coupons.active') }}</span>
                </label>
            </div>

            <div id="couponUsedCountInfo" class="hidden text-[10px] text-gray-400"></div>

            <button type="submit"
                    class="w-full bg-black hover:bg-[#775a19] text-white font-bold
                           text-[10px] tracking-[.2em] uppercase py-3.5 transition-colors">
                {{ __('admin_coupons.save_coupon') }}
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
const __i18n = {
    addCoupon: @json(__('admin_coupons.add_coupon_title')),
    editCoupon: @json(__('admin_coupons.edit_coupon_title')),
    valueDollar: @json(__('admin_coupons.value_dollar')),
    valuePercent: @json(__('admin_coupons.value_percent')),
    usedOnce: @json(trans_choice('admin_coupons.used_times', 1, ['count' => 1])),
    usedMany: function(n) { return @json(trans_choice('admin_coupons.used_times', 2, ['count' => '__N__'])).replace('__N__', n); },
};

function onCouponTypeChange() {
    const type = document.getElementById('couponType').value;
    const valueInput = document.getElementById('couponValue');
    const valueLabel = document.getElementById('couponValueLabel');

    if (type === 'percentage') {
        valueLabel.textContent = __i18n.valuePercent;
        valueInput.max = 100;
    } else {
        valueLabel.textContent = __i18n.valueDollar;
        valueInput.removeAttribute('max');
    }
}

function openCouponModal(coupon = null) {
    const form = document.getElementById('couponForm');

    if (coupon) {
        document.getElementById('couponModalTitle').textContent = __i18n.editCoupon;
        form.action = '/admin/coupons/' + coupon.id;
        document.getElementById('couponMethod').value = 'PUT';
        document.getElementById('couponCode').value         = coupon.code;
        document.getElementById('couponType').value         = coupon.type;
        document.getElementById('couponValue').value        = coupon.value;
        document.getElementById('couponMinOrder').value     = coupon.min_order_amount ?? '';
        document.getElementById('couponMaxUses').value      = coupon.max_uses ?? '';
        document.getElementById('couponExpiresAt').value    = coupon.expires_at ? coupon.expires_at.substring(0, 10) : '';
        document.getElementById('couponIsActive').checked   = !!coupon.is_active;

        const usedInfo = document.getElementById('couponUsedCountInfo');
        usedInfo.textContent = coupon.used_count === 1 ? __i18n.usedOnce : __i18n.usedMany(coupon.used_count);
        usedInfo.classList.remove('hidden');
    } else {
        document.getElementById('couponModalTitle').textContent = __i18n.addCoupon;
        form.action = '{{ route('admin.coupons.store') }}';
        document.getElementById('couponMethod').value = 'POST';
        form.reset();
        document.getElementById('couponIsActive').checked = true;
        document.getElementById('couponUsedCountInfo').classList.add('hidden');
    }

    onCouponTypeChange();

    const modal = document.getElementById('couponModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCouponModal() {
    const modal = document.getElementById('couponModal');
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
