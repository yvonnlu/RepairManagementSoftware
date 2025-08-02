<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Services\SEOService;
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

        $services = $query->get();

        // Group services by device_type_name
        $servicesByDevice = $services->groupBy('device_type_name');

        $cart = session('cart', []);

        // Generate SEO data
        $seo = SEOService::generateMetaTags('services');

        return view('website.pages.services.service', [
            'services'        => $services,
            'deviceTypes'     => $deviceTypes,
            'selectedType'    => $selectedType,
            'servicesByDevice' => $servicesByDevice,
            'cart'            => $cart,
            'seo'             => $seo,
        ]);
    }

    public function show(Services $service)
    {
        // Generate SEO data for service detail
        $seo = SEOService::generateMetaTags('service_detail', ['service' => $service]);

        return view('website.pages.services.service-detail', [
            'service' => $service,
            'seo'     => $seo,
        ]);
    }
}
