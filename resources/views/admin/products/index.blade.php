@extends('admin.layouts.admin')
@section('title', __('admin_products.title'))
@section('breadcrumb', __('admin_products.breadcrumb'))

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <p class="text-[11px] text-gray-500 tracking-wider">{{ __('admin_products.products_total', ['count' => $products->total()]) }}</p>
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-2 bg-black text-white px-5 py-2.5
              font-bold text-[10px] tracking-[.15em] uppercase hover:bg-[#775a19] transition-colors">
        <span class="material-symbols-outlined text-base">add</span> {{ __('admin_products.add_product') }}
    </a>
</div>

<div class="bg-white border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-[11px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase">{{ __('admin_products.product') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden md:table-cell">{{ __('admin_products.category') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden sm:table-cell">{{ __('admin_products.price') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden lg:table-cell">{{ __('admin_products.labels') }}</th>
                    <th class="text-start px-4 py-3 font-bold tracking-[.1em] text-gray-500 uppercase hidden lg:table-cell">{{ __('admin_products.sort') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-12 flex-shrink-0 overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover"/>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                <p class="text-gray-400 text-[10px] mt-0.5">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600 hidden md:table-cell">{{ $product->category_name }}</td>
                    <td class="px-4 py-3 hidden sm:table-cell">
                        @if($product->has_discount)
                            <div class="flex items-center gap-2">
                                <s class="text-gray-400 text-[10px]">${{ number_format($product->original_price, 2) }}</s>
                                <span class="font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <span class="bg-red-600 text-white px-1.5 py-0.5 text-[9px] font-bold">-{{ $product->discount_percent }}%</span>
                            </div>
                        @else
                            <span class="font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 hidden lg:table-cell">
                        <div class="flex flex-wrap gap-1">
                            @foreach($product->labels ?? [] as $label)
                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 text-[9px] tracking-wider uppercase">
                                {{ str_replace('_', ' ', $label) }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 hidden lg:table-cell">{{ $product->sort_order }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('product.show', $product->slug) }}" target="_blank"
                               class="p-1.5 text-gray-400 hover:text-black transition-colors" title="{{ __('admin_products.view') }}">
                                <span class="material-symbols-outlined text-base">open_in_new</span>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="p-1.5 text-gray-400 hover:text-black transition-colors" title="{{ __('admin_products.edit') }}">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('{{ addslashes(__('admin_products.delete_confirm', ['name' => $product->name])) }}')">
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
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400 text-[11px] tracking-wider">
                        {{ __('admin_products.no_products_yet') }}
                        <a href="{{ route('admin.products.create') }}" class="text-[#775a19] hover:underline ms-1">{{ __('admin_products.add_first_one') }}</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-4 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
