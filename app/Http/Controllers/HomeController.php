<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin'))
        {
            // dd(Auth::user());
            return view('admin/users/HomeAdmin', ['user' => Auth::user()]);

        }
        else{
            return view('home');
        }
        // dd(Auth::user()->hasRole('admin'));
        // return view('home');
    }
}
