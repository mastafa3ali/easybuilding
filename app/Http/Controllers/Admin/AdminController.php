<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Kutia\Larafirebase\Services\Larafirebase;

class AdminController extends Controller
{
    private $viewIndex  = 'admin.pages.dashboard.index';

    public function index(Request $request)
    {
        // $codesCounts = WalletCode::count();
        $order = Order::first();
        $to = "mastafa3alie@gmail.com";
        $subject = "طلب جديد";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $html = '<table>';
        if ($order->type==1) {
            $html .=`
                    <tr>
                    <th>`.__('products.plural') .`</th>
                    <th>`.__('products.qty') .`</th>
                    <th>`.__('products.price') .`</th>
                    </tr>`;
        } else {
            $html .=`  <tr>
                        <th>`.__('products.plural') .`</th>
                        <th>`.__('products.attributes.1') .`</th>
                        <th>`.__('products.attributes.2') .`</th>
                        <th>`.__('products.attributes.3') .`</th>
                        <th>`.__('products.rent_price') .`</th>
                    </tr>`;
        }
        if ($order->type==1) {
            foreach ($order->details as $product) {
                $html .=`<tr>
                            <td>`.$order->productDetails($product['id'])?->name .`</td>
                            <td >`.$product['qty'] .`</td>
                            <td >`.$product['price']??'' .`</td>
                        </tr>`;
            }
        } else {
            foreach ($order->details as $product) {
                $html .=` <tr>
                            <td>`.$order->productDetails($product['id'])?->name .`</td>
                            <td>`.$product['attribute_1'] .`</td>
                            <td>`.$product['attribute_2'] .`</td>
                            <td>`.$product['attribute_3'] .`</td>
                            <td>`.$product['price']??'' .`</td>
                        </tr>
                    `;
            }
        }
        $html .= '</table>';
        $body = '<p><strong>طلب جديد</p>'.$html;
        mail($to, $subject, $body);


        return view($this->viewIndex, get_defined_vars());
    }
     public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->fcm_token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }
    public function notification(Request $request){

    }
}
