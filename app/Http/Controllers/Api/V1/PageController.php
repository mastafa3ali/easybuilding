<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SavedResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\ApiNotification;
use App\Models\Category;
use App\Models\Product;
use App\Models\Saved;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
        return apiResponse(true, [], null, null, 200);


    }
    public function getSales($id)
    {

         $data = User::where('users.type',User::TYPE_COMPANY)
            ->join('company_products','company_products.company_id','users.id')
            ->join('products','products.id','company_products.product_id')
            ->where('products.type', Product::TYPE_SALE)
            ->where('products.category_id', $id)
            ->select([
                'company_products.price as price',
                'users.id',
                'users.name as name',
                'users.phone',
                'users.description',
                'users.image'
            ])
        ->get();



        return apiResponse(false,CompanyResource::collection($data), null, null, 200);
    }
    public function getRent($id)
    {
        $data = SubCategory::with(['products.category','products.subcategory'])->where('category_id',$id)->get();
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

    public function getCompanies($id)
    {
        //get all companies that sell this product
        $data = User::where('users.type',User::TYPE_COMPANY)
        ->leftJoin('company_products','company_products.company_id','users.id')
        ->leftJoin('products','products.id','company_products.product_id')
       ->where('products.type', Product::TYPE_SALE)
       ->where('products.id', $id)
        ->select([
            'company_products.price as price',
            'users.id',
            'users.name as company_name',
            'users.phone',
            'users.description',
            'users.image'
        ])->orderBy('company_products.price')
        ->get();
        return apiResponse(false,CompanyResource::collection($data), null, null, 200);
    }
    public function getSavedProduct()
    {
        $products= Product::leftJoin('saveds','model_id','products.id')->where('saveds.user_id', auth()->id())->where('saveds.model_type',Saved::TYPE_PRODUCT)->select([
            'saveds.model_type as model_type',
            'products.*',
        ])->get();
        $data = SavedResource::collection($products);
        return apiResponse(true, $data, null, null, 200);
    }
    public function getSavedCompany()
    {
           $companies= User::leftJoin('saveds','model_id','users.id')->where('saveds.user_id', auth()->id())->where('saveds.model_type',Saved::TYPE_COMPANY)->select([
            'saveds.model_type as model_type',
            'users.*',
        ])->get();

        $data = SavedResource::collection($companies);
        return apiResponse(true, $data, null, null, 200);
    }
    public function getCompanyProduct($id,$category_id)
    {
        $products = Product::where('category_id',$category_id)->get();
        $data = ProductResource::collection($products);
        return apiResponse(true, $data, null, null, 200);
    }
    public function notifications(){
        $data = [];
        $dayes = ApiNotification::where('user_id', auth()->id())->groupBy('day')->pluck('day')->toArray();
        foreach($dayes as $day){
            $list = ApiNotification::where('user_id', auth()->id())->where('day',$day)->get();
            $data[]['day'] = $list;
        }
        return apiResponse(true, $data, null, null, 200);
    }
    public function about(){
        $data = Setting::where('key', 'LIKE', 'about_%')->get();
        return apiResponse(true, $data, null, null, 200);
    }
    public function makeSaved(Request $request){
        $data = [
            'model_id'=>$request->model_id,
            'model_type'=>$request->model_type,
            'user_id'=>auth()->id()
        ];
        $item_name = '';
        if($request->model_type==Saved::TYPE_COMPANY){
            $item = User::find($request->model_id);
            $item_name = $item->name;
        }
        if($request->model_type==Saved::TYPE_PRODUCT){
            $item = Product::find($request->model_id);
            $item_name = $item->name;
        }
        $is_saved=Saved::where('model_id',$request->model_id)
            ->where('model_type',$request->model_type)
            ->where('user_id',auth()->id())->first();
            if($is_saved){
                $is_saved->delete();
                $message = __('api.removed_from_saved_success',['item'=>$item_name]);
                $fcmTokens = [auth()->user()->fcm_token];
                $notifications = [
                    'user_id'=>auth()->id(),
                    'text'=>$message,
                    'day'=>date('Y-m-d'),
                    'time'=>date('H:i'),
                ];
                ApiNotification::create($notifications);
                Notification::send(null,new SendPushNotification($message,$fcmTokens));
                return apiResponse(true,null, $message, null, 200);
            }
        $saved=Saved::create($data);
        $message = '';
        if($saved){

            $message = __('api.add_to_saved',['item'=>$item_name]);
            $fcmTokens = [auth()->user()->fcm_token];
            $notifications = [
                'user_id'=>auth()->id(),
                'text'=>$message,
                'day'=>date('Y-m-d'),
                'time'=>date('H:i'),
            ];
            ApiNotification::create($notifications);
            Notification::send(null,new SendPushNotification($message,$fcmTokens));
            return apiResponse(true,null, null, null, 200);
        }
        return apiResponse(false,null, $message, null, 200);
    }

    public function search(Request $request){
        $data=['companies'=>[],'products'=>[]];
        if($request->filled('name')){
            $companies=User::where('name','like','%'.$request->name.'%')->get();
            $products=Product::where('name','like','%'.$request->name.'%')->get();
            $data['products'] = ProductResource::collection($products);
            $data['companies'] = CompanyResource::collection($companies);
            return apiResponse(true,$data, "", null, 200);
        }
    }

}
