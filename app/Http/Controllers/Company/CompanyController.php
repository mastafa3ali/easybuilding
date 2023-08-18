<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
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
        $products_count = Product::where('company_id',auth()->id())->count();
        $pendding_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_PENDDING)->count();
        $onprogress_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_ONPROGRESS)->count();
        $compleated_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_DELIVERD)->count();
        return view($this->viewIndex, get_defined_vars());
    }
    public function payments(Request $request)
    {
        $item = Payment::where('company_id',auth()->id())->first();

        return view('company.pages.payments.index', get_defined_vars());
    }
    public function savePayments(Request $request)
    {
         $this->validate($request, [
               'payment' => 'required',
               'payment2' => 'required',
            ]);
        $payments = Payment::where('company_id',auth()->id())->where('type',1)->first();
        if($payments){
            $payments->update(['payments'=>$request->payment]);
        }else{
            Payment::create(['payments'=>$request->payment,'company_id'=>auth()->id()]);
        }
        $payments2 = Payment::where('company_id',auth()->id())->where('type',2)->first();
        if($payments2){
            $payments2->update(['payments'=>$request->payment2]);
        }else{
            Payment::create(['payments'=>$request->payment2,'company_id'=>auth()->id()]);
        }
        flash(__('orders.messages.updated'))->success();

        return back();
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
