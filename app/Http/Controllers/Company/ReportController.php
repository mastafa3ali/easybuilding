<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{


    public function saleOrders(Request $request)
    {
        if ($request->ajax()) {

            $data = Order::with('user')
                   ->where('type', Order::TYPE_SALE)
                   ->where('company_id', session('companyId'))
                    ->where('status', '!=', Order::STATUS_PENDDING_X)
                       ->select('*');

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('statusText', function ($item) {

                    return '<button type="button" class="btn btn-sm btn-outline-primary round waves-effect active border-0">' . strval(__('orders.statuses.' . $item->status)) . '</button>';
                })

                ->editColumn('user', function ($item) {
                    return $item->user?->name;
                })

                ->rawColumns([ 'statusText','user'])
                ->make(true);

        }
        return view('company.pages.reports.saleOrders');
    }
    public function rentOrders(Request $request)
    {
        if ($request->ajax()) {

            $data = Order::with('user')
                   ->where('type', Order::TYPE_RENT)
                   ->where('company_id', session('companyId'))
                   ->where('status', '!=', Order::STATUS_PENDDING_X)
                   ->select('*');

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('statusText', function ($item) {

                    return '<button type="button" class="btn btn-sm btn-outline-primary round waves-effect active border-0">' . strval(__('orders.statuses.' . $item->status)) . '</button>';
                })

                ->editColumn('user', function ($item) {
                    return $item->user?->name;
                })

                ->rawColumns([ 'statusText', 'user'])
                ->make(true);

        }
        return view('company.pages.reports.rentOrders');
    }
}
