<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderEmail;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $mailInfo = new \stdClass();
        $mailInfo->recieverName = "Mustafa";
        $mailInfo->sender = "Easybuilding";
        $mailInfo->senderCompany = "Easybuilding";
        $mailInfo->to = "mastaf3alie@gmail.com";
        $mailInfo->subject = "طلب جديد";
        $mailInfo->name = "easybuilding";
        $mailInfo->from = "info@easybuilding.com";
        $mailInfo->cc = "ci@email.com";
        $mailInfo->bcc = "jim@email.com";

        Mail::to("mastaf3alie@gmail.com")
           ->send(new OrderEmail($mailInfo,$order));

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
