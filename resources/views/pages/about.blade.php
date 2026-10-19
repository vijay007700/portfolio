@extends('layouts.app')

@section('content')
@php
    $bio = $profile?->bio ?: 'I am a full-stack web developer with 4.5 years of overall experience across Laravel, Core PHP, CodeIgniter, Node.js, Vue.js, React and WordPress. I have worked on 7+ Laravel websites, including a B2B e-commerce project for PC Exporters, and built mobile APIs used by 30+ apps. My Node.js work includes socket-based chat and video-call features. My WordPress work includes 10+ winery websites and a client-tailored quiz setup using Tutor LMS.';
    $statCount = (int) (bool) ($profile?->years_experience) + (int) (bool) ($profile?->apps_apis) + (int) (bool) ($profile?->websites) + (int) (bool) ($profile?->wordpress_sites);
@endphp
<main class="page-shell">
    <section class="page-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">About me</p>
            <h1>{{ $profile?->name ?: 'Laravel / PHP Developer' }}</h1>
            <p class="page-lede">{{ $bio }}</p>
            <div class="profile-facts">
                <span>{{ $profile?->title ?: 'Laravel / PHP Developer' }}</span>
                @if($profile?->location)<span>{{ $profile->location }}</span>@endif
                @if($profile?->availability)<span>{{ $profile->availability }}</span>@endif
            </div>
        </div>
    </section>

    <section class="section-pad">
        <div class="container about-layout">
            <div class="about-section-heading reveal"><p class="eyebrow">How I work</p><h2>Client requirements, turned into useful products.</h2></div>
            <div class="principle-list">
                <article class="principle-card reveal"><span>01</span><div><h3>Understand the requirement</h3><p>I start by clarifying the user flow, business rules and constraints before choosing an implementation.</p></div></article>
                <article class="principle-card reveal"><span>02</span><div><h3>Keep the foundation maintainable</h3><p>Database structure, validation and application responsibilities should be clear as the product grows.</p></div></article>
                <article class="principle-card reveal"><span>03</span><div><h3>Make the experience practical</h3><p>Admin tools, forms and responsive interfaces should help people finish their work without friction.</p></div></article>
            </div>
        </div>
    </section>

    @if(($profile?->years_experience ?? 0) || ($profile?->apps_apis ?? 0) || ($profile?->websites ?? 0) || ($profile?->wordpress_sites ?? 0))
        <section class="section-pad stats-section">
            <div class="container stats-grid stats-count-{{ $statCount }}" style="--stat-count: {{ $statCount }}">
                @if($profile?->years_experience)<article><strong>{{ rtrim(rtrim(number_format((float) $profile->years_experience, 1), '0'), '.') }}+</strong><span>Years of overall experience</span></article>@endif
                @if($profile?->apps_apis)<article><strong>{{ $profile->apps_apis }}+</strong><span>Mobile apps supported by APIs</span></article>@endif
                @if($profile?->websites)<article><strong>{{ $profile->websites }}+</strong><span>Laravel websites</span></article>@endif
                @if($profile?->wordpress_sites)<article><strong>{{ $profile->wordpress_sites }}+</strong><span>WordPress winery websites</span></article>@endif
            </div>
        </section>
    @endif

    @if($testimonials->count())
        <section class="section-pad">
            <div class="container"><div class="section-heading"><div><p class="eyebrow">Client feedback</p><h2>What people say</h2></div></div>
                <div class="testimonial-grid">
                    @foreach($testimonials as $testimonial)
                        <blockquote class="testimonial-card"><div class="quote-mark">“</div><p>{{ $testimonial->quote }}</p><footer><strong>{{ $testimonial->client_name }}</strong><span>{{ $testimonial->client_role }} {{ $testimonial->company ? '· '.$testimonial->company : '' }}</span></footer></blockquote>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>
@endsection
