<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::query()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required','string','max:120'],
            'seo_title' => ['nullable','string','max:180'],
            'seo_description' => ['nullable','string','max:300'],
            'cta_title' => ['nullable','string','max:180'],
            'cta_text' => ['nullable','string','max:600'],
            'footer_text' => ['nullable','string','max:300'],
            'accent_label' => ['nullable','string','max:60'],
        ]);

        foreach ($data as $key => $value) Setting::putValue($key, $value);
        return back()->with('success', 'Site settings updated.');
    }
}
