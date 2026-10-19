<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Skill;

class SkillsPageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.skills', $this->shellData() + [
            'skills' => Skill::query()->where('is_active', true)->orderBy('sort_order')->get()->groupBy('category'),
        ]);
    }
}
