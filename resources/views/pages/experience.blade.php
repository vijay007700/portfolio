@extends('layouts.app')

@section('content')
<main class="page-shell">
    <section class="page-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">Professional background</p>
            <h1>Experience across web products and platforms.</h1>
            <p class="page-lede">{{ rtrim(rtrim(number_format((float) ($profile?->years_experience ?? 4.5), 1), '0'), '.') }} years of overall experience building client projects with Laravel, PHP, Node.js, frontend frameworks and WordPress.</p>
        </div>
    </section>
    <section class="section-pad">
        <div class="container experience-list">
            @forelse($experiences as $exp)
                <article class="experience-item reveal">
                    <div class="experience-date">{{ optional($exp->start_date)->format('M Y') ?? '—' }}<span>to</span>{{ $exp->is_current ? 'Present' : (optional($exp->end_date)->format('M Y') ?? '—') }}</div>
                    <div class="experience-content"><span class="experience-company">{{ $exp->company }}{{ $exp->employment_type ? ' · '.$exp->employment_type : '' }}</span><h2>{{ $exp->role }}</h2><p>{{ $exp->summary }}</p>@if($exp->highlights)<ul>@foreach(array_filter(preg_split('/\r\n|\r|\n/', $exp->highlights)) as $point)<li>{{ $point }}</li>@endforeach</ul>@endif</div>
                </article>
            @empty
                <div class="experience-snapshot-grid">
                    <article class="service-detail-card reveal"><div class="service-detail-icon">PHP</div><div class="service-detail-copy"><span>Web applications</span><h2>7+ Laravel websites</h2><p>Work includes a B2B e-commerce project for PC Exporters, alongside other Laravel client websites.</p></div></article>
                    <article class="service-detail-card reveal"><div class="service-detail-icon">API</div><div class="service-detail-copy"><span>Mobile backends</span><h2>APIs for 30+ mobile apps</h2><p>Developed Laravel APIs to support mobile applications.</p></div></article>
                    <article class="service-detail-card reveal"><div class="service-detail-icon">JS</div><div class="service-detail-copy"><span>Real-time products</span><h2>Node.js chat &amp; video calling</h2><p>Worked on socket-based chat and video-call features with Node.js.</p></div></article>
                    <article class="service-detail-card reveal"><div class="service-detail-icon">WP</div><div class="service-detail-copy"><span>Websites &amp; learning</span><h2>WordPress and Tutor LMS</h2><p>Customized 10+ winery websites and configured a client-specific quiz experience with Tutor LMS.</p></div></article>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
