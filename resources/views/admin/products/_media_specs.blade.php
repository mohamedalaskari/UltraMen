@php
    $existingGallery    = $product->gallery ?? [];
    $existingSizes      = $product->sizes ?? [];
    $existingFinishes   = $product->finishes ?? [];
    $existingTrust      = $product->trust ?? [];
    $existingAccordions = $product->accordions ?? [];
@endphp

{{-- Additional Photos (gallery slots) ──────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-4 sm:p-6">
    <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500 mb-1">
        <span class="material-symbols-outlined text-[15px] text-gray-400">photo_library</span>
        {{ __('admin_product_form.additional_photos') }}
    </h3>
    <p class="text-[10px] text-gray-400 mb-4">{{ __('admin_product_form.additional_photos_hint') }}</p>
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 sm:gap-3" id="gallerySlots">
        @for($i = 0; $i < 6; $i++)
            @php $existing = $existingGallery[$i]['image'] ?? null; @endphp
            <div class="gallery-slot relative aspect-square border-2 border-dashed border-gray-300 hover:border-[#775a19] transition-colors overflow-hidden bg-gray-50">
                <input type="file" name="gallery_images[]" accept="image/*"
                       class="gallery-slot-input absolute inset-0 opacity-0 cursor-pointer z-10"
                       onchange="handleGallerySlotChange(this)"/>
                <div class="slot-preview absolute inset-0 {{ $existing ? '' : 'hidden' }}">
                    <img class="w-full h-full object-cover" src="{{ $existing ? asset('storage/'.$existing) : '' }}"/>
                    <button type="button" onclick="clearGallerySlot(this)"
                            class="absolute top-1 end-1 bg-black/70 hover:bg-red-600 text-white rounded-full
                                   w-6 h-6 flex items-center justify-center text-sm z-20 leading-none">×</button>
                    @if($existing)
                    <input type="hidden" name="kept_gallery[]" value="{{ $existing }}" class="kept-gallery-input"/>
                    @endif
                </div>
                <div class="slot-empty absolute inset-0 flex flex-col items-center justify-center text-gray-400 pointer-events-none {{ $existing ? 'hidden' : '' }}">
                    <span class="material-symbols-outlined text-base sm:text-lg">add_photo_alternate</span>
                    <span class="text-[7px] sm:text-[8px] mt-1">{{ __('admin_product_form.photo', ['number' => $i + 1]) }}</span>
                </div>
            </div>
        @endfor
    </div>
</div>

{{-- Sizes ─────────────────────────────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500">
            <span class="material-symbols-outlined text-[15px] text-gray-400">straighten</span>
            {{ __('admin_product_form.sizes') }}
        </h3>
        <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
            <input type="checkbox" id="sizesToggle" onchange="toggleSection('sizesPanel', this.checked)"
                   {{ count($existingSizes) ? 'checked' : '' }} class="w-4 h-4 accent-[#775a19] cursor-pointer"/>
            <span class="text-[9px] sm:text-[10px] text-gray-600 tracking-wider uppercase">{{ __('admin_product_form.has_sizes') }}</span>
        </label>
    </div>
    <div id="sizesPanel" class="{{ count($existingSizes) ? '' : 'hidden' }}">
        <div id="sizeChips" class="flex flex-wrap gap-2 mb-3"></div>
        <div class="flex gap-2">
            <input type="text" id="sizeInput" placeholder="{{ __('admin_product_form.size_placeholder') }}"
                   onkeydown="if(event.key==='Enter'){event.preventDefault();addSizeChip();}"
                   class="admin-input flex-1"/>
            <button type="button" onclick="addSizeChip()"
                    class="px-4 py-2 bg-black hover:bg-[#775a19] text-white text-[10px] uppercase tracking-wider transition-colors flex-shrink-0">{{ __('admin_product_form.add') }}</button>
        </div>
        <input type="hidden" name="sizes_data" id="sizesDataInput"/>
    </div>
</div>

{{-- Finishes ───────────────────────────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500">
            <span class="material-symbols-outlined text-[15px] text-gray-400">palette</span>
            {{ __('admin_product_form.finishes') }}
        </h3>
        <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
            <input type="checkbox" id="finishesToggle" onchange="toggleSection('finishesPanel', this.checked)"
                   {{ count($existingFinishes) ? 'checked' : '' }} class="w-4 h-4 accent-[#775a19] cursor-pointer"/>
            <span class="text-[9px] sm:text-[10px] text-gray-600 tracking-wider uppercase">{{ __('admin_product_form.has_finishes') }}</span>
        </label>
    </div>
    <div id="finishesPanel" class="{{ count($existingFinishes) ? '' : 'hidden' }} space-y-2">
        <div id="finishRows" class="space-y-2"></div>
        <button type="button" onclick="addFinishRow()"
                class="inline-block py-2 text-[10px] text-[#775a19] hover:underline tracking-wider font-bold">{{ __('admin_product_form.add_finish') }}</button>
        <input type="hidden" name="finishes_data" id="finishesDataInput"/>
    </div>
</div>

{{-- Trust Badges ───────────────────────────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500">
            <span class="material-symbols-outlined text-[15px] text-gray-400">verified</span>
            {{ __('admin_product_form.trust_badges') }}
        </h3>
        <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
            <input type="checkbox" id="trustToggle" onchange="toggleSection('trustPanel', this.checked)"
                   {{ count($existingTrust) ? 'checked' : '' }} class="w-4 h-4 accent-[#775a19] cursor-pointer"/>
            <span class="text-[9px] sm:text-[10px] text-gray-600 tracking-wider uppercase">{{ __('admin_product_form.show_badges') }}</span>
        </label>
    </div>
    <div id="trustPanel" class="{{ count($existingTrust) ? '' : 'hidden' }} space-y-2">
        <p class="text-[10px] text-gray-400 mb-2">{!! __('admin_product_form.trust_icon_hint', ['link' => '<a href="https://fonts.google.com/icons" target="_blank" class="text-[#775a19] hover:underline">' . __('admin_product_form.material_symbols') . '</a>']) !!}</p>
        <div id="trustRows" class="space-y-2"></div>
        <button type="button" onclick="addTrustRow()"
                class="inline-block py-2 text-[10px] text-[#775a19] hover:underline tracking-wider font-bold">{{ __('admin_product_form.add_badge') }}</button>
        <input type="hidden" name="trust_data" id="trustDataInput"/>
    </div>
</div>

{{-- Extra Info Sections (accordions) ──────────────────────────────────────── --}}
<div class="bg-white border border-gray-200 p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h3 class="flex items-center gap-2 text-[10px] font-bold tracking-[.15em] uppercase text-gray-500">
            <span class="material-symbols-outlined text-[15px] text-gray-400">list_alt</span>
            {{ __('admin_product_form.extra_info_sections') }}
        </h3>
        <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
            <input type="checkbox" id="accordionsToggle" onchange="toggleSection('accordionsPanel', this.checked)"
                   {{ count($existingAccordions) ? 'checked' : '' }} class="w-4 h-4 accent-[#775a19] cursor-pointer"/>
            <span class="text-[9px] sm:text-[10px] text-gray-600 tracking-wider uppercase">{{ __('admin_product_form.add_sections') }}</span>
        </label>
    </div>
    <div id="accordionsPanel" class="{{ count($existingAccordions) ? '' : 'hidden' }} space-y-3">
        <div id="accordionRows" class="space-y-3"></div>
        <button type="button" onclick="addAccordionRow()"
                class="inline-block py-2 text-[10px] text-[#775a19] hover:underline tracking-wider font-bold">{{ __('admin_product_form.add_section') }}</button>
        <input type="hidden" name="accordions_data" id="accordionsDataInput"/>
    </div>
</div>

@push('scripts')
<script>
const __i18n = {
    finishNamePlaceholder: @json(__('admin_product_form.finish_name_placeholder')),
    iconNamePlaceholder: @json(__('admin_product_form.icon_name_placeholder')),
    labelPlaceholder: @json(__('admin_product_form.label_placeholder')),
    sectionTitlePlaceholder: @json(__('admin_product_form.section_title_placeholder')),
    sectionContentPlaceholder: @json(__('admin_product_form.section_content_placeholder')),
};

// ── Toggle panels ────────────────────────────────────────────────────────────
function toggleSection(panelId, show) {
    document.getElementById(panelId).classList.toggle('hidden', !show);
}

// ── Gallery slots ────────────────────────────────────────────────────────────
function handleGallerySlotChange(input) {
    const file = input.files[0];
    if (!file) return;
    const slot = input.closest('.gallery-slot');
    const reader = new FileReader();
    reader.onload = e => {
        slot.querySelector('.slot-preview img').src = e.target.result;
        slot.querySelector('.slot-preview').classList.remove('hidden');
        slot.querySelector('.slot-empty').classList.add('hidden');
        const kept = slot.querySelector('.kept-gallery-input');
        if (kept) kept.remove();
    };
    reader.readAsDataURL(file);
}
function clearGallerySlot(button) {
    const slot = button.closest('.gallery-slot');
    slot.querySelector('.gallery-slot-input').value = '';
    slot.querySelector('.slot-preview img').src = '';
    slot.querySelector('.slot-preview').classList.add('hidden');
    slot.querySelector('.slot-empty').classList.remove('hidden');
    const kept = slot.querySelector('.kept-gallery-input');
    if (kept) kept.remove();
}

// ── Sizes (chip input) ───────────────────────────────────────────────────────
let sizesList = @json($existingSizes);
function renderSizeChips() {
    const wrap = document.getElementById('sizeChips');
    wrap.innerHTML = sizesList.map((s, i) => `
        <span class="inline-flex items-center gap-1.5 bg-gray-100 ps-3 pe-1.5 py-1.5 text-[11px] tracking-wider">
            ${s}
            <button type="button" onclick="removeSizeChip(${i})"
                    class="w-5 h-5 flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-gray-200 rounded-full">×</button>
        </span>
    `).join('');
    document.getElementById('sizesDataInput').value = JSON.stringify(sizesList);
}
function addSizeChip() {
    const input = document.getElementById('sizeInput');
    const val = input.value.trim();
    if (!val) return;
    sizesList.push(val);
    input.value = '';
    renderSizeChips();
}
function removeSizeChip(index) {
    sizesList.splice(index, 1);
    renderSizeChips();
}
renderSizeChips();

// ── Finishes (color + label repeater) ────────────────────────────────────────
let finishesList = @json($existingFinishes);
function renderFinishRows() {
    const wrap = document.getElementById('finishRows');
    wrap.innerHTML = finishesList.map((f, i) => `
        <div class="grid grid-cols-[44px_1fr_40px] gap-2 items-center">
            <input type="color" value="${f.color || '#000000'}" oninput="updateFinish(${i}, 'color', this.value)"
                   class="w-11 h-9 border border-gray-300 cursor-pointer"/>
            <input type="text" value="${(f.label || '').replace(/"/g, '&quot;')}" placeholder="${__i18n.finishNamePlaceholder}"
                   oninput="updateFinish(${i}, 'label', this.value)" class="admin-input"/>
            <button type="button" onclick="removeFinishRow(${i})"
                    class="w-10 h-9 flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-gray-50">
                <span class="material-symbols-outlined text-base">delete</span>
            </button>
        </div>
    `).join('');
    document.getElementById('finishesDataInput').value = JSON.stringify(finishesList);
}
function addFinishRow() {
    finishesList.push({ color: '#000000', label: '' });
    renderFinishRows();
}
function updateFinish(index, key, value) {
    finishesList[index][key] = value;
    document.getElementById('finishesDataInput').value = JSON.stringify(finishesList);
}
function removeFinishRow(index) {
    finishesList.splice(index, 1);
    renderFinishRows();
}
renderFinishRows();

// ── Trust badges (icon + label repeater) ─────────────────────────────────────
let trustList = @json($existingTrust);
function renderTrustRows() {
    const wrap = document.getElementById('trustRows');
    wrap.innerHTML = trustList.map((t, i) => `
        <div class="grid grid-cols-[1fr_40px] sm:grid-cols-[140px_1fr_40px] gap-2 items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-gray-400 text-base flex-shrink-0">${t.icon || 'help'}</span>
                <input type="text" value="${(t.icon || '').replace(/"/g, '&quot;')}" placeholder="${__i18n.iconNamePlaceholder}"
                       oninput="updateTrust(${i}, 'icon', this.value)" class="admin-input flex-1"/>
            </div>
            <input type="text" value="${(t.label || '').replace(/"/g, '&quot;')}" placeholder="${__i18n.labelPlaceholder}"
                   oninput="updateTrust(${i}, 'label', this.value)" class="admin-input col-span-2 sm:col-span-1"/>
            <button type="button" onclick="removeTrustRow(${i})"
                    class="w-10 h-9 flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-gray-50">
                <span class="material-symbols-outlined text-base">delete</span>
            </button>
        </div>
    `).join('');
    document.getElementById('trustDataInput').value = JSON.stringify(trustList);
}
function addTrustRow() {
    trustList.push({ icon: 'verified', label: '' });
    renderTrustRows();
}
function updateTrust(index, key, value) {
    trustList[index][key] = value;
    document.getElementById('trustDataInput').value = JSON.stringify(trustList);
    if (key === 'icon') renderTrustRows();
}
function removeTrustRow(index) {
    trustList.splice(index, 1);
    renderTrustRows();
}
renderTrustRows();

// ── Accordions (title + content repeater) ────────────────────────────────────
let accordionsList = @json($existingAccordions);
function renderAccordionRows() {
    const wrap = document.getElementById('accordionRows');
    wrap.innerHTML = accordionsList.map((a, i) => `
        <div class="border border-gray-200 p-3 space-y-2">
            <div class="flex items-center gap-2">
                <input type="text" value="${(a.title || '').replace(/"/g, '&quot;')}" placeholder="${__i18n.sectionTitlePlaceholder}"
                       oninput="updateAccordion(${i}, 'title', this.value)" class="admin-input flex-1"/>
                <button type="button" onclick="removeAccordionRow(${i})"
                        class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-gray-50 flex-shrink-0">
                    <span class="material-symbols-outlined text-base">delete</span>
                </button>
            </div>
            <textarea rows="2" placeholder="${__i18n.sectionContentPlaceholder}" oninput="updateAccordion(${i}, 'content', this.value)"
                      class="admin-input resize-none">${a.content || ''}</textarea>
        </div>
    `).join('');
    document.getElementById('accordionsDataInput').value = JSON.stringify(accordionsList);
}
function addAccordionRow() {
    accordionsList.push({ title: '', content: '' });
    renderAccordionRows();
}
function updateAccordion(index, key, value) {
    accordionsList[index][key] = value;
    document.getElementById('accordionsDataInput').value = JSON.stringify(accordionsList);
}
function removeAccordionRow(index) {
    accordionsList.splice(index, 1);
    renderAccordionRows();
}
renderAccordionRows();

// ── Clear data for toggled-off sections on submit ─────────────────────────────
document.getElementById('productForm')?.addEventListener('submit', function () {
    if (!document.getElementById('sizesToggle').checked)      document.getElementById('sizesDataInput').value = '[]';
    if (!document.getElementById('finishesToggle').checked)   document.getElementById('finishesDataInput').value = '[]';
    if (!document.getElementById('trustToggle').checked)      document.getElementById('trustDataInput').value = '[]';
    if (!document.getElementById('accordionsToggle').checked) document.getElementById('accordionsDataInput').value = '[]';
});
</script>
@endpush
