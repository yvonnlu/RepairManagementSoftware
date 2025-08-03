<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
        // $service là một instance của Services model với các properties:
        // - id
        // - device_type_name
        // - issue_category_name
        // - description
        // - image_url
        // - created_at
        // - updated_at

        $services = $query->get();

        // Group services by device_type_name
        $servicesByDevice = $services->groupBy('device_type_name');

        $cart = session('cart', []);

        // Generate SEO data
        $seo = $this->generateMetaTags('services');

        return view('website.pages.services.service', [
            'services'        => $services,
            'deviceTypes'     => $deviceTypes,
            'selectedType'    => $selectedType,
            'servicesByDevice' => $servicesByDevice,
            'cart'            => $cart,
            'seo'             => $seo,
        ]);
    }

    public function detail(Services $service)
    {
        // Generate SEO data for service detail
        $seo = $this->generateMetaTags('service_detail', ['service' => $service]);

        // Get related services (same device type, different issue category)
        $relatedServices = Services::where('device_type_name', $service->device_type_name)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        // Get cart data
        $cart = session('cart', []);

        return view('website.pages.services.detail', [
            'service' => $service,
            'relatedServices' => $relatedServices,
            'cart' => $cart,
            'seo' => $seo,
        ]);
    }

    /**
     * Generate SEO meta tags for pages
     */
    private function generateMetaTags($page = 'services', $data = [])
    {
        $baseUrl = url('/');
        $defaultImage = $baseUrl . '/images/og-image.jpg';

        switch ($page) {
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
                    'structured_data' => $this->getServicesStructuredData()
                ];

            case 'service_detail':
                $service = $data['service'] ?? null;
                $serviceName = $service->device_type_name ?? 'Service';
                $issueCategory = $service->issue_category_name ?? 'Repair';

                return [
                    'title' => $serviceName . ' ' . $issueCategory . ' - Professional Repair | Fixicon',
                    'description' => 'Professional ' . $serviceName . ' ' . $issueCategory . ' service. Expert technicians, quality parts, warranty included. Book online today!',
                    'keywords' => strtolower($serviceName) . ' repair, ' . strtolower($issueCategory) . ', electronics repair, professional repair service',
                    'canonical' => $baseUrl . '/service/' . ($service->slug ?? ''),
                    'og_title' => $serviceName . ' ' . $issueCategory . ' - Fixicon',
                    'og_description' => 'Professional ' . $serviceName . ' ' . $issueCategory . ' service with warranty.',
                    'og_image' => $defaultImage,
                    'og_url' => $baseUrl . '/service/' . ($service->slug ?? ''),
                    'twitter_title' => $serviceName . ' ' . $issueCategory . ' - Fixicon',
                    'twitter_description' => 'Professional ' . $serviceName . ' ' . $issueCategory . ' service with warranty.',
                    'twitter_image' => $defaultImage,
                    'structured_data' => $this->getServiceStructuredData($service)
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
     * Generate structured data for services page
     */
    private function getServicesStructuredData()
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
    private function getServiceStructuredData($service)
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
}
