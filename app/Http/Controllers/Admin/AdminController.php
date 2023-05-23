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

$from = 'sender@example.com';
$fromName = 'SenderName';

$subject = "Send HTML Email in PHP by CodexWorld";

$htmlContent = '
    <html>
    <head>
        <title>Welcome to CodexWorld</title>
    </head>
    <body>
        <h1>Thanks you for joining with us!</h1>
        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;">
            <tr>
                <th>Name:</th><td>CodexWorld</td>
            </tr>
            <tr style="background-color: #e0e0e0;">
                <th>Email:</th><td>contact@codexworld.com</td>
            </tr>
            <tr>
                <th>Website:</th><td><a href="http://www.codexworld.com">www.codexworld.com</a></td>
            </tr>
        </table>
    </body>
    </html>';

// Set content-type header for sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
$headers .= 'Cc: welcome@example.com' . "\r\n";
$headers .= 'Bcc: welcome2@example.com' . "\r\n";

// Send email
if(mail($to, $subject, $htmlContent, $headers)){
    echo 'Email has sent successfully.';
}else{
   echo 'Email sending failed.';
}

        // $html = '<table>';
        // if ($order->type==1) {
        //     $html .=`
        //             <tr>
        //             <th>`.__('products.plural') .`</th>
        //             <th>`.__('products.qty') .`</th>
        //             <th>`.__('products.price') .`</th>
        //             </tr>`;
        // } else {
        //     $html .=`  <tr>
        //                 <th>`.__('products.plural') .`</th>
        //                 <th>`.__('products.attributes.1') .`</th>
        //                 <th>`.__('products.attributes.2') .`</th>
        //                 <th>`.__('products.attributes.3') .`</th>
        //                 <th>`.__('products.rent_price') .`</th>
        //             </tr>`;
        // }
        // if ($order->type==1) {
        //     foreach ($order->details as $product) {
        //         $html .=`<tr>
        //                     <td>`.$order->productDetails($product['id'])?->name .`</td>
        //                     <td >`.$product['qty'] .`</td>
        //                     <td >`.$product['price']??'' .`</td>
        //                 </tr>`;
        //     }
        // } else {
        //     foreach ($order->details as $product) {
        //         $html .=` <tr>
        //                     <td>`.$order->productDetails($product['id'])?->name .`</td>
        //                     <td>`.$product['attribute_1'] .`</td>
        //                     <td>`.$product['attribute_2'] .`</td>
        //                     <td>`.$product['attribute_3'] .`</td>
        //                     <td>`.$product['price']??'' .`</td>
        //                 </tr>
        //             `;
        //     }
        // }
        // $html .= '</table>';
        // $body = '<p><strong>طلب جديد</p>'.$html;
        // mail($to, $subject, $body);


        return view($this->viewIndex, get_defined_vars());
    }
     public function updateToken(Request $request)
     {
         try {
             $request->user()->update(['fcm_token'=>$request->fcm_token]);
             return response()->json([
                 'success'=>true
             ]);
         } catch(\Exception $e) {
             report($e);
             return response()->json([
                 'success'=>false
             ], 500);
         }
     }
    public function notification(Request $request)
    {

    }
}
