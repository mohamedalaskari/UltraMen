@extends('admin.layouts.admin')
@section('title', __('admin_settings.title'))
@section('breadcrumb', __('admin_settings.breadcrumb'))

@section('content')

{{-- ── Page Tabs ─────────────────────────────────────────────────────────────── --}}
<div class="flex flex-wrap gap-2 mb-8 border-b border-gray-200">
    @foreach($pages as $p)
        <a href="{{ route('admin.settings.index', $p) }}"
           class="px-4 py-3 text-[11px] font-bold uppercase tracking-wider transition-colors
                  {{ $page === $p ? 'border-b-2 border-[#775a19] text-black' : 'text-gray-400 hover:text-black' }}">
            {{ __('admin_settings.tab_' . $p) }}
        </a>
    @endforeach
</div>

<form method="POST" action="{{ route('admin.settings.update', $page) }}" enctype="multipart/form-data" class="space-y-8 max-w-4xl">
    @csrf

    @foreach($fields as $field)
        @php $label = app()->getLocale() === 'ar' ? $field['label_ar'] : $field['label_en']; @endphp
        <div class="bg-white border border-gray-200 p-6">

            @if($field['type'] === 'image')
                <label class="admin-label">{{ $label }}</label>
                <div class="flex items-center gap-6 flex-wrap">
                    <div class="w-32 h-32 bg-gray-50 border border-gray-200 overflow-hidden flex-shrink-0">
                        <img src="{{ asset('storage/' . $field['current_path']) }}" alt="{{ $label }}" class="w-full h-full object-cover"/>
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <span class="text-[10px] text-gray-400 uppercase tracking-wider block mb-2">{{ __('admin_settings.replace_image') }}</span>
                        <input type="file" name="{{ $field['key'] }}" class="admin-input"/>
                        @error($field['key'])<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            @elseif($field['type'] === 'url')
                <label class="admin-label">{{ $label }}</label>
                <input type="text" name="{{ $field['key'] }}" dir="ltr" placeholder="https://"
                       value="{{ old($field['key'], $field['value']) }}" class="admin-input"/>
                @error($field['key'])<p class="admin-error">{{ $message }}</p>@enderror
            @else
                <label class="admin-label">{{ $label }}</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-[9px] text-gray-400 uppercase tracking-wider block mb-1">{{ __('admin_settings.english') }}</span>
                        @if($field['type'] === 'textarea')
                            <textarea name="{{ $field['key'] }}_en" rows="3" dir="ltr" class="admin-input">{{ old("{$field['key']}_en", $field['value_en']) }}</textarea>
                        @else
                            <input type="text" name="{{ $field['key'] }}_en" dir="ltr" value="{{ old("{$field['key']}_en", $field['value_en']) }}" class="admin-input"/>
                        @endif
                        @error("{$field['key']}_en")<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <span class="text-[9px] text-gray-400 uppercase tracking-wider block mb-1">{{ __('admin_settings.arabic') }}</span>
                        @if($field['type'] === 'textarea')
                            <textarea name="{{ $field['key'] }}_ar" rows="3" dir="rtl" class="admin-input">{{ old("{$field['key']}_ar", $field['value_ar']) }}</textarea>
                        @else
                            <input type="text" name="{{ $field['key'] }}_ar" dir="rtl" value="{{ old("{$field['key']}_ar", $field['value_ar']) }}" class="admin-input"/>
                        @endif
                        @error("{$field['key']}_ar")<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            @endif

        </div>
    @endforeach

    <button type="submit"
            class="bg-black hover:bg-[#775a19] text-white font-bold
                   text-[10px] tracking-[.2em] uppercase px-8 py-3.5 transition-colors">
        {{ __('admin_settings.save_changes') }}
    </button>
</form>

<style>
.admin-label { display:block; font-size:10px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:10px; }
.admin-input { display:block; width:100%; border:1px solid #e5e7eb; padding:8px 12px; font-size:12px; font-family:'Montserrat',sans-serif; color:#111827; background:white; outline:none; border-radius:0; }
.admin-input:focus { border-color:#775a19; box-shadow:none; }
.admin-error { color:#dc2626; font-size:10px; margin-top:4px; letter-spacing:.05em; }
</style>

@endsection
