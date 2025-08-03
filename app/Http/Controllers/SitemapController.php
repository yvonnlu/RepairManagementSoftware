<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     */
    public function index()
    {
        // Clear any output buffer to prevent whitespace before XML
        if (ob_get_level()) {
            ob_clean();
        }

        $urls = $this->getSitemapUrls();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['url']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Generate sitemap URLs
     */
    private function getSitemapUrls()
    {
        $urls = [];
        $baseUrl = url('/');

        // Static public pages only (based on existing routes)
        $staticPages = [
            'home' => ['priority' => '1.0', 'changefreq' => 'weekly'],       // Homepage (/home)
            'services' => ['priority' => '0.9', 'changefreq' => 'monthly'],  // Services listing (/services)
        ];

        foreach ($staticPages as $path => $config) {
            $urls[] = [
                'url' => $baseUrl . '/' . $path,
                'lastmod' => now()->toISOString(),
                'priority' => $config['priority'],
                'changefreq' => $config['changefreq']
            ];
        }

        // Dynamic service pages (public service details)
        try {
            $services = \App\Models\Services::get(); // Soft deletes automatically filters active records
            foreach ($services as $service) {
                $urls[] = [
                    'url' => $baseUrl . '/service/' . $service->slug,
                    'lastmod' => $service->updated_at->toISOString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly'
                ];
            }
        } catch (\Exception $e) {
            // If services table doesn't exist yet, skip it
        }

        return $urls;
    }
}
