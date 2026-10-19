@extends('layouts.app')

@section('content')
@php
    $profileName = $profile?->name && $profile->name !== 'Your Name' ? $profile->name : 'a Developer';
    $role = $profile?->title ?: 'Full-Stack Developer';
    $heroSubtitle = $profile?->hero_subtitle ?: 'Full-stack developer with 4.5 years of experience and work across 7+ Laravel websites, including a B2B e-commerce project for PC Exporters.';
    $roles = array_values(array_unique(array_filter([$role, 'Laravel Developer', 'Node.js Developer', 'WordPress Developer'])));
    $technologies = ['Laravel', 'PHP', 'Node.js', 'Vue.js', 'React', 'WordPress'];
    $resumeUrl = $profile?->resume_url;
    if ($resumeUrl && !\Illuminate\Support\Str::startsWith($resumeUrl, ['http://', 'https://'])) {
        $resumeUrl = asset($resumeUrl);
    }
@endphp

<main class="page-shell">
    <section class="hero-home space-hero" id="home">
        <div class="space-stars" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
        <div class="container hero-layout">
            <div class="hero-copy reveal">
                <div class="availability-pill"><span></span>{{ $profile?->availability ?: 'Open to opportunities' }}</div>
                <h1>Hi! I'm <span class="hero-name">{{ $profileName }}</span><br><span class="type-line"><span class="typewriter" data-roles='@json($roles)'>{{ $role }}</span><i aria-hidden="true"></i></span></h1>
                <p class="hero-description">{{ $heroSubtitle }}</p>

                <div class="hero-proof">
                    <span class="proof-icon" aria-hidden="true">&lt;/&gt;</span>
                    <div><strong>Web apps, mobile APIs &amp; real-time features</strong><p>@foreach($technologies as $technology)<span>{{ $technology }}</span>@endforeach</p></div>
                    <span class="proof-star" aria-hidden="true">✦</span>
                </div>

                <p class="hero-quote">“Turning ideas into reliable software.”</p>
                <div class="hero-actions">
                    @if($resumeUrl)
                        <a class="hero-resume-link" href="{{ $resumeUrl }}" target="_blank" rel="noopener noreferrer">My Resume <span aria-hidden="true">↗</span></a>
                    @else
                        <a class="hero-resume-link" href="{{ route('contact') }}">Let's work together <span aria-hidden="true">↗</span></a>
                    @endif
                    <a class="hero-contact-link" href="{{ route('work') }}">Explore projects <span aria-hidden="true">↓</span></a>
                </div>
                <div class="hero-socials">
                    @if($profile?->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer">GitHub ↗</a>@endif
                    @if($profile?->linkedin_url)<a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a>@endif
                    @if($profile?->upwork_url)<a href="{{ $profile->upwork_url }}" target="_blank" rel="noopener noreferrer">Upwork ↗</a>@endif
                </div>
            </div>

            <div class="hero-visual reveal" data-delay="120">
                <span class="orbit orbit-one" aria-hidden="true"></span>
                <span class="orbit orbit-two" aria-hidden="true"></span>
                <span class="orbit orbit-three" aria-hidden="true"></span>
                <img class="developer-art" src="{{ asset('images/developer-illustration.svg') }}" alt="Illustration of a developer working at a laptop">
                <div class="float-label float-label-one"><span>✦</span> Laravel</div>
                <div class="float-label float-label-two"><span>◈</span> Node.js</div>
            </div>
        </div>
    </section>

    <section class="section-pad home-projects" id="projects">
        <div class="container">
            <div class="section-heading reveal">
                <div><p class="eyebrow">Selected work</p><h2>Featured projects</h2></div>
                <a class="inline-link" href="{{ route('work') }}">All projects <span aria-hidden="true">↗</span></a>
            </div>
            <div class="project-grid">
                @forelse($projects as $project)
                    <a class="project-card reveal" href="{{ route('work.show', $project->slug) }}" data-delay="{{ $loop->index * 70 }}" data-tilt>
                        <div class="project-card-image">
                            <img src="{{ asset($project->image ?: 'images/project-'.(($loop->iteration - 1) % 6 + 1).'.svg') }}?v=20261019" alt="{{ $project->title }} project preview" loading="lazy">
                            @if($project->is_demo)<span class="demo-badge">Demo project</span>@endif
                        </div>
                        <div class="project-card-content">
                            <div class="project-card-meta"><span>{{ $project->type }}</span><span aria-hidden="true">↗</span></div>
                            <h3>{{ $project->title }}</h3>
                            <p>{{ $project->summary }}</p>
                            <div class="tech-tags">@foreach(array_slice(array_filter(array_map('trim', explode(',', $project->tech_stack ?? ''))), 0, 4) as $technology)<span>{{ $technology }}</span>@endforeach</div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state"><h3>Projects coming soon</h3><p>Published project case studies will appear here.</p></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-pad services-section" id="services">
        <div class="container">
            <div class="section-heading reveal">
                <div><p class="eyebrow">What I can help with</p><h2>Services</h2></div>
                <a class="inline-link" href="{{ route('services') }}">Explore services <span aria-hidden="true">↗</span></a>
            </div>
            <div class="service-grid">
                @foreach($services->take(4) as $service)
                    <article class="service-card reveal" data-delay="{{ $loop->index * 60 }}">
                        <div class="service-card-top"><span>{{ $service->icon ?: 'DEV' }}</span><small>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</small></div>
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->short_description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-pad approach-section">
        <div class="container approach-layout">
            <div class="approach-intro reveal"><p class="eyebrow">My approach</p><h2>Good software starts with understanding the problem.</h2><p>I keep the process collaborative and straightforward, from the first requirements discussion through delivery.</p></div>
            <div class="approach-steps">
                <article class="approach-step reveal"><span>01</span><div><h3>Understand</h3><p>Clarify users, business rules and the outcome you need.</p></div></article>
                <article class="approach-step reveal"><span>02</span><div><h3>Plan</h3><p>Shape the database, application flow and API contracts.</p></div></article>
                <article class="approach-step reveal"><span>03</span><div><h3>Build</h3><p>Implement in clear, maintainable steps and review as we go.</p></div></article>
                <article class="approach-step reveal"><span>04</span><div><h3>Deliver</h3><p>Prepare the release and hand over the work with context.</p></div></article>
            </div>
        </div>
    </section>

    <section class="contact-cta-section">
        <div class="container contact-cta reveal">
            <div><p class="eyebrow">Have a project in mind?</p><h2>Let's build something useful.</h2></div>
            <a class="btn btn-primary" href="{{ route('contact') }}">Start a conversation <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>
@endsection
