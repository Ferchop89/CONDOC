<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

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

    public function username(){
      return 'username';
    }

    protected function redirectTo()
    {
        if (Auth::check())
        {
            if(Auth::user()->is_active)
            {
                if(Auth::user()->hasRole('admin'))
                {
                    return 'admin/home';
                }
                else {
                    return 'home';
                }
            }
            else {
                // dd(request());
                Auth::logout();
                // return Redirect::to('login');
                Session::flash('message', "Tu cuenta esta bloqueada, ponte en contacto con el administrador");
                // return Redirect::back();
            }
        }
        return '/';
    }
}
