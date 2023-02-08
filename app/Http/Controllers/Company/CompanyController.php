<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $viewIndex  = 'company.pages.dashboard';

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $products_count = 10;//Product::where('company_id',auth()->id())->count();
        $pendding_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_PENDDING)->count();
        $onprogress_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_ONPROGRESS)->count();
        $compleated_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_DONE)->count();
        return view($this->viewIndex, get_defined_vars());
    }
    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->fcm_token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

}
