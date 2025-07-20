<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServicesStoreRequest;
use App\Http\Requests\Admin\ServicesUpdateRequest;
use App\Models\admin\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function index(Request $request)

    {
        // Lấy danh sách loại thiết bị (không bị trùng)
        $deviceTypes = Services::select('device_type_name')->distinct()->get();

        // Lấy giá trị device_type_name người dùng chọn từ dropdown
        $selectedType = $request->device_type_name;

        // Sử dụng Eloquent để tạo truy vấn lấy dữ liệu
        $query = Services::query();
        // giống như SELECT * FROM services.

        // Nếu người dùng đã chọn một loại thiết bị, thêm điều kiện vào truy vấn
        if (!empty($selectedType)) {
            $query->where('device_type_name', $selectedType);
        }

        // Lấy danh sách service (bạn có thể dùng paginate() nếu muốn phân trang)
        $services = $query->get();

        return view('admin.pages.service_management.index', [
            'services'     => $services,
            'deviceTypes'  => $deviceTypes,
            'selectedType' => $selectedType,
        ]);
    }


    public function create()
    {
        return view('admin.pages.service_management.create');
    }


    public function detail(Services $service)
    {
        return view('admin.pages.service_management.detail', [
            'service' => $service
        ]);
    }
    public function update(ServicesUpdateRequest $request, Services $service)
    {
        // Cập nhật các trường trực tiếp trên model Services
        $service->device_type_name = $request->device_type_name;
        $service->issue_category_name = $request->issue_category_name;
        $service->base_price = $request->base_price;
        $service->description = $request->description;
        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully!');
    }

    public function store(ServicesStoreRequest $request)
    {
        $service = new Services();
        $service->device_type_name = $request->device_type_name;
        $service->issue_category_name = $request->issue_category_name;
        $service->base_price = $request->base_price;
        $service->description = $request->description;
        $check = $service->save();

        return redirect()
            ->route('admin.service.index')
            ->with('success', 'Service created successfully!');
    }
}
