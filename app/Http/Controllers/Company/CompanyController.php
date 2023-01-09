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
        $products_count=Product::where('company_id',auth()->id())->count();
        $pendding_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_PENDDING)->count();
        $onprogress_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_ONPROGRESS)->count();
        $compleated_orders = Order::where('company_id', auth()->id())->where('status', Order::STATUS_DONE)->count();
        return view($this->viewIndex, get_defined_vars());
    }

  
}
