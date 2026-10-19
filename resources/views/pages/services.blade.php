@extends('layouts.app')

@section('content')
<main class="page-shell">
    <section class="page-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">Services</p>
            <h1>Focused development for your next step.</h1>
            <p class="page-lede">From a new Laravel application to a well-scoped backend improvement, the work starts with your requirements.</p>
        </div>
    </section>
    <section class="section-pad">
        <div class="container service-list">
            @forelse($services as $service)
                <article class="service-detail-card reveal">
                    <div class="service-detail-icon">{{ $service->icon ?: 'DEV' }}</div>
                    <div class="service-detail-copy"><span>Service {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $service->title }}</h2><p>{{ $service->description ?: $service->short_description }}</p></div>
                    <a class="service-arrow" href="{{ route('contact') }}" aria-label="Ask about {{ $service->title }}">↗</a>
                </article>
            @empty
                <div class="empty-state"><h2>Services are being updated</h2><p>Get in touch to discuss your project.</p><a class="inline-link" href="{{ route('contact') }}">Contact me ↗</a></div>
            @endforelse
        </div>
    </section>
</main>
@endsection
