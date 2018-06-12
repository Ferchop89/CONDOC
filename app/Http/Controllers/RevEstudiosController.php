<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;
use App\Models\Web_Service;

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
      $dto= new WSController();
      $dto=$dto->trayectorias($num_cta);
      $trayectorias_75 = array();
      $generacion=substr($num_cta, 1, -6);
      // dd($dto);
      // dd($num_cta, substr($num_cta, 1, -6));
      $msj="";
      foreach ($dto as $value) {
          if ($value->porcentaje_totales >= 70.00) {
              if($value->nivel == 'L')
              {
                  if($value->causa_fin == '11' || $value->causa_fin == null)
                  {
                      //Verificar que no tenga revision de estudios autorizadas
                      array_push($trayectorias_75, $value);
                      $msj="Solicitar";
                  }
                  elseif ($value->causa_fin == '14') {
                      $msj="El alumno con número de cuenta ".$num_cta." ya se encuentra titulado";
                  }
              }
          }
          else {
              $msj="El alumno no puede solicitar revisiones de estudio. No cumple con el avance";
          }
      }
      if($generacion == '06' || $generacion == '07' || $generacion == '08' || $generacion == '09' || $generacion == '10' || $generacion == '11')
      {
          $msj = "El alumno con número de cuenta ".$num_cta." no cuenta con documentación.";
          return view('/menus/solicitud_RE_citatorio', ['num_cta'=> $num_cta, 'trayectoria' => $trayectorias_75, 'msj' => $msj]);
      }
      else {

          // dd($dto, $trayectorias_75);
          return view('/menus/solicitud_RE_info', ['num_cta'=> $num_cta, 'trayectoria' => $trayectorias_75, 'msj' => $msj]);
      }
    }
    
    public function showSolicitudNC()
    {
        return view('/menus/datos_personales');
    }
    
    public function showDatosPersonales()
    {
        // dd(Controller);
        $num_cta=request()->input('num_cta');
        $ws = Web_Service::find(2);
        $identidad = new WSController();
        $identidad = $identidad->ws($ws->nombre, $num_cta, $ws->key);
        $ws = Web_Service::find(1);
        // dd($ws);
        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws($ws->nombre, $num_cta, $ws->key);
        dd($identidad, "hola", $trayectoria);
        //return view('/menus/captura_datos', ['num_cta'=> $num_cta, 'trayectoria' => $trayectoria, 'identidad' => $identidad]);
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
      $this->showDatosPersonales();
      dd("alto");
      return redirect();
      //return redirect()->route('datos_personales');
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