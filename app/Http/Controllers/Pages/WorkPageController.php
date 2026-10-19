<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Project;

class WorkPageController extends Controller
{
    use PageData;

    public function index()
    {
        return view('pages.work', $this->shellData() + [
            'projects' => Project::query()->where('is_published', true)
                ->orderByDesc('is_featured')->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Project $project)
    {
        abort_unless($project->is_published, 404);

        return view('pages.project', $this->shellData() + [
            'project' => $project,
            'relatedProjects' => Project::query()->where('is_published', true)
                ->where('id', '!=', $project->getKey())
                ->orderByDesc('is_featured')->orderBy('sort_order')->limit(3)->get(),
        ]);
    }
}
