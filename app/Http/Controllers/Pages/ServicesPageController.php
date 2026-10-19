<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServicesPageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.services', $this->shellData() + [
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
