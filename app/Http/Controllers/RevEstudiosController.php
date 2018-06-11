<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;

class RevEstudiosController extends Controller
{
    public function showSolicitudRE()
    {
        return view('/menus/solicitud_RE');
    }

    public function postSolicitudRE(Request $request)
    {

      $request->validate([
          'num_cuenta' => 'required|numeric|digits:9'
          ],[
           'num_cuenta.required' => 'El campo es obligatorio',
           'num_cuenta.numeric' => 'El campo debe contener solo números',
           'num_cuenta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);
      // dd($request->num_cuenta);

      return redirect()->route('solicitud_RE', ['num_cta'=>$request->num_cuenta]);
    }
    public function showInfoSolicitudRE($num_cta)
    {
        // dd(Controller);
        $dto= new WSController();
        $dto=$dto->trayectorias($num_cta);
        return view('/menus/solicitud_RE_info', ['num_cta'=> $num_cta, 'trayectoria' => $dto]);
    }
    
    public function showSolicitudNC()
    {
        return view('/menus/datos_personales');
    }

    public function postDatosPersonales(Request $request)
    {

      $request->validate([
          'num_cuenta' => 'required|numeric|digits:9'
          ],[
           'num_cuenta.required' => 'El campo es obligatorio',
           'num_cuenta.numeric' => 'El campo debe contener solo números',
           'num_cuenta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);
      // dd($request->num_cuenta);

      return redirect()->route('datos_personales', ['num_cta'=>$request->num_cuenta]);
    }
    
    public function showDatosPersonales($num_cta)
    {
        // dd(Controller);
        $dto= new WSController();
        $dto=$dto->trayectorias($num_cta);
        return view('/menus/captura_datos', ['num_cta'=> $num_cta, 'trayectoria' => $dto]);
    }

    public function verificaDatosPersonales(Request $request)
    {
    
    $request->validate([
        'curp' => 'required|min:18|max:18|regex:/^[A-Z]{4}[0-9]{2}[0-1][0-9][0-9]{2}[M,H][A-Z]{5}[0-9]{2}$/'
        ],[
         'curp.required' => 'El CURP es obligatorio',
         'curp.min' => 'El CURP debe ser de 18 caracteres.',
         'curp.max' => 'El CURP debe ser de 18 caracteres.',
         'curp.regex' => 'El formato de CURP es incorrecto',
    ]);

    return redirect()->route('home');
    }

}