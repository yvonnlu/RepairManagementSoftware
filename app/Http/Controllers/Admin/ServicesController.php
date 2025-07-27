<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServicesStoreRequest;
use App\Http\Requests\Admin\ServicesUpdateRequest;
use App\Models\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách loại thiết bị (không bị trùng) bao gồm cả soft deleted
        $deviceTypes = Services::withTrashed()->select('device_type_name')->distinct()->get();

        // Sử dụng Eloquent để tạo truy vấn lấy dữ liệu bao gồm cả soft deleted
        $query = Services::withTrashed();

        // Tìm kiếm nếu có search term
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('issue_category_name', 'like', "%{$searchTerm}%")
                    ->orWhere('device_type_name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Lọc theo device type nếu có
        if ($request->filled('device_type_name')) {
            $query->where('device_type_name', $request->device_type_name);
        }

        // Sắp xếp theo thời gian tạo mới nhất
        $query->orderBy('created_at', 'desc');

        // Phân trang với 9 services mỗi trang (3x3 grid)
        $services = $query->paginate(9)->appends($request->query());

        return view('admin.pages.service_management.index', [
            'services'     => $services,
            'deviceTypes'  => $deviceTypes,
            'selectedType' => $request->device_type_name,
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

    public function destroy(Services $service)
    {
        try {
            // Soft delete service
            $service->delete();

            return redirect()->route('admin.service.index')
                ->with('success', 'Service has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.service.index')
                ->with('error', 'Failed to delete service. Please try again.');
        }
    }

    public function restore($id)
    {
        try {
            // Find the soft-deleted service by ID
            $service = Services::withTrashed()->findOrFail($id);

            // Restore service
            $service->restore();

            return redirect()->route('admin.service.index')
                ->with('success', 'Service has been restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.service.index')
                ->with('error', 'Failed to restore service. Please try again.');
        }
    }
}
