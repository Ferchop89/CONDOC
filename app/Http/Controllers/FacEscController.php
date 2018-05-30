<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;

class FacEscController extends Controller
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

}
