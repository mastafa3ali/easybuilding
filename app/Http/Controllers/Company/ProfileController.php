<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    private $viewProfile = 'company.pages.profile.index';
    private $viewChangePassword = 'company.pages.profile.change_password';

    public function __construct()
    {
    }


    public function index(Request $request)
    {
        return view($this->viewProfile, get_defined_vars());
    }


    public function changePassword()
    {
        return view($this->viewChangePassword, get_defined_vars());
    }


}
