<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;
use App\Models\{Web_Service, IrregularidadesRE, Bach, Paises};

class RevEstudiosController extends Controller
{
    public function showSolicitudRE()
    {
        return view('/menus/solicitud_RE');
    }

    public function postSolicitudRE(Request $request)
    {

      $request->validate([
          'num_cta' => 'required|numeric|digits:9'
          ],[
           'num_cta.required' => 'El campo es obligatorio',
           'num_cta.numeric' => 'El campo debe contener solo números',
           'num_cta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);
      // dd($request->num_cta);

      return redirect()->route('solicitud_RE', ['num_cta'=>$request->num_cta]);
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
          return view('/menus/solicitud_RE_info', ['num_cta'=> $num_cta, 'trayectoria' => $trayectorias_75, 'msj' => $msj]);
      }
    }
    
    public function showSolicitudNC()
    {
        return view('/menus/datos_personales');
    }
    
    public function showDatosPersonales($num_cta)
    {
        // dd(Controller);
        //$num_cta=request()->input('num_cta');
        $ws = Web_Service::find(2);
        $identidad = new WSController();
        $identidad = $identidad->ws($ws->nombre, $num_cta, $ws->key);
        $ws = Web_Service::find(1);

        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws($ws->nombre, $num_cta, $ws->key);

        //Número de trayectorias del alumno (válidad o inválidas)
        $num_situaciones = count($trayectoria->situaciones);

        //Irregularidades en acta de nacimiento y certificado
        $irr_acta = IrregularidadesRE::where('cat_cve', 1)->get();
        $irr_cert = IrregularidadesRE::where('cat_cve', 2)->get();

        //Información sobre escuelas según el plantel (catálogo)
        $esc_proc = array();
        foreach ($trayectoria->situaciones as $situacion) {
          $value = Bach::where('nom', $situacion->plantel_nombre)->first();
          array_push($esc_proc, $value);
        }

        //Escuelas de interés (Finalizadas)
        $escuelas = array();
        foreach ($trayectoria->situaciones as $situacion) {
          if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35'){
            array_push($escuelas, $situacion);
          }
        }

        //Catálogo de países
        $paises = Paises::all();

        //$esc_proc = Bach::where('nom', $trayectoria->situaciones[1]->plantel_nombre)->first();

        return view('/menus/captura_datos', ['num_cta'=> $num_cta, 'trayectoria' => $trayectoria, 
          'identidad' => $identidad, 'irr_acta' => $irr_acta, 'irr_cert' => $irr_cert, 'esc_proc' => $esc_proc,
          'paises' => $paises, 'num_situaciones' => $num_situaciones, 'escuelas' => $escuelas]);
    }

    public function postDatosPersonales(Request $request)
    {

      $request->validate([
          'num_cta' => 'required|numeric|digits:9'
          ],[
           'num_cta.required' => 'El campo es obligatorio',
           'num_cta.numeric' => 'El campo debe contener solo números',
           'num_cta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);
      // dd($request->num_cta);
      //$this->showDatosPersonales();
      //dd("alto");
      //return redirect();

      return redirect()->route('rev_est', ['num_cta' => $request->num_cta]);
    }

    public function verificaDatosPersonales(Request $request)
    {
    
    $request->validate([
        'curp' => 'required|min:18|max:18|regex:/^[A-Z]{4}[0-9]{2}[0-1][0-9][0-9]{2}[M,H][A-Z]{5}[0-9]{2}$/',
        'f_nac' => 'required|min:10|max:10|regex:/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/'
        ],[
         'curp.required' => 'El CURP es obligatorio',
         'curp.min' => 'El CURP debe ser de 18 caracteres.',
         'curp.max' => 'El CURP debe ser de 18 caracteres.',
         'curp.regex' => 'El formato de CURP es incorrecto',
         'f_nac.required' => 'La fecha de nacimiento es obligatoria',
         'f_nac.min' => 'La longitud de la fecha de nacimiento es errónea',
         'f_nac.max' => 'La longitud de la fecha de nacimiento es errónea',
         'f_nac.regex' => 'La fecha de nacimiento debe ser DD/MM/AAAA'
    ]);

    return redirect()->route('home');
    }

    public function showAgregarEsc($num_cta)
    {
      return view('/menus/agregar_esc', ['num_cta' => $num_cta]);
    }

    public function validarInformacion(Request $request)
    {
    
      $request->validate([
          'num_cta' => 'required|numeric|digits:9'
          ],[
           'num_cta.required' => 'El campo es obligatorio',
           'num_cta.numeric' => 'El campo debe contener solo números',
           'num_cta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);

      return redirect()->route('rev_est', ['num_cta' => $request->num_cta]);
    }

}