@extends('admin.layouts.admin')
@section('title', __('admin_messages.title'))
@section('breadcrumb', __('admin_messages.breadcrumb'))

@section('content')

{{-- Filter tabs --}}
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.messages.index') }}"
       class="text-[10px] font-bold tracking-[.15em] uppercase pb-2 border-b-2 transition-colors
              {{ !request('filter') ? 'border-black text-black' : 'border-transparent text-gray-400 hover:text-black' }}">
        {{ __('admin_messages.all_messages') }}
    </a>
    <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}"
       class="text-[10px] font-bold tracking-[.15em] uppercase pb-2 border-b-2 transition-colors flex items-center gap-2
              {{ request('filter') === 'unread' ? 'border-black text-black' : 'border-transparent text-gray-400 hover:text-black' }}">
        {{ __('admin_messages.unread') }}
        @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
        @if($unreadCount > 0)
        <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5">{{ $unreadCount }}</span>
        @endif
    </a>
</div>

<div class="space-y-3">
    @forelse($messages as $message)

    <div class="bg-white border {{ !$message->is_read ? 'border-[#775a19]' : 'border-gray-200' }} overflow-hidden">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4
                    {{ !$message->is_read ? 'bg-yellow-50' : '' }}">
            <div class="flex items-start gap-3">
                @if(!$message->is_read)
                <span class="mt-1 w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span>
                @endif
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-[13px] font-bold text-gray-900">{{ $message->name }}</span>
                        <span class="text-[11px] text-gray-500">{{ $message->email }}</span>
                        @if($message->phone)
                        <span class="text-[11px] text-gray-500 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">call</span>{{ $message->phone }}
                        </span>
                        @endif
                        @if(!$message->is_read)
                        <span class="text-[9px] bg-red-100 text-red-600 px-2 py-0.5 font-bold tracking-wider uppercase">{{ __('admin_messages.unread_badge') }}</span>
                        @endif
                        @if($message->replied_at)
                        <span class="text-[9px] bg-green-100 text-green-700 px-2 py-0.5 font-bold tracking-wider uppercase">{{ __('admin_messages.replied_badge') }}</span>
                        @endif
                    </div>
                    @if($message->subject)
                    <p class="text-[11px] font-semibold text-gray-700 mt-1">{{ $message->subject }}</p>
                    @endif
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $message->created_at->format('M d, Y \a\t g:i A') }} · {{ $message->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                @if(!$message->is_read)
                <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-2 border border-gray-300 hover:border-black
                                   text-[10px] font-bold tracking-wider uppercase transition-colors">
                        <span class="material-symbols-outlined text-sm">mark_email_read</span>
                        {{ __('admin_messages.mark_read') }}
                    </button>
                </form>
                @endif

                <button type="button" onclick="openReplyModal({{ $message->id }})"
                        class="flex items-center gap-1.5 px-3 py-2 bg-black text-white hover:bg-[#775a19]
                               text-[10px] font-bold tracking-wider uppercase transition-colors">
                    <span class="material-symbols-outlined text-sm">reply</span>
                    {{ __('admin_messages.reply') }}
                </button>

                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                      onsubmit="return confirm('{{ __('admin_messages.delete_confirm') }}')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="p-2 text-gray-400 hover:text-red-600 transition-colors border border-gray-200 hover:border-red-300">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Message body (collapsible) --}}
        <div class="px-5 pb-5 pt-3 border-t border-gray-100">
            <p class="text-[12px] text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</p>

            @if($message->replied_at)
            <div class="mt-4 ps-4 border-s-2 border-green-300">
                <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-1">
                    {{ __('admin_messages.your_reply', ['date' => $message->replied_at->format('M d, Y \a\t g:i A')]) }}
                </p>
                <p class="text-[12px] text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $message->reply_message }}</p>
            </div>
            @endif
        </div>

        {{-- Reply form template (hidden, used by modal) --}}
        <form id="reply-form-{{ $message->id }}" method="POST"
              action="{{ route('admin.messages.reply', $message) }}" class="hidden">
            @csrf
        </form>

    </div>

    @empty
    <div class="bg-white border border-gray-200 flex flex-col items-center justify-center py-20 text-center">
        <span class="material-symbols-outlined text-4xl text-gray-300 mb-3">mail</span>
        <p class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">{{ __('admin_messages.no_messages_yet') }}</p>
        <p class="text-[11px] text-gray-400 mt-1">{{ __('admin_messages.no_messages_hint') }}</p>
    </div>
    @endforelse
</div>

@if($messages->hasPages())
<div class="mt-6">{{ $messages->links() }}</div>
@endif

{{-- ── Reply Modal ──────────────────────────────────────────────────────────── --}}
<div id="replyModalOverlay" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h3 class="text-[13px] font-bold text-gray-900 uppercase tracking-wider">{{ __('admin_messages.reply_to') }} <span id="replyToName"></span></h3>
            <button type="button" onclick="closeReplyModal()" class="p-1 text-gray-400 hover:text-black">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="px-5 py-5">
            <p class="text-[11px] text-gray-500 mb-4">{{ __('admin_messages.sending_to') }} <span id="replyToEmail" class="font-semibold text-gray-700"></span></p>
            <textarea id="replyMessageInput" rows="6" placeholder="{{ __('admin_messages.reply_placeholder') }}"
                      class="w-full border border-gray-300 px-3 py-2.5 text-[12px] focus:border-[#775a19] focus:outline-none resize-none"></textarea>
            <p id="replyError" class="hidden text-[10px] text-red-600 mt-2"></p>
        </div>
        <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-100">
            <button type="button" onclick="closeReplyModal()"
                    class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-500 hover:text-black">
                {{ __('admin_messages.cancel') }}
            </button>
            <button type="button" id="replySendBtn" onclick="submitReply()"
                    class="px-5 py-2.5 bg-black text-white text-[10px] font-bold uppercase tracking-wider hover:bg-[#775a19] transition-colors">
                {{ __('admin_messages.send_reply') }}
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const messagesData = {
    @foreach($messages as $message)
    {{ $message->id }}: { name: @json($message->name), email: @json($message->email) },
    @endforeach
};
let activeMessageId = null;
const __i18n = {
    sending: @json(__('admin_messages.sending')),
    enterReplyError: @json(__('admin_messages.enter_reply_error')),
    sendReply: @json(__('admin_messages.send_reply')),
};

function openReplyModal(messageId) {
    activeMessageId = messageId;
    const data = messagesData[messageId];
    document.getElementById('replyToName').textContent  = data.name;
    document.getElementById('replyToEmail').textContent = data.email;
    document.getElementById('replyMessageInput').value  = '';
    document.getElementById('replyError').classList.add('hidden');
    const overlay = document.getElementById('replyModalOverlay');
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
}

function closeReplyModal() {
    const overlay = document.getElementById('replyModalOverlay');
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
    activeMessageId = null;
}

function submitReply() {
    const text = document.getElementById('replyMessageInput').value.trim();
    const errorEl = document.getElementById('replyError');
    if (!text) {
        errorEl.textContent = __i18n.enterReplyError;
        errorEl.classList.remove('hidden');
        return;
    }

    const form = document.getElementById('reply-form-' + activeMessageId);
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'reply_message';
    input.value = text;
    form.appendChild(input);

    document.getElementById('replySendBtn').disabled = true;
    document.getElementById('replySendBtn').textContent = __i18n.sending;
    form.submit();
}

document.getElementById('replyModalOverlay').addEventListener('click', e => {
    if (e.target.id === 'replyModalOverlay') closeReplyModal();
});
</script>
@endpush
