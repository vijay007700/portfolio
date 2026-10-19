@extends('layouts.app')

@section('title', $project->seo_title ?: ($project->title.' · '.($profile?->name ?: 'Portfolio')))
@section('meta_description', $project->seo_description ?: $project->summary)

@section('content')
@php
    $technologies = array_values(array_filter(array_map('trim', explode(',', $project->tech_stack ?? ''))));
    $responsibilities = array_filter(preg_split('/\r\n|\r|\n/', $project->responsibilities ?? ''));
    $cover = ($project->image ?: 'images/project-1.svg').'?v=20261019';
@endphp
<main class="page-shell project-page">
    <section class="project-hero">
        <div class="container">
            <a class="back-link" href="{{ route('work') }}"><span aria-hidden="true">←</span> All projects</a>
            <div class="project-hero-copy reveal">
                <div class="eyebrow">{{ $project->type ?: 'Project' }} @if($project->is_demo)<span class="demo-inline">· Demo project</span>@endif</div>
                <h1>{{ $project->title }}</h1>
                <p class="page-lede">{{ $project->summary }}</p>
                @if($project->project_url)
                    <a class="btn btn-primary" href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer">Visit live project <span aria-hidden="true">↗</span></a>
                @endif
            </div>
            <figure class="project-cover reveal" data-delay="100"><img src="{{ asset($cover) }}" alt="{{ $project->title }} project screenshot"></figure>
        </div>
    </section>

    <section class="section-pad project-overview-section">
        <div class="container project-overview-grid">
            <div class="project-section-heading reveal"><p class="eyebrow">01 / Overview</p><h2>What the project does</h2></div>
            <div class="project-overview-copy reveal" data-delay="80">
                <p>{{ $project->description ?: $project->summary }}</p>
                @if(count($technologies))
                    <div class="project-tech-list"><h3>Built with</h3><div class="tech-tags">@foreach($technologies as $technology)<span>{{ $technology }}</span>@endforeach</div></div>
                @endif
            </div>
        </div>
    </section>

    @if($project->problem || $project->solution)
        <section class="section-pad project-story-section">
            <div class="container project-story-grid">
                @if($project->problem)<article class="project-story-card reveal"><p class="eyebrow">02 / The challenge</p><h2>Problem</h2><p>{{ $project->problem }}</p></article>@endif
                @if($project->solution)<article class="project-story-card reveal" data-delay="80"><p class="eyebrow">03 / The approach</p><h2>Solution</h2><p>{{ $project->solution }}</p></article>@endif
            </div>
        </section>
    @endif

    @if(count($responsibilities))
        <section class="section-pad project-responsibility-section">
            <div class="container project-responsibility-grid">
                <div class="project-section-heading reveal"><p class="eyebrow">My contribution</p><h2>Responsibilities</h2></div>
                <ul class="responsibility-list reveal" data-delay="80">@foreach($responsibilities as $responsibility)<li>{{ $responsibility }}</li>@endforeach</ul>
            </div>
        </section>
    @endif

    @if($project->screenshots && count($project->screenshots))
        <section class="section-pad project-screenshots-section">
            <div class="container"><div class="section-heading reveal"><div><p class="eyebrow">Project preview</p><h2>Screenshots</h2></div></div>
                <div class="project-screenshot-grid">@foreach($project->screenshots as $screenshot)<figure class="project-screenshot reveal" data-delay="{{ $loop->index * 60 }}"><img src="{{ asset($screenshot) }}" alt="{{ $project->title }} screenshot {{ $loop->iteration }}" loading="lazy"></figure>@endforeach</div>
            </div>
        </section>
    @endif

    @if($relatedProjects->count())
        <section class="section-pad related-projects-section">
            <div class="container"><div class="section-heading reveal"><div><p class="eyebrow">Keep exploring</p><h2>More projects</h2></div><a class="inline-link" href="{{ route('work') }}">All work <span aria-hidden="true">↗</span></a></div>
                <div class="project-grid related-project-grid">@foreach($relatedProjects as $related)
                    <a class="project-card reveal" href="{{ route('work.show', $related->slug) }}" data-tilt><div class="project-card-image"><img src="{{ asset($related->image ?: 'images/project-1.svg') }}?v=20261019" alt="{{ $related->title }} project preview" loading="lazy"></div><div class="project-card-content"><div class="project-card-meta"><span>{{ $related->type }}</span><span aria-hidden="true">↗</span></div><h3>{{ $related->title }}</h3><p>{{ $related->summary }}</p></div></a>
                @endforeach</div>
            </div>
        </section>
    @endif
</main>
@endsection
