<p class="text-[10px] text-gray-400 tracking-wider mb-4">
    {{ trans_choice('admin_orders.orders_found', $orders->total(), ['count' => $orders->total()]) }}
</p>

<div class="bg-white border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-[11px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_orders.order') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden sm:table-cell">{{ __('admin_orders.customer') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden md:table-cell">{{ __('admin_orders.date') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_orders.total') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_orders.status') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                        <p class="text-[10px] text-gray-400 sm:hidden mt-0.5">{{ $order->full_name }}</p>
                    </td>
                    <td class="px-4 py-3 hidden sm:table-cell">
                        <p class="text-gray-900">{{ $order->full_name }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $order->email }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-500 hidden md:table-cell">
                        {{ $order->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 font-bold text-gray-900">${{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="border border-gray-200 px-2 py-1 text-[10px] uppercase tracking-wider font-sans focus:border-[#775a19] focus:outline-none bg-white cursor-pointer badge-{{ $order->status }}">
                                @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ __('order_status.' . $s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="p-1.5 text-gray-400 hover:text-black transition-colors inline-flex">
                            <span class="material-symbols-outlined text-base">visibility</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400 text-[11px] tracking-wider">
                        {{ __('admin_orders.no_orders_found') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->lastPage() > 1)
    <div class="px-4 py-4 border-t border-gray-100 flex justify-center items-center gap-6">

        @if($orders->onFirstPage())
            <span class="text-gray-300 cursor-not-allowed flex items-center gap-1 text-[10px] uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_back</span> {{ __('admin_orders.prev') }}
            </span>
        @else
            <button type="button" data-page="{{ $orders->currentPage() - 1 }}"
                    class="paginate-btn text-gray-600 hover:text-black transition-colors flex items-center gap-1 text-[10px] uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_back</span> {{ __('admin_orders.prev') }}
            </button>
        @endif

        <span class="text-[10px] text-gray-500 tracking-wider">
            {{ __('admin_orders.page_of', ['current' => $orders->currentPage(), 'last' => $orders->lastPage()]) }}
        </span>

        @if($orders->hasMorePages())
            <button type="button" data-page="{{ $orders->currentPage() + 1 }}"
                    class="paginate-btn text-gray-600 hover:text-black transition-colors flex items-center gap-1 text-[10px] uppercase tracking-wider">
                {{ __('admin_orders.next') }} <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_forward</span>
            </button>
        @else
            <span class="text-gray-300 cursor-not-allowed flex items-center gap-1 text-[10px] uppercase tracking-wider">
                {{ __('admin_orders.next') }} <span class="material-symbols-outlined text-sm rtl:rotate-180">arrow_forward</span>
            </span>
        @endif

    </div>
    @endif
</div>
