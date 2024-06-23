<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyProduct;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    private $viewIndex  = 'company.pages.dashboard';

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        // dd(app()->getLocale());
        $sale_products_count = Product::where('company_id', auth()->id())->count();
        $rent_products_count = CompanyProduct::where('company_id', auth()->id())->count();
        $pendding_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_PENDDING)->count();
        $onprogress_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_ONPROGRESS)->count();
        $compleated_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_DELIVERD)->count();
        $on_way_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_ON_WAY)->count();
        $rejected_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_REJECTED)->count();

        return view($this->viewIndex, get_defined_vars());
    }
    public function payments(Request $request)
    {
        $item = Payment::where('company_id', auth()->id())->where('type', 1)->first();
        $item2 = Payment::where('company_id', auth()->id())->where('type', 2)->first();

        return view('company.pages.payments.index', get_defined_vars());
    }
    public function savePayments(Request $request)
    {

        $this->validate($request, [
              'payment' => 'required',
              'payment2' => 'required',
           ]);
        $payment1 = $request->payment;
        $payment2 = $request->payment2;
        $payment1[] = "4";
        $payment1[] = "5";
        $payment2[] = "4";
        $payment2[] = "5";
        $payments = Payment::where('company_id', auth()->id())->where('type', 1)->first();
        if($payments) {
            $payments->update(['payments' => $payment1]);
        } else {
            Payment::create(['payments' => $payment1,'company_id' => auth()->id(),'type' => 1]);
        }
        $payments2 = Payment::where('company_id', auth()->id())->where('type', 2)->first();
        if($payments2) {
            $payments2->update(['payments' => $payment2]);
        } else {
            Payment::create(['payments' => $payment2,'company_id' => auth()->id(),'type' => 2]);
        }
        flash(__('orders.messages.updated'))->success();

        return back();
    }
    public function updateToken(Request $request)
    {
        try {
            $request->user()->update(['fcm_token' => $request->fcm_token]);
            return response()->json([
                'success' => true
            ]);
        } catch(\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function rate(Request $request)
    {
        if ($request->ajax()) {
            $data = Rate::with('user')
            ->leftJoin('users', 'users.id', 'rates.user_id')
            ->leftJoin('products', 'products.id', 'rates.model_id')
            ->where('products.company_id', auth()->user()->id)
            ->where('rates.type', 2)
             ->select(['products.name','rates.value','rates.message','users.name as username','rates.created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pages.reports.rates');
    }
    public function listRent(Request $request)
    {
        if ($request->ajax()) {
            $data = Rate::with('user')
            ->leftJoin('users', 'users.id', 'rates.user_id')
            ->leftJoin('company_products', 'company_products.id', 'rates.model_id')
            ->leftJoin('products', 'products.id', 'company_products.product_id')
            ->where('company_products.company_id', auth()->user()->id)
            ->where('rates.type', 2)
             ->select(['products.name','rates.value','rates.message','users.name as username','rates.created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pages.reports.listRent');
    }
    public function listCompanyRate(Request $request)
    {
        if ($request->ajax()) {
            $data = Rate::with('user')
            ->leftJoin('users', 'users.id', 'rates.user_id')
            ->where('rates.type', 3)
            ->where('rates.model_id', auth()->user()->id)
             ->select(['rates.value','rates.message','users.name as username','rates.created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.pages.reports.listCompany');
    }

}
