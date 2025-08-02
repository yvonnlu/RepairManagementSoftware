<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Services\SEOService;
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
        $seo = SEOService::generateMetaTags('home');

        return view('website.pages.home.homepage', [
            'services'     => $services,
            'deviceTypes'  => $deviceTypes,
            'selectedType' => $selectedType,
            'seo'          => $seo,
        ]);
    }
}
