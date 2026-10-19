@extends('layouts.app')

@section('content')
<main class="page-shell">
    <section class="page-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">Technologies & integrations</p>
            <h1>Connecting the pieces your product relies on.</h1>
            <p class="page-lede">Tools, platforms and integration patterns managed from one place.</p>
        </div>
    </section>
    <section class="section-pad">
        <div class="container integration-groups">
            @forelse($integrations as $category => $group)
                <section class="integration-group reveal">
                    <div class="integration-group-heading"><p class="eyebrow">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p><h2>{{ $category }}</h2></div>
                    <div class="integration-grid">
                        @foreach($group as $integration)
                            <article class="integration-card"><span>{{ $integration->icon ?: strtoupper(substr($integration->name, 0, 2)) }}</span><div><h3>{{ $integration->name }}</h3><p>{{ $integration->description }}</p></div></article>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="empty-state"><h2>Integration details coming soon</h2><p>Relevant tools and platforms will be listed here.</p></div>
            @endforelse
        </div>
    </section>
</main>
@endsection
