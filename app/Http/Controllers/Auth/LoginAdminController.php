<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_admin(){
        return view("admin.login");
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        );
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            return true;
        } else {
            return false;
        }
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 1) {
            return redirect()->route('dashboard_admin.index');
        }
        else if ($user->role == 3) {
            return redirect()->route('store_admin.index');
        }
        else {
            return redirect()->route('home');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

}
