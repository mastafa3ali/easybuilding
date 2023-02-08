<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SavedResource;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Saved;
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
        $data = [
        'id'               => 1,
        'name'             => 'sasa',
        'phone'            => '1231231',
        'price'            => 20,
        'description'      => 'sasa test test',
        'saved'            => 1,
        'image'            => 'http://easy.test/storage/users/1675874896276743554.png'
        ];
        return apiResponse(false,$data, null, null, 200);
        $data = User::where('users.type',User::TYPE_COMPANY)
        ->join('company_products','company_products.company_id','users.id')
        ->join('products','products.id','company_products.product_id')
        ->where(function($query) use ($request){
            if($request->filled('name')){
                $query->where('company_products.name','like', '%'.$request->name.'%');
            }
            if($request->filled('rate')){
                $query->orderBy('users.rate', 'DESC');
            }
            if($request->filled('price')){
                $query->orderBy('company_products.price', $request->asc);
            }
        })->where('products.type', Product::TYPE_RENT)
        ->select([
            'company_products.price as price',
            'users.id',
            'users.name',
            'users.phone',
            'users.description',
            'users.image'
        ])
        ->get();
        return apiResponse(false,CompanyResource::collection($data), null, null, 200);
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

    public function getCompanies($id)
    {
       $companies= User::leftjoin('products','products.company_id','users.id')
        ->where('products.id',$id)
        ->orderBy('products.price')->get();
        $data = CompanyResource::collection($companies);
        return apiResponse(true, $data, null, null, 200);
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
        $products = Product::with('company')->where('category_id',$category_id)->where('company_id',$id)->get();
        $data = ProductResource::collection($products);
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
    public function makeSaved(Request $request){
        $data = [
            'model_id'=>$request->model_id,
            'model_type'=>$request->model_type,
            'user_id'=>auth()->id()
        ];
        $saved=Saved::create($data);
        if($saved){
            $item_name = '';
            if($request->model_type==Saved::TYPE_COMPANY){
                $item = User::find($request->model_id);
                $item_name = $item->name;

            }
            if($request->model_type==Saved::TYPE_PRODUCT){
                $item = Product::find($request->model_id);
                $item_name = $item->name;
            }
            $message = __('api.add_to_saved',['item'=>$item_name]);
            $fcmTokens = [auth()->user()->fcm_token];
            // $fcmTokens = User::pluck('fcm_token')->toArray();

            Notification::send(null,new SendPushNotification($message,$fcmTokens));
            return apiResponse(true,null, null, null, 200);
        }
        return apiResponse(false,null, null, null, 200);
    }

}
