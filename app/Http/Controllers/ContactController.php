<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'budget' => ['nullable', 'string', 'max:80'],
            'project_type' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['prohibited'],
        ]);

        unset($data['website']);
        $data['status'] = 'new';
        ContactMessage::create($data);

        return back()->with('success', 'Thanks! Your project enquiry has been received.');
    }
}
