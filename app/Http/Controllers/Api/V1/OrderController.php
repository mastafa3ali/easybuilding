<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        // $fcmTokens = User::pluck('fcm_token')->toArray();
        // $message = __('api.add_to_saved');
        // Notification::send(null,new SendPushNotification($message,$fcmTokens));
        $attachment1 = null;
        $attachment2 = null;
        if ($request->hasFile('attachment1')) {
            $attachment1 = storeFile($request->file('attachment1'), 'sliders');
        }
        if ($request->hasFile('attachment2')) {
            $attachment2 = storeFile($request->file('attachment2'), 'sliders');
        }
        $data = [
            'details'=>json_encode($request->products),
            'user_id'=>auth()->id(),
            'address'=>$request->address,
            'phone'=>$request->phone,
            'phone2'=>$request->phone2,
            'delivery_phone'=>$request->delivery_phone,
            'area'=>$request->area,
            'attachment1'=>$attachment1,
            'attachment2'=>$attachment2,
            'delivery_date'=>$request->delivery_date,
            'payment'=>$request->payment,
            'guarantee_amount'=>$request->guarantee_amount
        ];
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
