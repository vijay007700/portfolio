<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(25);
        return view('admin.messages', compact('messages'));
    }

    public function show(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        if ($message->status === 'new') $message->update(['status' => 'read']);
        return view('admin.message-show', compact('message'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $message = ContactMessage::findOrFail($id);
        $data = $request->validate(['status' => ['required','in:new,read,replied,archived']]);
        $message->update($data);
        return back()->with('success', 'Message status updated.');
    }

    public function destroy(int $id)
    {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
