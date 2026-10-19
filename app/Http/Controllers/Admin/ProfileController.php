<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate([], ['name' => 'Your Name', 'title' => 'Laravel Developer']);
        return view('admin.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::firstOrCreate([], ['name' => 'Your Name', 'title' => 'Laravel Developer']);
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'title' => ['required','string','max:180'],
            'hero_title' => ['required','string','max:300'],
            'hero_subtitle' => ['required','string','max:800'],
            'bio' => ['required','string','max:5000'],
            'email' => ['nullable','email','max:180'],
            'phone' => ['nullable','string','max:50'],
            'location' => ['nullable','string','max:120'],
            'photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'resume_url' => ['nullable','string','max:255'],
            'github_url' => ['nullable','url','max:255'],
            'linkedin_url' => ['nullable','url','max:255'],
            'upwork_url' => ['nullable','url','max:255'],
            'years_experience' => ['required','numeric','min:0','max:50'],
            'apps_apis' => ['required','integer','min:0'],
            'websites' => ['required','integer','min:0'],
            'wordpress_sites' => ['required','integer','min:0'],
            'availability' => ['nullable','string','max:160'],
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['photo'] = 'uploads/'.$filename;
        } else {
            unset($data['photo']);
        }

        $profile->update($data);
        return back()->with('success', 'Profile updated successfully.');
    }
}
