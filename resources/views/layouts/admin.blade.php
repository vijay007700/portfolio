<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>@yield('title','Admin') · Portfolio</title><link rel="stylesheet" href="{{ asset('css/admin.css') }}"></head>
<body class="admin-body">
<aside class="sidebar"><a class="admin-brand" href="{{ route('admin.dashboard') }}"><span>&lt;/&gt;</span><b>PORTFOLIO<br>CONTROL</b></a>
<nav>
<a class="{{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">▦ Dashboard</a>
<a class="{{ request()->routeIs('admin.profile.*')?'active':'' }}" href="{{ route('admin.profile.edit') }}">◉ Profile</a>
<a class="{{ request()->routeIs('admin.skills.*')?'active':'' }}" href="{{ route('admin.skills.index') }}">⌁ Skills</a>
<a class="{{ request()->routeIs('admin.experiences.*')?'active':'' }}" href="{{ route('admin.experiences.index') }}">◫ Experience</a>
<a class="{{ request()->routeIs('admin.services.*')?'active':'' }}" href="{{ route('admin.services.index') }}">✦ Services</a>
<a class="{{ request()->routeIs('admin.projects.*')?'active':'' }}" href="{{ route('admin.projects.index') }}">▣ Projects</a>
<a class="{{ request()->routeIs('admin.integrations.*')?'active':'' }}" href="{{ route('admin.integrations.index') }}">↔ Integrations</a>
<a class="{{ request()->routeIs('admin.testimonials.*')?'active':'' }}" href="{{ route('admin.testimonials.index') }}">★ Testimonials</a>
<a class="{{ request()->routeIs('admin.messages.*')?'active':'' }}" href="{{ route('admin.messages.index') }}">✉ Messages</a>
<a class="{{ request()->routeIs('admin.settings.*')?'active':'' }}" href="{{ route('admin.settings.edit') }}">⚙ Settings</a>
</nav><div class="sidebar-bottom"><a target="_blank" href="{{ route('home') }}">View website ↗</a><form method="post" action="{{ route('admin.logout') }}">@csrf<button>Log out</button></form></div></aside>
<div class="admin-shell"><header class="admin-topbar"><button class="mobile-menu" id="adminMenu">☰</button><div><span>Portfolio Manager</span><b>{{ auth()->user()->name }}</b></div><a class="view-site" target="_blank" href="{{ route('home') }}">Open frontend ↗</a></header><main class="admin-main">@if(session('success'))<div class="admin-alert success">{{ session('success') }}</div>@endif @if($errors->any())<div class="admin-alert error"><b>Please fix:</b><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif @yield('content')</main></div>
<script>document.getElementById('adminMenu')?.addEventListener('click',()=>document.body.classList.toggle('sidebar-open'));</script></body></html>
