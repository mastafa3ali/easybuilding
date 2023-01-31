<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\AuthProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = array(
            'phone' => 'required|string',
            'password' => 'required|string'
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.not_found'), $validatedData->errors()->all(), 422);
        }

        $credentials = request(['phone', 'password']);
        if (!Auth::attempt($credentials)) {
            return apiResponse(false, null, __('api.not_authorized'), null, 401);
        }
        $user = Auth::user();
        $user['token'] = $user->createToken('auth_token')->plainTextToken;
        return new UserResource($user);
        // if ($user->isVerified) {
        // }else{
        //     return apiResponse(false, null, __('api.not_verify'), null, 400);
        // }
    }
   public function updateProfile(Request $request)
    {

        $currentUser = User::findOrFail(auth()->user()->id);

        $data = $currentUser->update(['name'=>$request->name,'address'=>$request->address,'phone'=>$request->phone,'email'=>$request->email]);
        if ($data) {
            return apiResponse(true, null, __('api.update_success'), null, 200);
        } else {
            return apiResponse(false, null, __('api.cant_update'), null, 401);
        }
    }
    function sendSMS($userAccount, $passAccount, $numbers, $sender, $msg, $timeSend=0, $dateSend=0, $viewResult=1, $MsgID=0)
    {

        global $arraySendMsg;
        $url = "http://doo.ae/api/msgSend.php";
        $applicationType = "24";
        $msg = convertToUnicode($msg);
        $sender = urlencode($sender);
        $stringToPost = "mobile=".$userAccount."&password=".$passAccount."&numbers=".$numbers."&sender=".$sender."&msg=".$msg."&timeSend=".$timeSend."&dateSend=".$dateSend."&applicationType=".$applicationType."&msgId=".$MsgID;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
        $result = curl_exec($ch);

        if($viewResult)
            $result = [trim($result) , $arraySendMsg];
        return $result;
    }
    public function register(Request $request)
    {

        $request['phone'] = convertArabicNumbers($request->phone);
        $validate = array(
            'name' => 'required',
            'type' => 'required|in:2,3',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }

        $user = new User();
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->password  = Hash::make($request->password);
        $user->type      = $request->type;
        $user->phone     = $request->phone;

        if ($request->hasFile('passport')) {
            $user->passport = storeFile($request->file('passport'), 'users');
            $user->save();
        }
        if ($request->hasFile('licence')) {
            $user->licence = storeFile($request->file('licence'), 'users');
            $user->save();
        }
        if ($user->save()) {

            $user['token'] = $user->createToken('auth_token')->plainTextToken;
            return new UserResource($user);
        }
    }
    public function resetPassword(Request $request)
    {
        $validate = array(
            'phone' => 'required|string',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $mobile = "0971522946005";
        $password = "123456";
        $sender = "sms Msg";
        $numbers = $request->phone;
        $MsgID = rand(1,9999);
        $msg = "reset code .".$MsgID;
        $timeSend = 0;
        $dateSend = 0;
        $resultType = 0;
        $user->update(['reset_code'=>$MsgID]);
        $this->sendSMS($mobile, $password, $numbers, $sender, $msg, $timeSend, $dateSend, $resultType,$MsgID);
        return apiResponse(true, [$MsgID], __('api.reset_link_will_send'), null, 200);
    }
    public function checkCode(Request $request)
    {
        $validate = array(
            'phone' => 'required',
            'code' => 'required|min:4',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        if($user->reset_code == $request->code){
            return apiResponse(true, null, __('api.code_success'), null, 200);
        }
        return apiResponse(false, null, __('api.code_error'), null, 200);
    }
    public function confirmReset(Request $request)
    {
        $validate = array(
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $user->update(['password' => Hash::make($request->password),'reset_code'=>null]);
        return apiResponse(true, null, __('api.update_success'), null, 200);
    }
    public function logout(Request $request)
    {
        try {
            return 555;
        } catch (\Exception $e) {
        }
    }
    public function deleteAccount()
    {
        $user = User::find(auth()->id());
        if ($user->delete()) {
            return apiResponse(true, null, null, null, 200);
        }
        return apiResponse(false, null, null, null, 400);
    }
}
