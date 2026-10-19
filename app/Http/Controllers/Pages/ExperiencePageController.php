<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Experience;

class ExperiencePageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.experience', $this->shellData() + [
            'experiences' => Experience::query()->orderBy('sort_order')->orderByDesc('start_date')->get(),
        ]);
    }
}
