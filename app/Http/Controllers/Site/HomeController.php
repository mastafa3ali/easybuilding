<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private $viewIndex  = 'website.pages.index';
    private $viewAbout   = 'website.pages.about';
    public function index(Request $request)
    {
        $sliders = Slider::all();
        $teams = Team::all();

        return view($this->viewIndex, get_defined_vars());
    }

    public function about()
    {
        $items = Setting::where('key', 'LIKE', 'about_%')
            ->get();
        $sections = Section::all();
        $categories = Category::all();
        return view($this->viewAbout, get_defined_vars());
    }


    public function show($id)
    {
        abort(404);
    }
    public function contactus(Request $request)
    {
        $item = new Contact();
        $item = $item->fill($request->all());
        $item->save();
        Session::flash('success', 'Success');
        return to_route('home');
    }


    public function list(Request $request)
    {
    }
}
