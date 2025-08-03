<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)

    {
        // Lấy danh sách loại thiết bị (không bị trùng)
        $deviceTypes = Services::select('device_type_name')->distinct()->get();

        // Lấy slug device_type từ query string
        $selectedType = $request->device_type; // slug

        $query = Services::query();

        if (!empty($selectedType)) {
            // Lọc theo slug của device_type_name
            $query->whereRaw('LOWER(REPLACE(device_type_name, " ", "-")) = ?', [$selectedType]);
        }

        $services = $query->get();

        // Generate SEO data
        $seo = $this->generateMetaTags('home');

        return view('website.pages.home.homepage', [
            'services'     => $services,
            'deviceTypes'  => $deviceTypes,
            'selectedType' => $selectedType,
            'seo'          => $seo,
        ]);
    }

    /**
     * Generate SEO meta tags for home page
     */
    private function generateMetaTags($page = 'home', $data = [])
    {
        $baseUrl = url('/');
        $defaultImage = $baseUrl . '/images/og-image.jpg';

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
            'structured_data' => $this->getHomeStructuredData()
        ];
    }

    /**
     * Generate structured data for homepage
     */
    private function getHomeStructuredData()
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
}
