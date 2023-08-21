<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function rentProductReport(Request $request)
    {


        $data = Order::where('type',Order::TYPE_RENT)->select('details->attribute_1 as attribute_1')->get();
        // dd($data[0]->attribute_1);

        if ($request->ajax()) {

            $data = Order::groupBy('');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photo', function ($item) {
                return '<img src="' . $item->photo . '" height="100px" width="100px">';
            })
            ->editColumn('active', function ($item) {
                return $item->active == 1 ? '<button class="btn btn-sm btn-outline-success me-1 waves-effect"><i data-feather="check" ></i></button>' : '<button class="btn btn-sm btn-outline-danger me-1 waves-effect"><i data-feather="x" ></i></button>';
            })
            ->rawColumns(['photo','active'])
            ->make(true);

        }
        return view('admin.pages.reports.rent');
    }

    public function sallProductReport()
    {

        return view('admin.pages.reports.sale');
    }
}
