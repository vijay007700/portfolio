<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class AboutPageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.about', $this->shellData() + [
            'testimonials' => Testimonial::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
