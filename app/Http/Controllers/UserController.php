<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\{User, Role, Procedencia, Web_Service, Menu};
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\WSController;

class UserController extends Controller
{
    public function index(User $user){
        return view('auth/login');
    }
    public function home(User $user, Menu $menus){
        return view('home', [
            'user' => $user,
            // 'menu' => $menus,
    ]);
    }
    public function showTrayectoria(){
        return view('consultas.trayectoria');
    }
    public function showRecepcionExpedientes(){
        return view('menus/recepcion_expedientes', ['arreglo' => 'prueba']);
    }

    public function datosExpedientes(){
        $num_cta=request()->input('num_cta');
        $ws = Web_Service::find(2);
        $identidad = new WSController();
        $identidad = $identidad->ws($ws->nombre, $num_cta, $ws->key);
        $ws = Web_Service::find(1);
        // dd($ws);
        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws($ws->nombre, $num_cta, $ws->key);
        dd($identidad, "hola", $trayectoria);
    }
    public function post_numcta_Validate()
    {
        request()->validate
        (
            ['num_cta' => 'required|numeric|digits:9'],[
           'num_cta.required' => 'El campo es obligatorio',
           'num_cta.numeric' => 'El campo debe contener solo números',
           'num_cta.digits'  => 'El campo debe ser de 9 dígitos',
        ]);
        $this->datosExpedientes();
        dd("alto");
        return redirect();
    }

}
