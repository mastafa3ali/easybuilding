<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\RateRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SavedResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\ApiNotification;
use App\Models\Category;
use App\Models\Product;
use App\Models\Saved;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\CompanyProduct;
use App\Models\Payment;
use App\Models\Rate;
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
        $data['categories'] = Category::orderBy('sort', 'ASC')->get();
        return apiResponse(false, $data, null, null, 200);
    }
    public function sales(Request $request)
    {
        return apiResponse(true, [], null, null, 200);


    }
    public function productImages($product_id, $company_id)
    {
        $images = [];
        $product = CompanyProduct::where('product_id', $product_id)->where('company_id', $company_id)->first();
        if($product) {
            $images = $product->photos;
        }
        return apiResponse(true, $images, null, null, 200);

    }
    public function getSales($id)
    {

        if(request()->sort_type==0) {
            $sort = 'ASC';
        } elseif(request()->sort_type==1) {
            $sort = 'DESC';
        }

        //بتعرض الشركات للبيع الخاصة للكاتيجورى
        $data = User::where('users.type', User::TYPE_COMPANY)
           ->join('products', 'products.company_id', 'users.id')
           ->where('products.type', Product::TYPE_SALE)
           ->where('products.category_id', $id)
           ->groupBy('users.id')
           ->select([
               'users.id',
               'users.rate',
               'users.name as name',
               'users.phone',
               'users.description',
               'users.image'
           ])->orderBy('id',$sort)
        ->get();



        return apiResponse(false, CompanyResource::collection($data), null, null, 200);
    }
    public function getRent($id)
    {
        //المواد الايجار فى السب كاتيجورى
        $data = SubCategory::with(['products.category','products.subcategory'])->where('category_id', $id)->orderBy('sort', 'ASC')->get();
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
            'image' => $user->photo,
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

    public function getCompanies($id, $sort_type='ASC')
    {
        if(request()->sort_type==0) {
            $sort = 'ASC';
        } elseif(request()->sort_type==1) {
            $sort = 'DESC';
        }
        //بترجع الشركات اللى ضايفه عروض على المنتج للايجار
        if(request()->sort_type==2) {
            $data = User::where('users.type', User::TYPE_COMPANY)
            ->leftJoin('company_products', 'company_products.company_id', 'users.id')
            ->leftJoin('products', 'products.id', 'company_products.product_id')
               ->where('products.type', Product::TYPE_RENT)
               ->where('products.id', $id)
            ->select([
                'company_products.price as price',
                'company_products.price_2',
                'company_products.price_3',
                'company_products.price_4',
                'company_products.rent_type',
                'company_products.image as product_image',
                'company_products.guarantee_amount as guarantee_amount',
                'users.id',
                'users.rate',
                'users.name',
                'users.phone',
                'users.description',
                'users.image'
            ])->orderBy('users.rate', 'DESC')
            ->get();
        } else {

            $data = User::where('users.type', User::TYPE_COMPANY)
            ->leftJoin('company_products', 'company_products.company_id', 'users.id')
            ->leftJoin('products', 'products.id', 'company_products.product_id')
               ->where('products.type', Product::TYPE_RENT)
               ->where('products.id', $id)
            ->select([
                'company_products.price as price',
                'company_products.price_2',
                'company_products.price_3',
                'company_products.price_4',
                'company_products.rent_type',
                'company_products.image as product_image',
                'company_products.guarantee_amount as guarantee_amount',
                'users.id',
                'users.rate',
                'users.name',
                'users.phone',
                'users.description',
                'users.image'
            ])->orderBy('company_products.price', $sort)
            ->get();

        }
        return apiResponse(false, CompanyResource::collection($data), null, null, 200);
    }
    public function getSavedProduct()
    {
        $products= Product::leftJoin('saveds', 'model_id', 'products.id')->where('saveds.user_id', auth()->id())->where('saveds.model_type', Saved::TYPE_PRODUCT)->select([
            'saveds.model_type as model_type',
            'products.*',
        ])->get();
        $data = SavedResource::collection($products);
        return apiResponse(true, $data, null, null, 200);
    }
    public function getSavedCompany()
    {
        $companies= User::leftJoin('saveds', 'model_id', 'users.id')->where('saveds.user_id', auth()->id())->where('saveds.model_type', Saved::TYPE_COMPANY)->select([
         'saveds.model_type as model_type',
         'users.*',
        ])->get();

        $data = SavedResource::collection($companies);
        return apiResponse(true, $data, null, null, 200);
    }
    public function getCompanyProduct($id, $category_id)
    {
        if(request()->sort_type==0) {
            $sort = 'ASC';
        } elseif(request()->sort_type==1) {
            $sort = 'DESC';
        }

        if(request()->sort_type==2) {
            $products = Product::with('subcategory')->where('category_id', $category_id)->where('company_id', $id)->orderBy('rate', 'DESC')->get();
        } else {
            $products = Product::with('subcategory')->where('category_id', $category_id)->where('company_id', $id)->orderBy('price', $sort)->get();
        }

        $data = ProductResource::collection($products);
        return apiResponse(true, $data, null, null, 200);
    }
    public function notifications()
    {
        $data = [];
        $dayes = ApiNotification::where('user_id', auth()->id())->groupBy('day')->pluck('day')->toArray();
        foreach($dayes as $day) {
            $list = ApiNotification::where('user_id', auth()->id())->where('day', $day)->get();
            $data[]['day'] = $list;
        }
        return apiResponse(true, $data, null, null, 200);
    }
    public function about()
    {
        $data = Setting::where('key', 'LIKE', 'about_%')->get();
        return apiResponse(true, $data, null, null, 200);
    }
    public function makeSaved(Request $request)
    {
        $data = [
            'model_id'=>$request->model_id,
            'model_type'=>$request->model_type,
            'user_id'=>auth()->id()
        ];
        $item_name = '';
        if($request->model_type==Saved::TYPE_COMPANY) {
            $item = User::find($request->model_id);
            $item_name = $item->name;
        }
        if($request->model_type==Saved::TYPE_PRODUCT) {
            $item = Product::find($request->model_id);
            $item_name = $item->name;
        }
        $is_saved=Saved::where('model_id', $request->model_id)
            ->where('model_type', $request->model_type)
            ->where('user_id', auth()->id())->first();
        if($is_saved) {
            $is_saved->delete();
            $message = __('api.removed_from_saved_success', ['item'=>$item_name]);
            $fcmTokens = [auth()->user()->fcm_token];
            $notifications = [
                'user_id'=>auth()->id(),
                'text'=>$message,
                'day'=>date('Y-m-d'),
                'time'=>date('H:i'),
            ];
            ApiNotification::create($notifications);
            Notification::send(null, new SendPushNotification($message, $fcmTokens));
            return apiResponse(true, null, $message, null, 200);
        }
        $saved=Saved::create($data);
        $message = '';
        if($saved) {

            $message = __('api.add_to_saved', ['item'=>$item_name]);
            $fcmTokens = [auth()->user()->fcm_token];
            $notifications = [
                'user_id'=>auth()->id(),
                'text'=>$message,
                'day'=>date('Y-m-d'),
                'time'=>date('H:i'),
            ];
            ApiNotification::create($notifications);
            Notification::send(null, new SendPushNotification($message, $fcmTokens));
            return apiResponse(true, null, null, null, 200);
        }
        return apiResponse(false, null, $message, null, 200);
    }

    public function search(Request $request)
    {
        $data=['companies'=>[],'products'=>[]];
        if($request->filled('name')) {
            $companies=User::where('name', 'like', '%'.$request->name.'%')->get();
            $products=Product::where('name', 'like', '%'.$request->name.'%')->get();
            $result = [];
            foreach($products as $product){
                if($product->type==Product::TYPE_RENT){
                    $result[] = new ProductResource($product);
                }else{
                    $companies=User::where('id', $product->company_id)->get();
                }
            }
            $data['products'] = $result;
            $data['companies'] = CompanyResource::collection($companies);
            return apiResponse(true, $data, "", null, 200);
        }
    }

    public function saveRate(RateRequest $request)
    {
        $input = [
            'value' => $request->value,
            'message' => $request->message,
            'type' => $request->type,
            'model_id' => $request->model_id,
            'user_id' => auth()->user()->id,
        ];
        $data = Rate::create($input);
        if ($data) {
            $rate = Rate::where('type', $request->type)->where('model_id', $request->model_id)->sum('value');
            $count = Rate::where('type', $request->type)->where('model_id', $request->model_id)->count();
            if ($request->type == 1) {
                $item = Product::findOrFail($request->model_id);
            }
            if ($request->type == 2) {
                $item = Product::findOrFail($request->model_id);
            }
            $item->rate = $rate / $count;
            $item->save();
        }
        return apiResponse(true, $data, "", null, 200);

    }
    public function saveproperities(Request $request)
    {
        // $data = [
        //     'user_id'=>auth()->id(),
        //     'category_id'=>$request->category_id,
        //     'properity_1'=>$request->properity_1,
        //     'properity_2'=>$request->properity_2,
        //     'properity_3'=>$request->properity_3,
        // ];
        // $terminalData = TerminalData::where('user_id', auth()->id())->where('category_id', $request->category_id)->first();
        // if($terminalData){
        //     $terminalData->update($data);
        // }else{
        //     TerminalData::create($data);
        // }

        // return apiResponse(true,$data, "", null, 200);
    }
    public function getProperities($category_id)
    {
        // $data = TerminalData::where('user_id', auth()->id())->where('category_id', $category_id)->first();
        // return apiResponse(true,$data, "", null, 200);
    }
    public function contactUs(ContactRequest $request)
    {
        $data=Contact::create([
            'name'=>$request->name,
            'reason'=>$request->reason,
            'problem'=>$request->message,
        ]);
        return apiResponse(true, $data, "", null, 200);
    }
    public function getCompanyPayment($id)
    {

        $data=Payment::where('company_id', $id)->get();
        return apiResponse(true, $data, "", null, 200);
    }

}
