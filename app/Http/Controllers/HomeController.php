<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
       public function language()
    {

        if(Session::get('lang')=='en'){
            Session::put('lang', 'ar');
            App::setLocale('ar');
        }else{
            Session::put('lang', 'en');
            App::setLocale('en');
        }
        return back();

    }

}
