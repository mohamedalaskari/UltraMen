<div class="fixed inset-0 z-[100] invisible" id="searchOverlay"
     data-no-results="{{ __('common.search_no_results') }}"
     data-view-all="{{ __('common.search_view_all') }}"
     data-collections-url="{{ route('collections') }}">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-300"
         id="searchBackdrop"
         onclick="toggleSearch()"></div>

    <div class="absolute top-0 inset-x-0 bg-surface-container-lowest shadow-2xl -translate-y-full transition-transform duration-300"
         id="searchPanel">
        <div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop py-8">

            <div class="flex items-center gap-4 border-b-2 border-primary pb-4">
                <span class="material-symbols-outlined text-primary">search</span>
                <input type="text" id="searchInput" autocomplete="off"
                       placeholder="{{ __('common.search_placeholder') }}"
                       class="flex-grow bg-transparent border-none focus:ring-0 text-lg md:text-2xl
                              font-body-lg text-primary placeholder:text-outline outline-none"/>
                <button type="button" onclick="toggleSearch()" class="text-primary hover:text-secondary transition-colors flex-shrink-0">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div id="searchResults" class="mt-6 max-h-[60vh] overflow-y-auto"></div>
        </div>
    </div>
</div>
