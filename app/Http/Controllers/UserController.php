<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Role;
use App\Models\Procedencia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        /*

        if (Auth::user()->hasRole('admin'))
            return view('login');
        else

        */
        // dd(Auth::check());
        if (Auth::check()){
            // dd("No estas logueado");
            //return view('auth/login');
            if (Auth::user()->hasRole('admin'))
            {
                return view('home');

            }
            else{
                return view('admin_dashboard');
            }
        }
        else {
            return view('auth/login');

        }


    }

}
