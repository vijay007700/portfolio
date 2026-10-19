@extends('layouts.app')

@section('content')
@php
    $categories = $projects->pluck('type')->filter()->unique()->values();
@endphp
<main class="page-shell">
    <section class="page-hero work-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">Selected work <span>— {{ str_pad($projects->count(), 2, '0', STR_PAD_LEFT) }} projects</span></p>
            <h1>Work built to solve<br><span>real problems.</span></h1>
            <p class="page-lede">Work across 7+ Laravel websites, mobile APIs, Node.js real-time features and WordPress websites.</p>
            @if($categories->isNotEmpty())
                <div class="filter-bar" aria-label="Filter projects">
                    <button class="active" type="button" data-filter="all" aria-pressed="true">All projects</button>
                    @foreach($categories as $category)
                        <button type="button" data-filter="{{ \Illuminate\Support\Str::slug($category) }}" aria-pressed="false">{{ $category }}</button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="section-pad work-list-section">
        <div class="container project-grid portfolio-grid">
            @if($projects->isNotEmpty())
                @foreach($projects as $project)
                    @php
                        $filter = \Illuminate\Support\Str::slug(($project->type ?? '').' '.$project->tech_stack);
                        $fallbackImage = 'images/project-'.((($loop->iteration - 1) % 6) + 1).'.svg';
                        $projectTechnologies = array_slice(array_filter(array_map('trim', explode(',', $project->tech_stack ?? ''))), 0, 4);
                    @endphp
                <a class="project-card portfolio-card reveal" href="{{ route('work.show', $project->slug) }}" data-project="{{ $filter }}" data-delay="{{ $loop->index * 60 }}" data-tilt>
                    <div class="project-card-image">
                        <img src="{{ asset($project->image ?: $fallbackImage) }}?v=20261019" alt="{{ $project->title }} project preview" loading="lazy">
                        @if($project->is_demo)<span class="demo-badge">Demo project</span>@endif
                    </div>
                    <div class="project-card-content">
                        <div class="project-card-meta"><span>{{ $project->type ?: 'Web application' }}</span><span aria-hidden="true">↗</span></div>
                        <h2>{{ $project->title }}</h2>
                        <p>{{ $project->summary ?: $project->description }}</p>
                        <div class="tech-tags">
                            @foreach($projectTechnologies as $technology)
                                <span>{{ $technology }}</span>
                            @endforeach
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="empty-state"><span class="empty-mark">01</span><h2>Projects coming soon</h2><p>Published project case studies will appear here.</p></div>
            @endif
        </div>
    </section>
</main>
@endsection
