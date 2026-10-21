@extends('layouts.app')

@section('content')
<main class="page-shell">
    <section class="page-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">Technical skills</p>
            <h1>The tools behind the work.</h1>
            <p class="page-lede">4.5 years across Laravel and PHP, with hands-on work in Node.js, Vue.js, React, WordPress, MySQL, SQLite, MongoDB, Supabase and Firebase.</p>
        </div>
    </section>
    <section class="section-pad">
        <div class="container skills-grid">
            @forelse($skills as $category => $group)
                <section class="skill-group reveal">
                    <div class="skill-group-heading"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><h2>{{ $category }}</h2></div>
                    <div class="skill-items">
                        @foreach($group as $skill)
                            <div class="skill-item"><span class="skill-icon">{{ $skill->icon ?: strtoupper(substr($skill->name, 0, 2)) }}</span><div><strong>{{ $skill->name }}</strong>@if($skill->years)<small>{{ rtrim(rtrim(number_format($skill->years, 1), '0'), '.') }} years</small>@endif</div>@if($skill->level)<span class="skill-level">{{ $skill->level }}%</span>@endif</div>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="empty-state"><h2>Skills are being updated</h2><p>Technical skills will appear here soon.</p></div>
            @endforelse
        </div>
    </section>
</main>
@endsection
