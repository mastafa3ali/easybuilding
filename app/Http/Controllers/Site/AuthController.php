<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $guard = 'teacher';
    protected $redirectTo = '/teacher';
    protected $loginPath = '/teacher/login';

    public function __construct()
    {
        $this->redirectTo = '/teacher';
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
        //Auth::shouldUse('dashboard');

        if (auth()->check()) {
            return redirect('/teacher');
        }

        return view('teacher.pages.auth.login');
    }

    public function postLogin(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)
            ->whereIn('type', ['teacher'])
            ->with('teacherUser')
            ->first();

        if (!$user) {
            return redirect($this->loginPath)->with('phone', __('auth.failed'));
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if ($user->teacherUser) {
                session()->put('teacherId', $user->teacherUser->teacher_id);
            }
            return redirect('/teacher');
        }

        return redirect($this->loginPath)
            ->withInput($request->only('phone', 'remember'))
            ->withErrors(['phone' => 'Incorrect phone address or password']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/teacher/login');
    }
}
