<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Integration;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function profile(): JsonResponse
    {
        $profile = Profile::query()->first();

        if (!$profile) {
            return response()->json(['data' => null]);
        }

        $data = $profile->only([
            'name', 'title', 'hero_title', 'hero_subtitle', 'bio', 'email', 'phone',
            'location', 'photo', 'resume_url', 'github_url', 'linkedin_url', 'upwork_url', 'availability',
        ]);
        $data['photo'] = $profile->photo ? asset($profile->photo) : null;

        return response()->json(['data' => $data]);
    }

    public function projects(Request $request): JsonResponse
    {
        $query = Project::query()->where('is_published', true)
            ->orderByDesc('is_featured')->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('type', $request->string('category')->toString());
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $projects = $query->paginate(min(max($request->integer('per_page', 12), 1), 50));

        return response()->json([
            'data' => $projects->getCollection()->map(fn (Project $project): array => $this->projectData($project)),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total(),
            ],
        ]);
    }

    public function project(Project $project): JsonResponse
    {
        abort_unless($project->is_published, 404);

        return response()->json(['data' => $this->projectData($project, true)]);
    }

    public function skills(): JsonResponse
    {
        $skills = Skill::query()->where('is_active', true)->orderBy('sort_order')->get();

        return response()->json(['data' => $skills->groupBy('category')->map(fn ($items) => $items->map(
            fn (Skill $skill): array => $skill->only(['name', 'category', 'level', 'years', 'icon'])
        ))]);
    }

    public function services(): JsonResponse
    {
        return response()->json(['data' => Service::query()->where('is_active', true)
            ->orderBy('sort_order')->get(['icon', 'title', 'short_description', 'description'])]);
    }

    public function experience(): JsonResponse
    {
        return response()->json(['data' => Experience::query()->orderBy('sort_order')->orderByDesc('start_date')
            ->get(['role', 'company', 'employment_type', 'start_date', 'end_date', 'is_current', 'summary', 'highlights'])]);
    }

    public function integrations(): JsonResponse
    {
        return response()->json(['data' => Integration::query()->where('is_active', true)
            ->orderBy('sort_order')->get(['name', 'category', 'description', 'icon'])]);
    }

    public function testimonials(): JsonResponse
    {
        return response()->json(['data' => Testimonial::query()->where('is_active', true)
            ->orderBy('sort_order')->get(['client_name', 'client_role', 'company', 'quote', 'rating', 'avatar'])]);
    }

    public function contact(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'budget' => ['nullable', 'string', 'max:80'],
            'project_type' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['prohibited'],
        ]);

        unset($data['website']);
        $data['status'] = 'new';
        ContactMessage::create($data);

        return response()->json(['message' => 'Your enquiry has been received.'], 201);
    }

    private function projectData(Project $project, bool $detailed = false): array
    {
        $data = [
            'title' => $project->title,
            'slug' => $project->slug,
            'category' => $project->type,
            'summary' => $project->summary,
            'technologies' => array_values(array_filter(array_map('trim', explode(',', $project->tech_stack ?? '')))),
            'image' => $project->image ? asset($project->image) : null,
            'screenshots' => array_map(fn (string $path): string => asset($path), $project->screenshots ?? []),
            'live_url' => $project->project_url,
            'featured' => $project->is_featured,
            'demo' => $project->is_demo,
            'url' => route('work.show', $project->slug),
        ];

        if ($detailed) {
            $data += [
                'overview' => $project->description,
                'problem' => $project->problem,
                'solution' => $project->solution,
                'responsibilities' => $project->responsibilities,
                'seo_title' => $project->seo_title,
                'seo_description' => $project->seo_description,
            ];
        }

        return $data;
    }
}
