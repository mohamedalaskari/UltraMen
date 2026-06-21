<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->input('filter') === 'unread') {
            $query->where('is_read', false);
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        Mail::to($message->email)->send(new ContactReplyMail($message, $validated['reply_message']));

        $message->update([
            'reply_message' => $validated['reply_message'],
            'replied_at'    => now(),
            'is_read'       => true,
        ]);

        return redirect()->back()->with('success', "Reply sent to {$message->email}.");
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted.');
    }
}
