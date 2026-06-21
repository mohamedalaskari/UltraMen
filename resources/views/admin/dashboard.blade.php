@php use Illuminate\Support\Str; @endphp
@extends('admin.layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- ── Stats Grid ──────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <div class="bg-white border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[9px] text-gray-400 tracking-[.15em] uppercase mb-1">{{ __('dashboard.total_products') }}</p>
                <p class="text-3xl font-black text-gray-900">{{ $totalProducts }}</p>
            </div>
            <span class="material-symbols-outlined text-2xl text-gray-300">inventory_2</span>
        </div>
        <a href="{{ route('admin.products.index') }}" class="mt-3 block text-[10px] text-[#775a19] tracking-wider hover:underline">{{ __('dashboard.manage') }}</a>
    </div>

    <div class="bg-white border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[9px] text-gray-400 tracking-[.15em] uppercase mb-1">{{ __('dashboard.total_orders') }}</p>
                <p class="text-3xl font-black text-gray-900">{{ $totalOrders }}</p>
            </div>
            <span class="material-symbols-outlined text-2xl text-gray-300">receipt_long</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="mt-3 block text-[10px] text-[#775a19] tracking-wider hover:underline">{{ __('dashboard.view_all') }}</a>
    </div>

    <div class="bg-white border border-yellow-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[9px] text-gray-400 tracking-[.15em] uppercase mb-1">{{ __('dashboard.pending_orders') }}</p>
                <p class="text-3xl font-black text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <span class="material-symbols-outlined text-2xl text-yellow-300">pending_actions</span>
        </div>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="mt-3 block text-[10px] text-[#775a19] tracking-wider hover:underline">{{ __('dashboard.review') }}</a>
    </div>

    <div class="bg-white border border-gray-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[9px] text-gray-400 tracking-[.15em] uppercase mb-1">{{ __('dashboard.unread_messages') }}</p>
                <p class="text-3xl font-black {{ $unreadMessages > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $unreadMessages }}</p>
            </div>
            <span class="material-symbols-outlined text-2xl text-gray-300">mail</span>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="mt-3 block text-[10px] text-[#775a19] tracking-wider hover:underline">{{ __('dashboard.read') }}</a>
    </div>

</div>

{{-- Revenue banner --}}
<div class="bg-black text-white p-5 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
        <p class="text-[9px] text-gray-400 tracking-[.15em] uppercase">{{ __('dashboard.total_revenue') }}</p>
        <p class="text-2xl font-black mt-1">${{ number_format($totalRevenue, 2) }}</p>
    </div>
    <span class="text-[9px] text-gray-500 tracking-wider uppercase">{{ __('dashboard.all_completed_orders') }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- Recent Orders --}}
    <div class="bg-white border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-[11px] font-bold uppercase tracking-widest">{{ __('dashboard.recent_orders') }}</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-[10px] text-[#775a19] hover:underline tracking-wider">{{ __('common.view_all') }}</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}"
               class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition-colors">
                <div>
                    <p class="text-[11px] font-bold text-gray-900">{{ $order->order_number }}</p>
                    <p class="text-[10px] text-gray-500 mt-0.5">{{ $order->full_name }}</p>
                </div>
                <div class="text-end">
                    <span class="badge-status badge-{{ $order->status }}">{{ __('order_status.' . $order->status) }}</span>
                    <p class="text-[10px] text-gray-500 mt-1">${{ number_format($order->total, 2) }}</p>
                </div>
            </a>
            @empty
            <p class="px-5 py-8 text-[11px] text-gray-400 text-center">{{ __('dashboard.no_orders_yet') }}</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="bg-white border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-[11px] font-bold uppercase tracking-widest">{{ __('dashboard.recent_messages') }}</h3>
            <a href="{{ route('admin.messages.index') }}" class="text-[10px] text-[#775a19] hover:underline tracking-wider">{{ __('common.view_all') }}</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentMessages as $msg)
            <div class="flex items-start justify-between px-5 py-3.5 {{ !$msg->is_read ? 'bg-yellow-50' : '' }}">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-[11px] font-bold text-gray-900 truncate">{{ $msg->name }}</p>
                        @if(!$msg->is_read)
                            <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span>
                        @endif
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5 truncate">{{ $msg->subject ?: Str::limit($msg->message, 40) }}</p>
                    <p class="text-[9px] text-gray-400 mt-0.5">{{ $msg->created_at->diffForHumans() }}</p>
                </div>
                @if(!$msg->is_read)
                <form method="POST" action="{{ route('admin.messages.read', $msg) }}" class="ms-3 flex-shrink-0">
                    @csrf @method('PATCH')
                    <button type="submit" class="text-[9px] text-[#775a19] hover:underline tracking-wider">{{ __('dashboard.mark_read') }}</button>
                </form>
                @endif
            </div>
            @empty
            <p class="px-5 py-8 text-[11px] text-gray-400 text-center">{{ __('dashboard.no_messages_yet') }}</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
