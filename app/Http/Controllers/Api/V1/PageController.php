<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\SubCategory;
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
        $data = User::where('users.type',User::TYPE_COMPANY)
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
    public function getSales($id)
    {
         $data = User::where('users.type',User::TYPE_COMPANY)
        ->leftjoin('products','products.company_id','users.id')
        ->leftjoin('categories','categories.id','products.category_id')
        ->where('categories.id', $id)->select(
            'users.id',
            'users.name',
            'users.description'
        )->groupBy('users.id')->get();
        return apiResponse(true, $data, null, null, 200);
    }
    public function getRent($id)
    {
        $data = SubCategory::with(['products.category','products.subcategory','products.company'])->where('category_id',$id)->get();
        return apiResponse(true, SubCategoryResource::collection($data), null, null, 200);
    }
    public function latestAppVersion()
    {
        return apiResponse(true, ['latest_android_version' => '1.0.3', 'latest_ios_version' => '1.0.1',], null, null, 200);
    }
    public function profile(Request $request)
    {

        $data = [];
        $user = auth()->user();
        $data['profile'] = [
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'image' => $user->image,
            'passport' => $user->passport,
            'licence' => $user->licence,
            'address' => $user->address,
            'description' => $user->description,
            'active' => $user->active,
            'type' => $user->type,
            'rate' => $user->rate
        ];


        return apiResponse(true, $data, null, null, 200);
    }
public function notifications(){
    $data=[
            '30-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
            '25-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
            '22-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
            '20-12-2022'  => [
                'text'=>'تم اتمام العملية بنجاح',
                'time'=>'3:40',
            ],
        ];
    return apiResponse(true, $data, null, null, 200);
}

}
