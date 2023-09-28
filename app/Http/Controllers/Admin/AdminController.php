<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Kutia\Larafirebase\Services\Larafirebase;

class AdminController extends Controller
{
    private $viewIndex  = 'admin.pages.dashboard.index';

    public function index(Request $request)
    {
        // $codesCounts = WalletCode::count();

        $agency = User::where('type', User::TYPE_MERCHANT)->count();
        $indivedual = User::where('type', User::TYPE_OWNER)->count();
        $companies = User::where('type', User::TYPE_COMPANY)->count();

        $merchants = User::where('type', User::TYPE_MERCHANT)->count();
        $sall_products = Product::where('type', Product::TYPE_SALE)->count();
        $rent_products = Product::where('type', Product::TYPE_RENT)->count();
        $all_orders = Order::where('status', '!=', Order::STATUS_PENDDING_X)->count();
        $pendding_orders = Order::where('status', Order::STATUS_PENDDING)->count();
        $rejected_orders = Order::where('status', Order::STATUS_REJECTED)->count();
        $deliverd_orders = Order::where('status', Order::STATUS_DELIVERD)->count();
        $onprogress_orders = Order::where('status', Order::STATUS_ONPROGRESS)->count();
        $on_way_orders = Order::where('status', Order::STATUS_ON_WAY)->count();

        return view($this->viewIndex, get_defined_vars());
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
    public function notification(Request $request) {}
}
