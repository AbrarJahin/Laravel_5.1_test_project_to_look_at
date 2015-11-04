<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class GTWAuthController extends AuthController {

    protected $redirectAfterLogout = 'auth/login';

    public function __construct() {
        parent::__construct();
        $this->middleware('user.enabled');
    }

    public function getLogin() {
        return view('layouts.auth.login');
    }

    public function redirectPath() {
        return isAdmin() ? 'admin/dashboard' : 'members/dashboard';
    }

}
