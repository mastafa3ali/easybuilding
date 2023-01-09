<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $guard = 'company';
    protected $redirectTo = '/company';
    protected $loginPath = '/company/login';

    public function __construct()
    {
        $this->redirectTo = '/company';
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    public function login()
    {
        if (auth()->check()) {
            return redirect('/company');
        }

        return view('company.pages.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)
                    ->whereIn('type', [User::TYPE_COMPANY])
                    ->first();

        if (!$user) {
            return redirect($this->loginPath)->with('phone', __('auth.failed'));
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            session()->put('companyId', $user->id);
            return redirect('/company');
        }

        return redirect($this->loginPath)
            ->withInput($request->only('phone', 'remember'))
            ->withErrors(['phone' => 'Incorrect phone address or password']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/company/login');
    }
}
