@extends('layouts.app')

@section('content')
<main class="page-shell">
    <section class="page-hero">
        <div class="container page-intro reveal">
            <p class="eyebrow">Contact</p>
            <h1>{{ $settings['cta_title'] ?? 'Have a project in mind?' }}</h1>
            <p class="page-lede">{{ $settings['cta_text'] ?? 'Tell me a little about the project and what you are looking to build.' }}</p>
        </div>
    </section>
    <section class="section-pad">
        <div class="container contact-layout">
            <aside class="contact-details reveal">
                <p class="eyebrow">Get in touch</p>
                <h2>Let's talk about your project.</h2>
                <p>Share the goal, the current challenge and any timeline you have in mind. I will get back to you to discuss next steps.</p>
                <div class="contact-methods">
                    @if($profile?->email)<a href="mailto:{{ $profile->email }}"><span>Email</span><strong>{{ $profile->email }}</strong><b>↗</b></a>@endif
                    @if($profile?->linkedin_url)<a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer"><span>LinkedIn</span><strong>Connect with me</strong><b>↗</b></a>@endif
                    @if($profile?->upwork_url)<a href="{{ $profile->upwork_url }}" target="_blank" rel="noopener noreferrer"><span>Upwork</span><strong>View my profile</strong><b>↗</b></a>@endif
                    @if($profile?->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer"><span>GitHub</span><strong>View my work</strong><b>↗</b></a>@endif
                    @if($profile?->location)<div class="contact-location"><span>Location</span><strong>{{ $profile->location }}</strong></div>@endif
                </div>
            </aside>

            <section class="contact-form-wrap reveal" data-delay="80">
                @if(session('success'))<div class="form-alert success">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="form-alert error">Please review the form and try again.</div>@endif
                <form class="contact-form" action="{{ route('contact.store') }}" method="post">
                    @csrf
                    <label class="form-honeypot" aria-hidden="true">Leave this field empty<input name="website" tabindex="-1" autocomplete="off"></label>
                    <div class="form-grid">
                        <label>Your name<input name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name"></label>
                        <label>Email address<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com"></label>
                    </div>
                    <div class="form-grid">
                        <label>Company <span>(optional)</span><input name="company" value="{{ old('company') }}" autocomplete="organization" placeholder="Company or brand"></label>
                        <label>Project type <span>(optional)</span><select name="project_type"><option value="">Select a project type</option><option @selected(old('project_type') === 'Laravel application')>Laravel application</option><option @selected(old('project_type') === 'API / integration')>API / integration</option><option @selected(old('project_type') === 'PHP development')>PHP development</option><option @selected(old('project_type') === 'Other')>Other</option></select></label>
                    </div>
                    <label>Project details<textarea name="message" rows="6" required placeholder="What are you looking to build or improve?">{{ old('message') }}</textarea></label>
                    <button class="btn btn-primary" type="submit">Send message <span aria-hidden="true">↗</span></button>
                    <p class="form-note">Your message will be stored securely and used to respond to this enquiry.</p>
                </form>
            </section>
        </div>
    </section>
</main>
@endsection
