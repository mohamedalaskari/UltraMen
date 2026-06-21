<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ULTRA Admin — Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Noto+Kufi+Arabic:wght@400;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        * { font-family: 'Montserrat', sans-serif; }
        [dir="rtl"] *:not(.material-symbols-outlined) { font-family: 'Noto Kufi Arabic', 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center px-4">

<a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
   class="absolute top-6 end-6 text-[10px] font-bold text-gray-400 hover:text-white tracking-widest uppercase border border-gray-700 px-2.5 py-1.5">
    {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
</a>

<div class="w-full max-w-sm">

    <div class="text-center mb-10">
        <span class="text-white font-black text-3xl tracking-[.3em]">ULTRA</span>
        <p class="text-[#775a19] text-[10px] tracking-[.25em] mt-2 uppercase">{{ __('admin_login.admin_panel') }}</p>
    </div>

    <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-[9px] text-gray-400 tracking-[.15em] uppercase mb-2">{{ __('admin_login.email') }}</label>
            <input type="email" name="email" id="emailInput" value="{{ old('email') }}"
                   autofocus autocomplete="username"
                   class="w-full bg-transparent border border-gray-700 focus:border-[#775a19] focus:ring-0
                          text-white text-sm px-4 py-3 rounded-none transition-colors
                          placeholder:text-gray-600"
                   placeholder="{{ __('admin_login.email_placeholder') }}"/>
            @error('email')
            <p class="mt-2 text-[10px] text-red-400 tracking-wider">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[9px] text-gray-400 tracking-[.15em] uppercase mb-2">{{ __('admin_login.password') }}</label>
            <div class="relative">
                <input type="password" name="password" id="passwordInput"
                       autocomplete="current-password"
                       class="w-full bg-transparent border border-gray-700 focus:border-[#775a19] focus:ring-0
                              text-white text-sm px-4 py-3 pe-10 rounded-none transition-colors
                              placeholder:text-gray-600"
                       placeholder="{{ __('admin_login.password_placeholder') }}"/>
                <button type="button" onclick="togglePass()"
                        class="absolute end-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-base" id="eyeIcon">visibility</span>
                </button>
            </div>
            @error('password')
            <p class="mt-2 text-[10px] text-red-400 tracking-wider">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-[#775a19] hover:bg-[#5c4312] text-white font-bold
                       text-[11px] tracking-[.2em] uppercase py-3.5 transition-colors">
            {{ __('admin_login.enter_dashboard') }}
        </button>
    </form>

    <p class="text-center text-[9px] text-gray-700 tracking-wider mt-8 uppercase">
        ULTRA &copy; {{ date('Y') }}
    </p>
</div>

<script>
function togglePass() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
</script>
</body>
</html>
