<?php

namespace App\Services;

class SEOService
{
    /**
     * Generate SEO meta tags for pages
     */
    public static function generateMetaTags($page = 'home', $data = [])
    {
        $seo = self::getSEOData($page, $data);

        return [
            'title' => $seo['title'],
            'description' => $seo['description'],
            'keywords' => $seo['keywords'],
            'canonical' => $seo['canonical'],
            'og_title' => $seo['og_title'],
            'og_description' => $seo['og_description'],
            'og_image' => $seo['og_image'],
            'og_url' => $seo['og_url'],
            'twitter_title' => $seo['twitter_title'],
            'twitter_description' => $seo['twitter_description'],
            'twitter_image' => $seo['twitter_image'],
            'structured_data' => $seo['structured_data']
        ];
    }

    /**
     * Get SEO data for specific pages
     */
    private static function getSEOData($page, $data = [])
    {
        $baseUrl = url('/');
        $siteName = 'Fixicon';
        $defaultImage = $baseUrl . '/images/og-image.jpg';

        switch ($page) {
            case 'home':
                return [
                    'title' => 'Fixicon - Professional Electronics Repair Services | iPhone, Android, Laptop',
                    'description' => 'Expert electronics repair services for smartphones, tablets, laptops & more. Fast, reliable repairs with warranty. Book online today!',
                    'keywords' => 'electronics repair, phone repair, laptop repair, iPhone repair, Android repair, tablet repair, professional repair services',
                    'canonical' => $baseUrl,
                    'og_title' => 'Fixicon - Professional Electronics Repair Services',
                    'og_description' => 'Expert electronics repair services for smartphones, tablets, laptops & more. Fast, reliable repairs with warranty.',
                    'og_image' => $defaultImage,
                    'og_url' => $baseUrl,
                    'twitter_title' => 'Fixicon - Professional Electronics Repair',
                    'twitter_description' => 'Expert electronics repair services with warranty. Book online today!',
                    'twitter_image' => $defaultImage,
                    'structured_data' => self::getHomeStructuredData()
                ];

            case 'services':
                return [
                    'title' => 'Our Repair Services - Phone, Laptop, Tablet Repair | Fixicon',
                    'description' => 'Browse our comprehensive electronics repair services. iPhone repair, Android repair, laptop repair, tablet repair with warranty.',
                    'keywords' => 'repair services, phone repair services, laptop repair services, electronics repair pricing, repair warranty',
                    'canonical' => $baseUrl . '/services',
                    'og_title' => 'Our Repair Services - Fixicon',
                    'og_description' => 'Browse our comprehensive electronics repair services with warranty.',
                    'og_image' => $defaultImage,
                    'og_url' => $baseUrl . '/services',
                    'twitter_title' => 'Our Repair Services - Fixicon',
                    'twitter_description' => 'Browse our comprehensive electronics repair services with warranty.',
                    'twitter_image' => $defaultImage,
                    'structured_data' => self::getServicesStructuredData()
                ];

            case 'service_detail':
                $service = $data['service'] ?? null;
                $serviceName = $service->device_type_name ?? 'Service';
                $issueCategory = $service->issue_category_name ?? 'Repair';

                return [
                    'title' => $serviceName . ' ' . $issueCategory . ' - Professional Repair | Fixicon',
                    'description' => 'Professional ' . $serviceName . ' ' . $issueCategory . ' service. Expert technicians, quality parts, warranty included. Book online today!',
                    'keywords' => strtolower($serviceName) . ' repair, ' . strtolower($issueCategory) . ', electronics repair, professional repair service',
                    'canonical' => $baseUrl . '/service/' . ($service->id ?? ''),
                    'og_title' => $serviceName . ' ' . $issueCategory . ' - Fixicon',
                    'og_description' => 'Professional ' . $serviceName . ' ' . $issueCategory . ' service with warranty.',
                    'og_image' => $defaultImage,
                    'og_url' => $baseUrl . '/service/' . ($service->id ?? ''),
                    'twitter_title' => $serviceName . ' ' . $issueCategory . ' - Fixicon',
                    'twitter_description' => 'Professional ' . $serviceName . ' ' . $issueCategory . ' service with warranty.',
                    'twitter_image' => $defaultImage,
                    'structured_data' => self::getServiceStructuredData($service)
                ];

            case 'track_order':
                return [
                    'title' => 'Track Your Repair Order - Fixicon',
                    'description' => 'Track the status of your electronics repair order. Get real-time updates on your device repair progress.',
                    'keywords' => 'track order, repair status, order tracking, repair progress',
                    'canonical' => $baseUrl . '/track-order',
                    'og_title' => 'Track Your Repair Order - Fixicon',
                    'og_description' => 'Track the status of your electronics repair order with real-time updates.',
                    'og_image' => $defaultImage,
                    'og_url' => $baseUrl . '/track-order',
                    'twitter_title' => 'Track Your Repair Order - Fixicon',
                    'twitter_description' => 'Track the status of your electronics repair order with real-time updates.',
                    'twitter_image' => $defaultImage,
                    'structured_data' => null
                ];

            default:
                return [
                    'title' => 'Fixicon - Professional Electronics Repair Services',
                    'description' => 'Expert electronics repair services for smartphones, tablets, laptops & more.',
                    'keywords' => 'electronics repair, professional repair services',
                    'canonical' => $baseUrl,
                    'og_title' => 'Fixicon - Professional Electronics Repair Services',
                    'og_description' => 'Expert electronics repair services for smartphones, tablets, laptops & more.',
                    'og_image' => $defaultImage,
                    'og_url' => $baseUrl,
                    'twitter_title' => 'Fixicon - Professional Electronics Repair',
                    'twitter_description' => 'Expert electronics repair services for smartphones, tablets, laptops & more.',
                    'twitter_image' => $defaultImage,
                    'structured_data' => null
                ];
        }
    }

