<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $viewIndex = 'company.pages.payments.index';


    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view($this->viewIndex, get_defined_vars());
    }


}
