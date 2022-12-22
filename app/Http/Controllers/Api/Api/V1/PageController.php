<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $data['sliders'] = Slider::latest()->take(15)->get();      
        $data['categories'] = Category::latest()->take(15)->get();      
        return apiResponse(false, $data, null, null, 200);
    }
    public function sales(Request $request)
    {
        $data = User::where('type',User::TYPE_COMPANY)
        ->join('products','products.company_id','users.id')
        ->where(function($query) use ($request){
            if($request->filled('name')){
                $query->where('products.name','like', '%'.$request->name.'%');
            }
            if($request->filled('rate')){
                $query->orderBy('users.rate', 'DESC');
            }
            if($request->filled('price')){
                $query->orderBy('products.price', $request->asc);
            }
        })->where('products.type', Product::TYPE_RENT)->paginate(20);
        return apiResponse(false, $data, null, null, 200);
    }
    public function latestAppVersion()
    {
        return apiResponse(true, ['latest_android_version' => '1.0.3', 'latest_ios_version' => '1.0.1',], null, null, 200);
    }

}
