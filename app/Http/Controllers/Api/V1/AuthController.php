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
    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone']));
        if ($verification->valid) {
            $user = tap(User::where('phone', $data['phone']))->update(['isVerified' => true]);
            /* Authenticate user */
            Auth::login($user->first());
            return redirect()->route('home')->with(['message' => 'Phone number verified']);
        }
        return back()->with(['phone' => $data['phone'], 'error' => 'Invalid verification code entered!']);
    }

   public function updateProfile(AuthProfileRequest $request)
    {

        $currentUser = User::findOrFail(auth()->user()->id);

        $data = $currentUser->update(['name'=>$request->name,'address'=>$request->address,'phone'=>$request->phone]);
        if ($data) {
            return apiResponse(true, null, __('api.update_success'), null, 200);
        } else {
            return apiResponse(false, null, __('api.cant_update'), null, 401);
        }
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
            'email' => 'required|string|email',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return apiResponse(true, null, __('api.reset_link_will_send'), null, 200);
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