    /**
     * Generate structured data for homepage
     */
    private static function getHomeStructuredData()
    {
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "LocalBusiness",
            "name" => "Fixicon",
            "description" => "Professional electronics repair services",
            "url" => url('/'),
            "telephone" => "+1-234-567-8900",
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "123 Tech Street",
                "addressLocality" => "Tech City",
                "addressRegion" => "TC",
                "postalCode" => "12345",
                "addressCountry" => "US"
            ],
            "openingHours" => [
                "Mo-Fr 09:00-18:00",
                "Sa 09:00-17:00"
            ],
            "priceRange" => "$$",
            "serviceArea" => [
                "@type" => "City",
                "name" => "Tech City"
            ],
            "hasOfferCatalog" => [
                "@type" => "OfferCatalog",
                "name" => "Electronics Repair Services",
                "itemListElement" => [
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Phone Repair"
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Laptop Repair"
                        ]
                    ]
                ]
            ]
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate structured data for services page
     */
    private static function getServicesStructuredData()
    {
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "name" => "Electronics Repair Services",
            "description" => "Complete list of our professional electronics repair services",
            "url" => url('/services')
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate structured data for service detail
     */
    private static function getServiceStructuredData($service)
    {
        if (!$service) return null;

        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "Service",
            "name" => ($service->device_type_name ?? '') . ' ' . ($service->issue_category_name ?? ''),
            "description" => $service->description ?? 'Professional electronics repair service',
            "provider" => [
                "@type" => "LocalBusiness",
                "name" => "Fixicon"
            ],
            "serviceType" => "Electronics Repair",
            "offers" => [
                "@type" => "Offer",
                "price" => $service->price ?? null,
                "priceCurrency" => "USD"
            ]
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate sitemap URLs
     */
    public static function getSitemapUrls()
    {
        $urls = [];
        $baseUrl = url('/');

        // Static pages
        $staticPages = [
            '' => ['priority' => '1.0', 'changefreq' => 'weekly'],
            'services' => ['priority' => '0.9', 'changefreq' => 'monthly'],
            'track-order' => ['priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $path => $config) {
            $urls[] = [
                'url' => $baseUrl . '/' . $path,
                'lastmod' => now()->toISOString(),
                'priority' => $config['priority'],
                'changefreq' => $config['changefreq']
            ];
        }

        // Dynamic service pages
        try {
            $services = \App\Models\Services::where('status', 'active')->get();
            foreach ($services as $service) {
                $urls[] = [
                    'url' => $baseUrl . '/service/' . $service->id,
                    'lastmod' => $service->updated_at->toISOString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly'
                ];
            }
        } catch (\Exception $e) {
            // Handle if Services model doesn't exist yet
        }

        return $urls;
    }
}
