@extends('admin.layouts.admin')
@section('title', __('admin_categories.title'))
@section('breadcrumb', __('admin_categories.breadcrumb'))

@section('content')

<div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

    {{-- ── Category List ──────────────────────────────────────────────── --}}
    <div class="xl:col-span-3">
        <div class="bg-white border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-[11px] font-bold uppercase tracking-widest">{{ __('admin_categories.all_categories') }}</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <div class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                    <div class="w-12 h-14 flex-shrink-0 overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $category->image) }}"
                             alt="{{ $category->name_en }}"
                             class="w-full h-full object-cover"/>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-bold text-gray-900">{{ $category->name_en }} <span class="text-gray-400 font-normal">/ {{ $category->name_ar }}</span></p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ __('admin_categories.span_sort', ['span' => $category->span, 'sort' => $category->sort_order]) }}</p>
                    </div>
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <button onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name_en) }}', '{{ addslashes($category->name_ar) }}', '{{ $category->span }}', {{ $category->sort_order }})"
                                class="p-1.5 text-gray-400 hover:text-black transition-colors">
                            <span class="material-symbols-outlined text-base">edit</span>
                        </button>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('{{ addslashes(__('admin_categories.delete_confirm', ['name' => $category->name_en])) }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="px-5 py-10 text-center text-[11px] text-gray-400">{{ __('admin_categories.no_categories_yet') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Add New Category ───────────────────────────────────────────── --}}
    <div class="xl:col-span-2">
        <div class="bg-white border border-gray-200 p-6 sticky top-24">
            <h3 class="text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-5">{{ __('admin_categories.add_new_category') }}</h3>

            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data"
                  class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">{{ __('admin_categories.name_en') }}</label>
                        <input type="text" name="name_en" dir="ltr" value="{{ old('name_en') }}" required class="admin-input"/>
                        @error('name_en')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label">{{ __('admin_categories.name_ar') }}</label>
                        <input type="text" name="name_ar" dir="rtl" value="{{ old('name_ar') }}" required class="admin-input"/>
                        @error('name_ar')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="admin-label">{{ __('admin_categories.image') }} <span class="text-gray-400 font-normal">{{ __('admin_categories.image_hint') }}</span></label>
                    <input type="file" name="image" accept="image/*" required
                           onchange="previewCatImg(this)"
                           class="w-full text-[11px] text-gray-600 border border-gray-200 p-2"/>
                    <div id="catPreview" class="mt-2 hidden w-full h-28 overflow-hidden bg-gray-100">
                        <img id="catPreviewImg" class="w-full h-full object-cover"/>
                    </div>
                    @error('image')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label">{{ __('admin_categories.grid_span') }}</label>
                    <select name="span" required class="admin-input">
                        <option value="col-span-1" {{ old('span') === 'col-span-1' ? 'selected' : '' }}>{{ __('admin_categories.span_normal') }}</option>
                        <option value="col-span-2" {{ old('span') === 'col-span-2' ? 'selected' : '' }}>{{ __('admin_categories.span_wide') }}</option>
                        <option value="col-span-3" {{ old('span') === 'col-span-3' ? 'selected' : '' }}>{{ __('admin_categories.span_full') }}</option>
                    </select>
                    @error('span')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label">{{ __('admin_categories.sort_order') }}</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="admin-input"/>
                </div>

                <button type="submit"
                        class="w-full bg-black hover:bg-[#775a19] text-white font-bold
                               text-[10px] tracking-[.2em] uppercase py-3.5 transition-colors">
                    {{ __('admin_categories.add_category') }}
                </button>
            </form>
        </div>
    </div>

</div>

{{-- Edit Modal --}}
<div id="editModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60" onclick="closeEditModal()"></div>
    <div class="relative bg-white w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-[11px] font-bold uppercase tracking-widest">{{ __('admin_categories.edit_category') }}</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-black">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="admin-label">{{ __('admin_categories.name_en') }}</label>
                    <input type="text" name="name_en" id="editNameEn" dir="ltr" required class="admin-input"/>
                </div>
                <div>
                    <label class="admin-label">{{ __('admin_categories.name_ar') }}</label>
                    <input type="text" name="name_ar" id="editNameAr" dir="rtl" required class="admin-input"/>
                </div>
            </div>
            <div>
                <label class="admin-label">{{ __('admin_categories.new_image') }} <span class="text-gray-400 font-normal">{{ __('admin_categories.new_image_hint') }}</span></label>
                <input type="file" name="image" accept="image/*"
                       class="w-full text-[11px] text-gray-600 border border-gray-200 p-2"/>
            </div>
            <div>
                <label class="admin-label">{{ __('admin_categories.grid_span') }}</label>
                <select name="span" id="editSpan" required class="admin-input">
                    <option value="col-span-1">{{ __('admin_categories.span_normal') }}</option>
                    <option value="col-span-2">{{ __('admin_categories.span_wide') }}</option>
                    <option value="col-span-3">{{ __('admin_categories.span_full') }}</option>
                </select>
            </div>
            <div>
                <label class="admin-label">{{ __('admin_categories.sort_order') }}</label>
                <input type="number" name="sort_order" id="editSort" min="0" class="admin-input"/>
            </div>

            <button type="submit"
                    class="w-full bg-black hover:bg-[#775a19] text-white font-bold
                           text-[10px] tracking-[.2em] uppercase py-3.5 transition-colors">
                {{ __('admin_categories.save_changes') }}
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(id, nameEn, nameAr, span, sort) {
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('editNameEn').value = nameEn;
    document.getElementById('editNameAr').value = nameAr;
    document.getElementById('editSpan').value  = span;
    document.getElementById('editSort').value  = sort;
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function previewCatImg(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('catPreview').classList.remove('hidden');
        document.getElementById('catPreviewImg').src = e.target.result;
    };
    reader.readAsDataURL(file);
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
