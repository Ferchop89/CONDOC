<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;
use App\Models\{Web_Service, IrregularidadesRE, Bach, Paises, 
                Niveles, User, Trayectoria, Nacionalidades,
                Registro_RE, Alumno, Esc_Proc};
use Illuminate\Support\Facades\Auth;
use Session;

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


    /*Revisiones de Estudio*/

    public function showSolicitudNC()
    {
        $title = "Realizar Revisión de Estudios";

        return view('/menus/datos_personales', ['title' => $title]);
    }
    
    public function showDatosPersonales(User $user, $num_cta)
    {
        $title = "Revisión de Estudios";
        //$num_cta=request()->input('num_cta');
        $ws_SIAE = Web_Service::find(2);
        $identidad = new WSController();
        $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
        
        $ws_SIAE = Web_Service::find(1);
        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

        $dgire = new WSController();
        $dgire = $dgire->ws_DGIRE($num_cta);
        //dd($dgire);

        //Número de trayectorias del alumno (-1 para indices de arreglo)
        $num_situaciones = count($trayectoria->situaciones)-1;

        //Irregularidades en acta de nacimiento, certificado y documento migratorio
        $irr_acta = IrregularidadesRE::where('cat_cve', 1)->get();
        $irr_cert = IrregularidadesRE::where('cat_cve', 2)->get();
        $irr_migr = IrregularidadesRE::where('cat_cve', 3)->get();

        //Información sobre escuelas según el plantel (catálogo)
        $esc_proc = array();
        foreach ($trayectoria->situaciones as $situacion) {
          $value = Bach::where('nom', $situacion->plantel_nombre)->first();
          array_push($esc_proc, $value);
        }

        //Escuelas de interés (Finalizadas o en curso que cubran al menos el 70% de créditos)
        $escuelas = array();
        foreach ($trayectoria->situaciones as $situacion) {
          if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35' 
            || ($situacion->causa_fin == null and $situacion->porcentaje_totales >= 70.00)){
            array_push($escuelas, $situacion);
          }
        }

        //Catálogo de países
        $paises = Paises::all();

        //Catálogo de nacionalidades
        $nacionalidades = Nacionalidades::all();

        //Roles (nombres) que tiene el usuario actual en el sistema
        $rol = Auth::user()->roles()->get();
        $roles_us = array();
        foreach($rol as $actual){
          array_push($roles_us, $actual->nombre);
        }

        //Variable que permitirá verirficar si el usuario actual es Oficinista
        // $rol = Auth::user()->hasRole('Ofisi');
    
        //Registro de las firmas en el sistema dado el número de cuenta del alumno
        $firmas = Registro_RE::where('num_cta', $num_cta)->first();

        //dd($firmas->actualizacion_fecha->date_format(d.m.Y));

        return view('/menus/captura_datos', ['title' => $title, 'num_cta'=> $num_cta, 'trayectoria' => $trayectoria, 
          'user' => $user, 'identidad' => $identidad, 'irr_acta' => $irr_acta, 'irr_cert' => $irr_cert, 
          'irr_migr' => $irr_migr, 'esc_proc' => $esc_proc, 'paises' => $paises, 'num_situaciones' => $num_situaciones, 
          'escuelas' => $escuelas, 'nacionalidades' => $nacionalidades, 'roles_us' => $roles_us, 'firmas' => $firmas]);
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
          'fecha_nac' => 'required|min:10|max:10|regex:/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/'
          ],[
           'curp.required' => 'El CURP es obligatorio',
           'curp.min' => 'El CURP debe ser de 18 caracteres.',
           'curp.max' => 'El CURP debe ser de 18 caracteres.',
           'curp.regex' => 'El formato de CURP es incorrecto',
           'fecha_nac.required' => 'La fecha de nacimiento es obligatoria',
           'fecha_nac.min' => 'La longitud de la fecha de nacimiento es errónea',
           'fecha_nac.max' => 'La longitud de la fecha de nacimiento es errónea',
           'fecha_nac.regex' => 'La fecha de nacimiento debe ser DD/MM/AAAA',
      ]);

      $num_cta = $request->num_cta; //

      $ws_SIAE = Web_Service::find(2);
      $identidad = new WSController();
      $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
      
      $ws_SIAE = Web_Service::find(1);
      $trayectoria = new WSController();
      $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

      //Información de escuelas de interés (Finalizadas)
      $nivel_esc = array();
      foreach ($trayectoria->situaciones as $situacion) {
        if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35'){
          array_push($nivel_esc, $situacion->nivel);
        }
      }

      //Número de trayectorias del alumno
      $num_situaciones = count($trayectoria->situaciones)-1;

      $nombres = $identidad->nombres;
      $apellido1 = $identidad->apellido1;
      $apellido2 = $identidad->apellido2;
      $plan_est = $trayectoria->situaciones[$num_situaciones]->plantel_clave;
      $nivel = $trayectoria->situaciones[$num_situaciones]->nivel;
      $carrera_nombre = $trayectoria->situaciones[$num_situaciones]->carrera_nombre;
      $orientacion = $trayectoria->situaciones[$num_situaciones]->plan_nombre;
      $curp = $_POST['curp']; 
      $sexo = $_POST['sexo'];
      $nacionalidad = $_POST['nacionalidad'];
      $fecha_nac = $_POST['fecha_nac'];
      $lugar_nac = $_POST['lugar_nac'];
      //$documento_identidad = $_POST['documento_identidad']; // ¿Cuáles se pondrán?
      $folio_doc = $_POST['folio_doc'];
      $irregularidad_doc = $_POST['irregularidad_doc'];
      //$tipo_esc = $request->tipo_esc; PENDIENTE X CATÁLOGO [ENTIDAD TAMBIÉN]
      $escuela_proc = $_POST['escuela_proc']; 
      $cct = $_POST['cct']; 
      $entidad_esc = $_POST['entidad_esc']; 
      $folio_cert = $_POST['folio_cert'];
      $seleccion_fecha = $_POST['seleccion_fecha'];
      $inicio_periodo = $_POST['inicio_periodo'];
      $fin_periodo = $_POST['fin_periodo'];
      $mes_anio = $_POST['mes_anio'];
      $promedio = $_POST['promedio'];
      $irregularidad_esc = $_POST['irregularidad_esc'];
      $jsec_firma = $request->input('jsec_firma');
      $jarea_firma = $request->input('jarea_firma');
      $jdepre_firma = $request->input('jdepre_firma');
      $jdeptit_firma = $request->input('jdeptit_firma');
      $jdeptit_firma = $request->input('jdeptit_firma');
      
      /*$sql = Alumno::insert(
        array('num_cta' => $num_cta,
              'curp' => $curp,
              'foto' => null, 
              'nombre_alumno' => $nombres, 
              'primer_apellido' => $apellido1, 
              'segundo_apellido' => $apellido2, 
              'sexo' => $sexo, 
              'fecha_nacimiento' => date('Y-m-d', strtotime($fecha_nac)),  
              'id_nacionalidad' => (int)$nacionalidad, 
              'pais_cve' => (int)$lugar_nac
      ));

      
      if($situacion->porcentaje_totales >= 70.00){
        $porcentaje = 1;
      }
      else{
        $porcentaje = 0;
      }

      $sql1 = Trayectoria::insertGetId(
        array('generacion' => (int)$situacion->generacion, 
              'num_planestudios' => (int)$situacion->plan_clave, 
              'nombre_planestudios' => $orientacion, //¿Son lo mismo?
              'num_cta'=> $num_cta,
              'avance_creditos' => (float)$situacion->porcentaje_totales,
              'cumple_requisitos' => $porcentaje,
              'id_nivel' => $nivel
      ));

      $sql2 = Registro_RE::insertGetId(
        array('actualizacion_nombre' => Auth::user()->nombre, 
              'actualizacion_fecha' => null, 
              'jsec_nombre' => null, 
              'jsec_fecha' => null, 
              'jarea_nombre' => null, 
              'jarea_fecha' => null, 
              'jdepre_nombre' => null, 
              'jdepre_fecha' => null, 
              'jdeptit_nombre' => null, 
              'jdeptit_fecha' => null, 
              'direccion_nombre' => null, 
              'direccion_fecha' => null, 
              'num_cta' => $num_cta
      ));

      for($i = $num_situaciones; $i == 0; $i--){
        $sql3 = Esc_Proc::insertGetId(
          array('nombre_escproc' => $escuela_proc[$i],
                'nivel' => $nivel_esc[$i],
                'clave' => $cct[$i],
                'folio_certificado' => (int)$folio_cert[$i],
                'seleccion_fecha' => $seleccion_fecha[$i],
                'mes_anio' => date('Y-m-d', strtotime($mes_anio[$i])), 
                'inicio_periodo' => (int)$inicio_periodo[$i],
                'fin_periodo' => (int)$fin_periodo[$i],
                'promedio' => (float)$promedio[$i],
                'pais_cve' => (int)$entidad_esc[$i], 
                'num_cta' => $num_cta
        ));
      }*/

      return redirect()->route('home');
    }

    public function showAgregarEsc($num_cta)
    {
      $ws_SIAE = Web_Service::find(1);
      $trayectoria = new WSController();
      $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

      //Niveles de interés dado el número de cuenta
      $niveles = array();
      foreach ($trayectoria->situaciones as $situacion) {
        if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35'){
          $value = $situacion->nivel;
          array_push($niveles, $value);
        }
      }

      //Nombres completos de cada nivel
      $nombres_nivel = array();
      foreach($niveles as $nvl){
        $value = Niveles::where('id_nivel', $nvl)->first();
        array_push($nombres_nivel, $value);
      }

      //Información de escuelas de interés (Finalizadas)
      $escuelas = array();
      foreach ($trayectoria->situaciones as $situacion) {
        if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35'){
          array_push($escuelas, $situacion);
        }
      }
      
      return view('/menus/agregar_esc', ['num_cta' => $num_cta, 'trayectoria' => $trayectoria, 'nombres_nivel' => $nombres_nivel,
                  'escuelas' => $escuelas]);
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

      $cuenta = $request->input('cuenta');
      $nivel_escuela = $request->input('nivel_escuela');
      $plan_estudios = $request->input('plan');

      $sql = Trayectoria::insertGetId(
        array('num_cta' => $cuenta, 'nivel' => $nivel_escuela, 'nombre_planestudios' => $plan_estudios)
      );

      dd($sql);

      return redirect()->route('agregar_esc', ['num_cta' => $request->num_cta]);
    }

    public function prueba($num_cta){
      $ws_SIAE = Web_Service::find(2);
      $identidad = new WSController();
      $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
      $ws_SIAE = Web_Service::find(1);

      $irr_acta = IrregularidadesRE::where('cat_cve', 1)->get();
      $irr_cert = IrregularidadesRE::where('cat_cve', 2)->get();

      $paises = Paises::all();

      return view('/menus/prueba', ['num_cta'=> $num_cta, 'identidad' => $identidad, 
        'irr_acta' => $irr_acta, 'irr_cert' => $irr_cert, 'paises' => $paises]); 
    } 

}
