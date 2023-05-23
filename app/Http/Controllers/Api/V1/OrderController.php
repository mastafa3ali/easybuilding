<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderSubmitRequest;
use App\Http\Requests\SaleOrderRequest;
use App\Http\Resources\OrderDetailsResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\ApiNotification;
use App\Models\Order;
use App\Models\Product;
use App\Models\CompanyProduct;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $attachment1 = null;
        $attachment2 = null;
        if ($request->hasFile('attachment1')) {
            $attachment1= $request->file('attachment1');
            $fileName = time() . rand(0, 999999999) . '.' . $attachment1->getClientOriginalExtension();
            $request->attachment1->move(public_path('storage/orders'), $fileName);
            $attachment1 = $fileName;
        }
        if ($request->hasFile('attachment2')) {
            $attachment2= $request->file('attachment2');
            $fileName = time() . rand(0, 999999999) . '.' . $attachment2->getClientOriginalExtension();
            $request->attachment2->move(public_path('storage/orders'), $fileName);
            $attachment2 = $fileName;
        }
        $product = CompanyProduct::where('product_id', $request->product_id)->where('company_id', $request->company_id)->first();
        if($product==null) {
            return apiResponse(false, null, 'حدث خطأ ما الرجاء تحديث الصفحة', null, 200);

        }
        $product_details[] = ['id' => $request->product_id, 'attribute_1' => $request->attribute_1, 'attribute_2' => $request->attribute_2, 'attribute_3' => $request->attribute_3,'price'=>$product->price];
        $guarantee_amount=(float)$request->total * (float)$product->guarantee_amount;
        $data = [
            'details' => $product_details,
            'user_id' => auth()->id(),
            'company_id' => $request->company_id,
            'address' => $request->address,
            'long' => $request->long,
            'lat' => $request->lat,
            'product_id' => $request->product_id,
            'phone' => $request->phone,
            'type' => Order::TYPE_RENT,
            'phone2' => $request->phone2,
            'localtion' => $request->localtion,
            'delivery_phone' => $request->delivery_phone,
            'area' => $request->area,
            'status' =>  Order::STATUS_PENDDING_X,
            'attachment1' => $attachment1,
            'attachment2' => $attachment2,
            'delivery_date' => $request->deliver_date,
            'guarantee_amount' => $guarantee_amount,
            'total'=>$request->total
        ];
        $order = Order::create($data);
        return apiResponse(true, $order->id, null, null, 200);
    }
    public function saleStore(SaleOrderRequest $request)
    {
        $attachment1 = null;
        $attachment2 = null;
        if ($request->hasFile('attachment1')) {
            $attachment1= $request->file('attachment1');
            $fileName = time() . rand(0, 999999999) . '.' . $attachment1->getClientOriginalExtension();
            $request->attachment1->move(public_path('storage/orders'), $fileName);
            $attachment1 = $fileName;
        }
        if ($request->hasFile('attachment2')) {
            $attachment2= $request->file('attachment2');
            $fileName = time() . rand(0, 999999999) . '.' . $attachment2->getClientOriginalExtension();
            $request->attachment2->move(public_path('storage/orders'), $fileName);
            $attachment2 = $fileName;
        }
        $json_details = [];
        $total = 0;
        foreach($request->product_details as $product) {
            $item = Product::findOrFail($product['id']);
            $total = $total+ ((float)$item->price * (int)$product['qty']);
            $product['price'] = $item->price;
            $json_details[] = $product;
        }
        $data = [
            'details' => $json_details,
            'user_id' => auth()->id(),
            'company_id' => $request->company_id,
            'address' => $request->address,
            'long' => $request->long,
            'lat' => $request->lat,
            'product_id' => $request->product_details[0]['id'],
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'type' => Order::TYPE_SALE,
            'localtion' => $request->localtion,
            'delivery_phone' => $request->delivery_phone,
            'area' => $request->area,
            'status' =>  Order::STATUS_PENDDING_X,
            'attachment1' => $attachment1,
            'attachment2' => $attachment2,
            'delivery_date' => $request->deliver_date,
            'total'=>$total

        ];
        $order = Order::create($data);
        return apiResponse(true, $order->id, null, null, 200);
    }
    public function saveAttachment(Request $request)
    {
        $attachment1 = null;
        $attachment2 = null;
        if ($request->hasFile('attachment1')) {
            $attachment1= $request->file('attachment1');
            $fileName = time() . rand(0, 999999999) . '.' . $attachment1->getClientOriginalExtension();
            $request->attachment1->move(public_path('storage/orders'), $fileName);
            $attachment1 = $fileName;
        }
        if ($request->hasFile('attachment2')) {
            $attachment2= $request->file('attachment2');
            $fileName = time() . rand(0, 999999999) . '.' . $attachment2->getClientOriginalExtension();
            $request->attachment2->move(public_path('storage/orders'), $fileName);
            $attachment2 = $fileName;
        }

        $order=Order::findOrFail($request->order_id);
        $order->update([
            'attachment1' => $attachment1,
            'attachment2' => $attachment2,
        ]);
        return apiResponse(true, $order->id, null, null, 200);

    }
    public function orderSubmit(OrderSubmitRequest $request)
    {
        $check_guarantee_amount = null;
        $check_guarantee = null;
        if ($request->hasFile('check_guarantee_amount')) {
            $check_guarantee_amount= $request->file('check_guarantee_amount');
            $fileName = time() . rand(0, 999999999) . '.' . $check_guarantee_amount->getClientOriginalExtension();
            $request->check_guarantee_amount->move(public_path('storage/orders'), $fileName);
            $check_guarantee_amount = $fileName;
        }
        if ($request->hasFile('check_guarantee')) {
            $check_guarantee= $request->file('check_guarantee');
            $fileName = time() . rand(0, 999999999) . '.' . $check_guarantee->getClientOriginalExtension();
            $request->check_guarantee->move(public_path('storage/orders'), $fileName);
            $check_guarantee = $fileName;
        }
        $order= Order::find($request->order_id);
        $data = [
            'status' => Order::STATUS_PENDDING,
            'code' => $order->id,
            'payment' => $request->payment,
            'check_guarantee' => $check_guarantee,
            'check_guarantee_amount' => $check_guarantee_amount,

        ];

        $order->update($data);
        $company = User::find($order->company_id);
        $fcmTokens[] = auth()->user()->fcm_token;
        $message = __('api.new_payment_success');
        $notifications = [
                'user_id'=>auth()->id(),
                'text'=>$message,
                'model_id'=>$order->id,
                'day'=>date('Y-m-d'),
                'time'=>date('H:i'),
            ];
        ApiNotification::create($notifications);
        Notification::send(null, new SendPushNotification($message, $fcmTokens));

        $fcmTokens2[] = $company?->fcm_token;
        $message = __('api.new_order_request');
        $notifications = [
                'user_id'=>auth()->id(),
                'text'=>$message,
                'model_id'=>$order->id,
                'day'=>date('Y-m-d'),
                'time'=>date('H:i'),
            ];
        ApiNotification::create($notifications);
        Notification::send(null, new SendPushNotification($message, $fcmTokens2));
        $to = $company->email;
        $subject = "طلب جديد";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $html = "
                <html>
                    <head>
                        <title>طلب جديد</title>
                    </head>

                    <body style='direction:rtl'>
                        <p>لديك طلب جديد</p>
                        <table border=1>";
            if ($order->type==1) {
                $html .="
                        <tr>
                        <th>".__('products.plural') ."</th>
                        <th>".__('products.qty') ."</th>
                        <th>".__('products.price') ."</th>
                        </tr>";
            } else {
                $html .="  <tr>
                            <th>".__('products.plural') ."</th>
                            <th>".__('products.attributes.1') ."</th>
                            <th>".__('products.attributes.2') ."</th>
                            <th>".__('products.attributes.3') ."</th>
                            <th>".__('products.rent_price') ."</th>
                        </tr>";
            }
            if ($order->type==1) {
                foreach ($order->details as $product) {
                    $html .="<tr>
                                <td>".$order->productDetails($product['id'])?->name ."</td>
                                <td >".$product['qty'] ."</td>
                                <td >".$product['price']??'' ."</td>
                            </tr>";
                }
            } else {
                foreach ($order->details as $product) {
                    $html .=" <tr>
                                <td>".$order->productDetails($product['id'])?->name ."</td>
                                <td>".$product['attribute_1'] ."</td>
                                <td>".$product['attribute_2'] ."</td>
                                <td>".$product['attribute_3'] ."</td>
                                <td>".$product['price']??'' ."</td>
                            </tr>
                        ";
                }
            }
            $html .= "</table>
                    </body>
                </html>
                ";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
            $headers .= 'From: name' . "\r\n";
            mail($to, $subject, $html, $headers);

        return apiResponse(false, $order, null, null, 200);
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

    public function notifications()
    {
        $data = [];
        $dayes = ApiNotification::where('user_id', auth()->id())->groupBy('day')->pluck('day')->toArray();
        foreach($dayes as $day) {
            $list = ApiNotification::where('user_id', auth()->id())->where('day', $day)->get();
            $data[][$day] = $list;
        }
        return apiResponse(true, $data, null, null, 200);
    }

    public function orders()
    {
        $data = [];
        $data = Order::with(['company','product'])->where('user_id', auth()->id())->orderBy('id','DESC')->get();
        return apiResponse(true, OrderResource::collection($data), null, null, 200);
    }

    public function getOrder($id)
    {
        $data = [];
        $data = Order::with(['company','product'])->findOrFail($id);

        return apiResponse(true, new OrderDetailsResource($data), null, null, 200);
    }

}
