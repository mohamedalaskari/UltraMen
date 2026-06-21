@php
    $labelNames = [
        'new_arrival'     => __('common.new_arrival'),
        'best_seller'     => __('common.best_seller'),
        'sale'            => __('common.sale'),
        'limited_edition' => __('common.limited_edition'),
        'featured'        => __('common.featured'),
    ];
    $chips = array_filter([
        'category'  => request('category'),
        'search'    => request('search') ? '"' . request('search') . '"' : null,
        'min_price' => request('min_price') ? __('collections.from_price', ['amount' => number_format((int)request('min_price'))]) : null,
        'max_price' => request('max_price') ? __('collections.to_price', ['amount' => number_format((int)request('max_price'))]) : null,
        'label'     => request('label') ? ($labelNames[request('label')] ?? ucwords(str_replace('_', ' ', request('label')))) : null,
    ]);
@endphp

{{-- Active chips --}}
@if(count($chips))
<div class="flex flex-wrap gap-1.5 md:gap-2 mb-4 md:mb-6 items-center">
    @foreach($chips as $key => $label)
    <button type="button" onclick="removeFilter('{{ $key }}')"
            class="flex items-center gap-2 px-3 py-1.5 bg-primary text-on-primary
                   font-label-sm text-[10px] tracking-wider hover:bg-secondary transition-colors">
        {{ $label }}
        <span class="material-symbols-outlined text-xs">close</span>
    </button>
    @endforeach
    <button type="button" onclick="clearFilters()"
            class="font-label-sm text-[10px] text-secondary underline underline-offset-4 hover:text-primary transition-colors ms-1">
        {{ __('collections.clear_all') }}
    </button>
</div>
@endif

{{-- Count --}}
<p class="font-label-sm text-[9px] md:text-[10px] text-on-surface-variant tracking-wider mb-5 md:mb-8">
    @if($products->total() > 0)
        {{ __('collections.showing_results', ['from' => $products->firstItem(), 'to' => $products->lastItem(), 'total' => $products->total()]) }}
    @else
        {{ __('collections.no_products') }}
    @endif
</p>

{{-- Empty --}}
@if($products->total() === 0)
<div class="flex flex-col items-center justify-center py-24 border border-outline-variant text-center">
    <span class="material-symbols-outlined text-5xl text-outline mb-4">search_off</span>
    <p class="font-label-sm text-label-sm text-primary mb-2 uppercase tracking-widest">{{ __('collections.no_products') }}</p>
    <button type="button" onclick="clearFilters()"
            class="bg-primary text-on-primary px-8 py-3 font-label-sm text-label-sm tracking-widest hover:bg-secondary transition-colors mt-4">
        {{ __('collections.clear_all') }}
    </button>
</div>

@else
{{-- Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-8 sm:gap-x-5 sm:gap-y-12 lg:gap-x-8 lg:gap-y-16">
    @foreach($products as $product)
        <x-product-card :product="$product" variant="gallery"/>
    @endforeach
</div>

{{-- Pagination --}}
@if($products->lastPage() > 1)
<div class="mt-12 md:mt-24 flex justify-center items-center gap-4 md:gap-8 border-t border-surface-container pt-8 md:pt-12">

    @if($products->onFirstPage())
        <span class="font-label-sm text-label-sm text-outline opacity-30 cursor-not-allowed flex items-center gap-2">
            <span class="material-symbols-outlined text-base rtl:rotate-180">arrow_back</span> {{ __('collections.previous') }}
        </span>
    @else
        <button type="button" data-page="{{ $products->currentPage() - 1 }}"
                class="paginate-btn font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-base rtl:rotate-180">arrow_back</span> {{ __('collections.previous') }}
        </button>
    @endif

    <div class="flex gap-4">
        @for($i = 1; $i <= $products->lastPage(); $i++)
            @if($i === $products->currentPage())
                <span class="font-label-sm text-label-sm text-primary border-b-2 border-secondary pb-1 w-8 text-center">
                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                </span>
            @else
                <button type="button" data-page="{{ $i }}"
                        class="paginate-btn font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors w-8 text-center pb-1">
                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                </button>
            @endif
        @endfor
    </div>

    @if($products->hasMorePages())
        <button type="button" data-page="{{ $products->currentPage() + 1 }}"
                class="paginate-btn font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors flex items-center gap-2">
            {{ __('collections.next') }} <span class="material-symbols-outlined text-base rtl:rotate-180">arrow_forward</span>
        </button>
    @else
        <span class="font-label-sm text-label-sm text-outline opacity-30 cursor-not-allowed flex items-center gap-2">
            {{ __('collections.next') }} <span class="material-symbols-outlined text-base rtl:rotate-180">arrow_forward</span>
        </span>
    @endif

</div>
@endif
@endif
