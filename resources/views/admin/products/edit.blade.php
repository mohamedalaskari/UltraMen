@extends('admin.layouts.admin')
@section('title', __('admin_product_form.edit_title'))
@section('breadcrumb', __('admin_product_form.edit_breadcrumb', ['name' => $product->name]))

@section('content')

<div class="max-w-4xl pb-24 lg:pb-0">

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="productForm">
@csrf @method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">

    {{-- ── Main Info ─────────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-4 lg:space-y-5">

        <div class="bg-white border border-gray-200 p-4 sm:p-6">
            <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-5">
                <span class="material-symbols-outlined text-[15px] text-gray-400">info</span>
                {{ __('admin_product_form.basic_information') }}
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.product_name_en') }}</label>
                        <input type="text" name="name_en" dir="ltr" value="{{ old('name_en', $product->name_en) }}" class="admin-input" required/>
                        @error('name_en')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.product_name_ar') }}</label>
                        <input type="text" name="name_ar" dir="rtl" value="{{ old('name_ar', $product->name_ar) }}" class="admin-input" required/>
                        @error('name_ar')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="admin-label">{{ __('admin_product_form.slug') }}</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="admin-input" required/>
                    @error('slug')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.category') }}</label>
                        @php $selectedCategory = old('category', $product->category); @endphp
                        <select name="category" class="admin-input" required>
                            @if(!$categories->contains('slug', $selectedCategory))
                                <option value="{{ $selectedCategory }}" selected>{{ $selectedCategory }} {{ __('admin_product_form.not_in_list') }}</option>
                            @endif
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ $selectedCategory === $cat->slug ? 'selected' : '' }}>
                                    {{ app()->getLocale() === 'ar' ? $cat->name_ar : $cat->name_en }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.price_usd') }}</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                               step="0.01" min="0" class="admin-input" required/>
                        @error('price')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <label class="admin-label !mb-0">{{ __('admin_product_form.special_offer') }}</label>
                        <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
                            <input type="checkbox" id="offerToggle" onchange="toggleSection('offerPanel', this.checked)"
                                   {{ old('original_price', $product->original_price) ? 'checked' : '' }} class="w-4 h-4 accent-[#775a19] cursor-pointer"/>
                            <span class="text-[10px] text-gray-600 tracking-wider uppercase">{{ __('admin_product_form.this_product_on_offer') }}</span>
                        </label>
                    </div>
                    <div id="offerPanel" class="{{ old('original_price', $product->original_price) ? '' : 'hidden' }}">
                        <label class="admin-label">{{ __('admin_product_form.original_price') }} <span class="text-gray-400 font-normal">{{ __('admin_product_form.original_price_hint') }}</span></label>
                        <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}"
                               step="0.01" min="0" class="admin-input"/>
                        @error('original_price')<p class="admin-error">{{ $message }}</p>@enderror
                        <p class="text-[10px] text-gray-400 mt-2">{{ __('admin_product_form.strikethrough_hint', ['original' => '$ORIGINAL', 'current' => '$CURRENT']) }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.subtitle_en') }}</label>
                        <input type="text" name="subtitle_en" dir="ltr" value="{{ old('subtitle_en', $product->subtitle_en) }}" class="admin-input"/>
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.subtitle_ar') }}</label>
                        <input type="text" name="subtitle_ar" dir="rtl" value="{{ old('subtitle_ar', $product->subtitle_ar) }}" class="admin-input"/>
                    </div>
                </div>

                <div>
                    <label class="admin-label">{{ __('admin_product_form.badge_text') }}</label>
                    <input type="text" name="badge" value="{{ old('badge', $product->badge) }}" class="admin-input"/>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.description_en') }}</label>
                        <textarea name="description_en" dir="ltr" rows="4" class="admin-input resize-none" required>{{ old('description_en', $product->description_en) }}</textarea>
                        @error('description_en')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_product_form.description_ar') }}</label>
                        <textarea name="description_ar" dir="rtl" rows="4" class="admin-input resize-none" required>{{ old('description_ar', $product->description_ar) }}</textarea>
                        @error('description_ar')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Image --}}
        <div class="bg-white border border-gray-200 p-4 sm:p-6">
            <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-5">
                <span class="material-symbols-outlined text-[15px] text-gray-400">image</span>
                {{ __('admin_product_form.main_image') }}
            </h3>
            <label class="admin-label">{{ __('admin_product_form.main_image') }} <span class="text-gray-400 font-normal">{{ __('admin_product_form.main_image_hint_edit') }}</span></label>
            <div class="mb-3 w-full h-40 overflow-hidden bg-gray-100">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" id="previewMain"/>
            </div>
            <input type="file" name="image" accept="image/*"
                   onchange="previewImg(this, 'previewMain')"
                   class="w-full text-[11px] text-gray-600 border border-gray-200 p-2"/>
        </div>

        @include('admin.products._media_specs', ['product' => $product])

    </div>

    {{-- ── Sidebar ────────────────────────────────────────────────────── --}}
    <div class="space-y-4 lg:space-y-5">

        <div class="bg-white border border-gray-200 p-4 sm:p-6">
            <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-5">
                <span class="material-symbols-outlined text-[15px] text-gray-400">sell</span>
                {{ __('admin_product_form.labels') }}
            </h3>
            <div class="space-y-3">
                @foreach(\App\Models\Product::LABELS as $key => $labelName)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="labels[]" value="{{ $key }}"
                           {{ in_array($key, old('labels', $product->labels ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 accent-[#775a19] cursor-pointer"/>
                    <span class="text-[11px] text-gray-700 group-hover:text-black tracking-wider">{{ $labelName }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="bg-white border border-gray-200 p-4 sm:p-6">
            <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-5">
                <span class="material-symbols-outlined text-[15px] text-gray-400">sort</span>
                {{ __('admin_product_form.sort_order') }}
            </h3>
            <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}"
                   min="0" class="admin-input"/>
            <p class="text-[10px] text-gray-400 mt-2">{{ __('admin_product_form.sort_order_hint') }}</p>
        </div>

        {{-- Desktop action buttons (hidden on mobile — replaced by sticky bar) --}}
        <div class="hidden lg:block space-y-3">
            <button type="submit"
                    class="w-full bg-black hover:bg-[#775a19] text-white font-bold
                           text-[11px] tracking-[.2em] uppercase py-4 transition-colors">
                {{ __('admin_product_form.save_changes') }}
            </button>

            <a href="{{ route('product.show', $product->slug) }}" target="_blank"
               class="flex items-center justify-center gap-2 w-full border border-gray-300 text-gray-600
                      hover:border-black hover:text-black font-bold text-[10px] tracking-[.15em] uppercase py-3 transition-colors">
                <span class="material-symbols-outlined text-sm">open_in_new</span> {{ __('admin_product_form.view_product') }}
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="block w-full text-center border border-gray-300 text-gray-600 hover:border-black hover:text-black
                      font-bold text-[10px] tracking-[.15em] uppercase py-3 transition-colors">
                {{ __('admin_product_form.cancel') }}
            </a>
        </div>

        {{-- Mobile-only: view product link (save/cancel live in the sticky bar) --}}
        <a href="{{ route('product.show', $product->slug) }}" target="_blank"
           class="lg:hidden flex items-center justify-center gap-2 w-full border border-gray-300 text-gray-600
                  hover:border-black hover:text-black font-bold text-[10px] tracking-[.15em] uppercase py-3 transition-colors">
            <span class="material-symbols-outlined text-sm">open_in_new</span> {{ __('admin_product_form.view_product') }}
        </a>

    </div>

</div>

{{-- Sticky mobile action bar --}}
<div class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white border-t border-gray-200 p-3 flex gap-3 shadow-[0_-4px_16px_rgba(0,0,0,0.08)]">
    <a href="{{ route('admin.products.index') }}"
       class="flex-1 text-center border border-gray-300 text-gray-600 font-bold text-[10px] tracking-[.15em] uppercase py-3">
        {{ __('admin_product_form.cancel') }}
    </a>
    <button type="submit"
            class="flex-1 bg-black text-white font-bold text-[10px] tracking-[.15em] uppercase py-3">
        {{ __('admin_product_form.save_changes') }}
    </button>
</div>

</form>
</div>

@push('scripts')
<script>
function previewImg(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const el = document.getElementById(previewId);
        if (el) el.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
document.getElementById('productForm')?.addEventListener('submit', function () {
    if (!document.getElementById('offerToggle').checked) {
        document.querySelector('input[name="original_price"]').value = '';
    }
});
</script>
@endpush

<style>
.admin-label { display:block; font-size:10px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:6px; }
.admin-input { display:block; width:100%; border:1px solid #e5e7eb; padding:8px 12px; font-size:12px; font-family:'Montserrat',sans-serif; color:#111827; background:white; outline:none; border-radius:0; }
.admin-input:focus { border-color:#775a19; box-shadow:none; }
.admin-error { color:#dc2626; font-size:10px; margin-top:4px; letter-spacing:.05em; }
</style>

@endsection
