<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;

class ContactPageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.contact', $this->shellData() + [
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
