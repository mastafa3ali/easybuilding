<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\_Class;
use App\Models\ClassUser;
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
    }


    public function register(Request $request)
    {

        $request['phone'] = convertArabicNumbers($request->phone);
        $validate = array(
            'name' => 'required',
            'type' => 'required',
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
