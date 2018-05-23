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
    public function index(User $user){
        return view('auth/login');
    }
    public function home(User $user){
        return view('home', ['user' => $user]);
    }
    public function showTrayectoria(){
        return view('consultas.trayectoria');
    }

}
