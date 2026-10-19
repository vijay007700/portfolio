<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Integration;

class IntegrationsPageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.integrations', $this->shellData() + [
            'integrations' => Integration::query()->where('is_active', true)->orderBy('sort_order')->get()->groupBy('category'),
        ]);
    }
}
