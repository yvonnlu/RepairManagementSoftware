<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceManagementController extends Controller
{
    public function serviceindex(Request $request)
    {
        $datas = DB::table('device_type_issue_category as dtic')
            ->join('device_types as dt', 'dtic.device_type_id', '=', 'dt.id')
            ->join('issue_categories as ic', 'dtic.issue_category_id', '=', 'ic.id')
            ->select(
                'dtic.id',
                'dt.name as device_type_name',
                'ic.name as issue_category_name',
                'dtic.base_price',
                'dtic.description'
            )
            ->orderBy('dtic.id')
            ->get();


        return view('admin.pages.service_management.list', ['datas' => $datas]);
    }
}
