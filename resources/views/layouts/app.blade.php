<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $pageTitle = trim($__env->yieldContent('title')) ?: ($settings['seo_title'] ?? (($profile->name ?? 'Developer').' · Portfolio'));
        $pageDescription = trim($__env->yieldContent('meta_description')) ?: ($settings['seo_description'] ?? 'Laravel and PHP developer portfolio');
        $brandName = $settings['site_name'] ?? 'Developer Portfolio';
        $brandMark = collect(explode(' ', $brandName))->filter()->take(2)
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('') ?: 'DP';
        $avatarName = $profile?->name && $profile->name !== 'Your Name' ? $profile->name : 'Developer';
        $avatarMark = mb_strtoupper(mb_substr($avatarName, 0, 1));
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="theme-color" content="#f6f8fc">
    <script>document.documentElement.classList.add('js');</script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
</head>
<body>
    <header class="site-header" id="top">
        <div class="container nav-wrap">
            <a class="brand" href="{{ route('home') }}">
                @if($profile?->photo)
                    <img class="brand-avatar" src="{{ asset($profile->photo) }}" alt="{{ $profile->name }}">
                @else
                    <span class="brand-mark">{{ $avatarMark }}</span>
                @endif
            </a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="siteNav"><span></span><span></span><span></span></button>
            <nav class="nav" id="siteNav">
                <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#home">Home</a>
                <a class="{{ request()->routeIs('skills') ? 'active' : '' }}" href="{{ route('skills') }}">Skills</a>
                <a class="{{ request()->routeIs('work*') ? 'active' : '' }}" href="{{ route('work') }}">Projects</a>
                <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            </nav>
            @if($profile?->resume_url)
                <a class="header-resume" href="{{ \Illuminate\Support\Str::startsWith($profile->resume_url, ['http://', 'https://']) ? $profile->resume_url : asset($profile->resume_url) }}" target="_blank" rel="noopener noreferrer">My Resume <span aria-hidden="true">↗</span></a>
            @else
                <a class="header-resume" href="{{ route('contact') }}">Let's talk <span aria-hidden="true">↗</span></a>
            @endif
        </div>
    </header>

    <a class="skip-link" href="#main-content">Skip to content</a>
    <div id="main-content" tabindex="-1">@yield('content')</div>

    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <div class="brand footer-brand"><span class="brand-mark">{{ $brandMark }}</span><span>{{ $brandName }}</span></div>
                <p>{{ $settings['footer_text'] ?? 'Laravel and PHP development focused on reliable applications and clear business logic.' }}</p>
            </div>
            <div class="footer-links">
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('skills') }}">Skills</a>
                <a href="{{ route('services') }}">Services</a>
                <a href="{{ route('work') }}">Projects</a>
                <a href="{{ route('experience') }}">Experience</a>
                <a href="{{ route('integrations') }}">Integrations</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            <span class="footer-note">© {{ date('Y') }} {{ $profile?->name ?: 'Your Name' }}</span>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
</body>
</html>
