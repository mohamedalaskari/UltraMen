<x-mail::message>
Hi {{ $contactMessage->name }},

{{ $replyMessage }}

---

**Your original message:**

{{ $contactMessage->message }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
