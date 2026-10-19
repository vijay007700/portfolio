<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Integration;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'services' => Service::count(),
            'integrations' => Integration::count(),
            'messages' => ContactMessage::count(),
            'new_messages' => ContactMessage::where('status', 'new')->count(),
        ];

        $recentMessages = ContactMessage::latest()->limit(6)->get();
        $recentProjects = Project::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects'));
    }
}
