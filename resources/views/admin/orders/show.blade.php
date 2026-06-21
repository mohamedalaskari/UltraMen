@extends('admin.layouts.admin')
@section('title', $order->order_number)
@section('breadcrumb', __('admin_orders.breadcrumb_show', ['number' => $order->order_number]))

@section('content')

<div class="max-w-4xl">

{{-- ── Header ─────────────────────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
        <p class="text-[16px] font-black text-gray-900 tracking-wide">{{ $order->order_number }}</p>
        <p class="text-[10px] text-gray-400 mt-0.5">
            {{ __('admin_orders.order_hash', ['id' => $order->id, 'date' => $order->created_at->format('M d, Y \a\t g:i A'), 'ago' => $order->created_at->diffForHumans()]) }}
        </p>
    </div>
    <div class="flex items-center gap-4 text-[11px] text-gray-500">
        <span>{{ trans_choice('admin_orders.items_count', $order->items->sum('qty'), ['count' => $order->items->sum('qty')]) }}</span>
        <span class="badge-status badge-{{ $order->status }} px-3 py-1.5">{{ strtoupper(__('order_status.' . $order->status)) }}</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Order Items ───────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        <div class="bg-white border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-[11px] font-bold uppercase tracking-widest">{{ __('admin_orders.order_items') }}</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 px-5 py-4">
                    <div class="w-12 h-14 flex-shrink-0 overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $item->image) }}"
                             alt="{{ $item->name }}"
                             class="w-full h-full object-cover"/>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-bold text-gray-900 truncate">{{ $item->name }}</p>
                        @if($item->variant)
                        <p class="text-[10px] text-gray-400">{{ $item->variant }}</p>
                        @endif
                    </div>
                    <div class="text-end flex-shrink-0">
                        <p class="text-[11px] text-gray-500">× {{ $item->qty }}</p>
                        <p class="text-[12px] font-bold text-gray-900 mt-0.5">${{ number_format($item->price * $item->qty, 2) }}</p>
                        <p class="text-[10px] text-gray-400">${{ number_format($item->price, 2) }} {{ __('admin_orders.each') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Totals --}}
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 space-y-2">
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">{{ __('admin_orders.subtotal') }}</span>
                    <span class="font-bold">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->coupon_code)
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">{{ __('admin_orders.discount') }} <span class="text-green-700 font-semibold">({{ $order->coupon_code }})</span></span>
                    <span class="text-red-600">-${{ number_format($order->discount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">
                        {{ __('admin_orders.tax') }} @if($order->subtotal > 0) ({{ number_format(($order->tax / $order->subtotal) * 100, 1) }}%) @endif
                    </span>
                    <span>${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between text-[11px]">
                    <span class="text-gray-500">
                        {{ __('admin_orders.shipping') }}
                        @if($order->shipping_zone_name)
                        <span class="text-gray-400">({{ $order->shipping_zone_name }} · {{ __('order_status.' . $order->shipping_method) ?? $order->shipping_method }})</span>
                        @endif
                    </span>
                    <span>{{ is_numeric($order->shipping) ? '$'.number_format($order->shipping, 2) : $order->shipping }}</span>
                </div>
                <div class="flex justify-between pt-2 border-t border-gray-300 text-[13px] font-black">
                    <span>{{ __('admin_orders.total') }}</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Sidebar: Customer + Status ────────────────────────────────── --}}
    <div class="space-y-5">

        {{-- Status --}}
        <div class="bg-white border border-gray-200 p-5">
            <h3 class="text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-4">{{ __('admin_orders.order_status') }}</h3>
            <div class="mb-3">
                <span class="badge-status badge-{{ $order->status }} text-[11px] px-3 py-1.5">{{ strtoupper(__('order_status.' . $order->status)) }}</span>
            </div>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="admin-input text-[11px]">
                    @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                        {{ __('order_status.' . $s) }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="w-full bg-black hover:bg-[#775a19] text-white font-bold
                               text-[10px] tracking-[.15em] uppercase py-3 transition-colors">
                    {{ __('admin_orders.update_status') }}
                </button>
            </form>
        </div>

        {{-- Customer Info --}}
        <div class="bg-white border border-gray-200 p-5">
            <h3 class="text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-4">{{ __('admin_orders.customer_info') }}</h3>
            <div class="space-y-2 text-[11px]">
                <div>
                    <span class="text-gray-400 tracking-wider">{{ __('admin_orders.name') }}</span>
                    <p class="font-bold text-gray-900 mt-0.5">{{ $order->full_name }}</p>
                </div>
                <div>
                    <span class="text-gray-400 tracking-wider">{{ __('admin_orders.email') }}</span>
                    <p class="text-gray-900 mt-0.5">{{ $order->email }}</p>
                </div>
                @if($order->phone)
                <div>
                    <span class="text-gray-400 tracking-wider">{{ __('admin_orders.phone') }}</span>
                    <p class="text-gray-900 mt-0.5">{{ $order->phone }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Shipping & Delivery --}}
        <div class="bg-white border border-gray-200 p-5">
            <h3 class="text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-4">{{ __('admin_orders.shipping_delivery') }}</h3>

            @if($order->shipping_zone_name)
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                <div>
                    <span class="text-gray-400 tracking-wider text-[10px]">{{ __('admin_orders.zone') }}</span>
                    <p class="font-bold text-gray-900 text-[12px] mt-0.5">{{ $order->shipping_zone_name }}</p>
                </div>
                <div class="text-end">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider
                                 {{ $order->shipping_method === 'express' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                        <span class="material-symbols-outlined text-[12px]">
                            {{ $order->shipping_method === 'express' ? 'bolt' : 'local_shipping' }}
                        </span>
                        {{ __('checkout.' . $order->shipping_method) }}
                    </span>
                    <p class="text-[11px] font-bold text-gray-900 mt-1">${{ number_format($order->shipping, 2) }}</p>
                </div>
            </div>
            @else
            <p class="text-[11px] text-gray-400 italic mb-4 pb-4 border-b border-gray-100">{{ __('admin_orders.no_shipping_zone') }}</p>
            @endif

            <span class="text-gray-400 tracking-wider text-[10px]">{{ __('admin_orders.address') }}</span>
            <address class="text-[11px] text-gray-700 not-italic leading-relaxed mt-0.5">
                {{ $order->address }}<br>
                {{ $order->city }}@if($order->state), {{ $order->state }}@endif {{ $order->zip }}<br>
                {{ $order->country }}
            </address>
        </div>

        {{-- Payment --}}
        <div class="bg-white border border-gray-200 p-5">
            <h3 class="text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-4">{{ __('admin_orders.payment') }}</h3>
            <p class="text-[11px] text-gray-700">{{ $order->payment_method }}</p>
            <p class="text-[10px] text-gray-400 mt-1">{{ __('admin_orders.placed', ['date' => $order->created_at->format('M d, Y \a\t g:i A')]) }}</p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center justify-center gap-2 w-full border border-gray-300 text-gray-600
                  hover:border-black hover:text-black font-bold text-[10px] tracking-[.15em] uppercase py-3 transition-colors">
            {{ __('admin_orders.back_to_orders') }}
        </a>
    </div>

</div>
</div>

<style>
.admin-input { display:block; width:100%; border:1px solid #e5e7eb; padding:8px 12px; font-size:12px; font-family:'Montserrat',sans-serif; color:#111827; background:white; outline:none; border-radius:0; }
.admin-input:focus { border-color:#775a19; box-shadow:none; }
</style>

@endsection
