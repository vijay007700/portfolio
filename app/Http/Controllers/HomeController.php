<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Integration;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::query()->first();
        $settings = Setting::query()->pluck('value', 'key');
        $services = Service::query()->where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $projects = Project::query()->where('is_published', true)->where('is_featured', true)
            ->orderBy('sort_order')->take(3)->get();
        $skills = Skill::query()->where('is_active', true)->orderBy('sort_order')->get()->groupBy('category');
        $integrations = Integration::query()->where('is_active', true)->orderBy('sort_order')->take(8)->get();
        $experiences = Experience::query()->orderBy('sort_order')->orderByDesc('start_date')->take(2)->get();

        return view('home', compact(
            'profile', 'settings', 'services', 'projects', 'skills', 'integrations', 'experiences'
        ));
    }
}
