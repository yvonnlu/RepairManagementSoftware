<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Services Page -->
    <url>
        <loc>{{ url('/services') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Individual Services -->
    @foreach (\App\Models\Services::where('deleted_at', null)->get() as $service)
        <url>
            <loc>{{ url('/services/' . \Str::slug($service->device_type_name)) }}</loc>
            <lastmod>{{ $service->updated_at->toDateString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
            @if ($service->hasImage())
                <image:image>
                    <image:loc>{{ $service->image_url }}</image:loc>
                    <image:title>{{ $service->issue_category_name }}</image:title>
                    <image:caption>{{ $service->description }}</image:caption>
                </image:image>
            @endif
        </url>
    @endforeach

    <!-- About Page -->
    <url>
        <loc>{{ url('/about') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Contact Page -->
    <url>
        <loc>{{ url('/contact') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

</urlset>
