<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach(['home', 'about', 'skills', 'services', 'work', 'experience', 'integrations', 'contact'] as $page)
        <url>
            <loc>{{ route($page === 'home' ? 'home' : $page) }}</loc>
            <changefreq>monthly</changefreq>
            <priority>{{ $page === 'home' ? '1.0' : '0.7' }}</priority>
        </url>
    @endforeach
    @foreach($projects as $project)
        <url>
            <loc>{{ route('work.show', $project->slug) }}</loc>
            <lastmod>{{ $project->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
