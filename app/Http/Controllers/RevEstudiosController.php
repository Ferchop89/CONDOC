<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;
use Illuminate\Support\Facades\DB;
use App\Models\{Web_Service, IrregularidadesRE, Bach, Paises, 
                Niveles, User, Trayectoria, Nacionalidades,
                Registro_RE, Alumno, Esc_Proc};
use Illuminate\Support\Facades\Auth;
use Session;
use DateTime;

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
    
    public function showDatosPersonales($num_cta)
    {
        $title = "Revisión de Estudios";
        //Contenido de catálogos (Irregularidades, países y nacionalidades)
        $irr_acta = DB::connection('mysql2')->select('select * from irregularidades WHERE cat_cve = 1');
        $irr_cert = DB::connection('mysql2')->select('select * from irregularidades WHERE cat_cve = 2');
        $irr_migr = DB::connection('mysql2')->select('select * from irregularidades WHERE cat_cve = 3');
        $paises = DB::connection('mysql2')->select('select * from paises');
        $nacionalidades = DB::connection('mysql2')->select('select * from nacionalidades');
        //Roles (nombres) que tiene el usuario actual en el sistema
        $rol = Auth::user()->roles()->get();
        $roles_us = array();
        foreach($rol as $actual){
          array_push($roles_us, $actual->nombre);
        }
        //Registro de las firmas en el sistema del alumno
        $firmas = DB::connection('mysql2')->select('select * from registro__r_es WHERE num_cta = '.$num_cta);
        $datos = [
          'sistema' => NULL, 
          'title' => NULL, 
          'num_cta'=> $num_cta, 
          'trayectoria' => NULL, 
          'identidad' => NULL, 
          'irr_acta' => NULL, 
          'irr_cert' => NULL, 
          'irr_migr' => NULL, 
          'paises' => NULL, 
          'nacionalidades' => NULL, 
          'escuelas' => NULL,
          'firmas' => NULL, 
          'roles_us' => NULL, 
          'lic' => NULL 
        ];

        $condoc = DB::connection('mysql2')->select('select * from alumnos WHERE num_cta = '.$datos['num_cta']);

        //Verificamos si el alumno se encuentra en la BD del CONDOC
        if($condoc != NULL){

          $vista = '/menus/captura_datos';

          $situaciones = array();
          $total_situaciones = DB::connection('mysql2')->select('select * from esc__procs WHERE num_cta = '.$num_cta);
          
          $alumno = DB::connection('mysql2')->select('select * from alumnos WHERE num_cta = '.$num_cta);
          //Informacion de nivel licenciatura
          $value_lic = DB::connection('mysql2')->select('select * from trayectorias WHERE num_cta = '.$num_cta);

          //Datos necesarios para identidad
          $identidad = (object) [
            'cuenta' => $alumno[0]->num_cta,
            'nombres' => $alumno[0]->nombre_alumno,
            'apellido1' => $alumno[0]->primer_apellido,
            'apellido2' => $alumno[0]->segundo_apellido,
            'curp' => $alumno[0]->curp,
            'sexo' => $alumno[0]->sexo,
            'nacimiento' => $alumno[0]->fecha_nacimiento,
            'nacionalidad' => $alumno[0]->id_nacionalidad,
            'entidad-nacimiento' => $alumno[0]->pais_cve
          ];
          foreach($total_situaciones as $situacion){
            $sit = (object) [
              'plantel_nombre' => $situacion->nombre_escproc,
              'nivel' => $situacion->nivel,
              'plantel_clave' => $situacion->clave,
              'folio_certificado' => $situacion->folio_certificado,
              'seleccion_fecha' => $situacion->seleccion_fecha,
              'mes_anio' => $situacion->mes_anio,
              'inicio_periodo' => $situacion->inicio_periodo,
              'fin_periodo' => $situacion->fin_periodo,
              'promedio' => $situacion->promedio,
              'pais_cve' => $situacion->pais_cve,
              'num_cta' => $situacion->num_cta,
              'irre_cert' => $situacion->irre_cert
            ];
            array_push($situaciones, $sit);
          }
          $trayectoria = (object) [
            'cuenta' => $num_cta,
            'situaciones' => $situaciones
          ];
          $lic = (object) [
            'nivel' => $value_lic[0]->id_nivel,
            'plan_clave' => $value_lic[0]->num_planestudios,
            'carrera_nombre' => $value_lic[0]->nombre_carrera,
            'plan_nombre' => $value_lic[0]->nombre_planestudios
          ];
          $dbcondoc = [
            'sistema' => $alumno[0]->sistema,
            'title' => $title,
            'num_cta'=> $num_cta, 
            'trayectoria' => $trayectoria, 
            'identidad' => $identidad,
            'irr_acta' => $irr_acta,
            'irr_cert' => $irr_cert,
            'irr_migr' => $irr_migr,
            'paises' => $paises,
            'nacionalidades' => $nacionalidades,
            'roles_us' => $roles_us,
            'lic' => $lic
          ];

          //Escuelas de interés (Finalizadas o en curso que cubran al menos el 70% de créditos)
          $dbcondoc['escuelas'] = $situaciones;

          //Registro de las firmas en el sistema del alumno
          $dbcondoc['firmas'] = $firmas[0];

          DB::disconnect('mysql2');
          $datos = $dbcondoc;

        }
        else {
          
          $vista = '/menus/captura_datos';

          //En caso de no encontrarse, se busca primero en SIAE
          $ws_SIAE = Web_Service::find(2);
          $identidad = new WSController();
          $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

          if(isset($identidad) && $identidad->mensaje == "El Alumno existe"){

            $siae = [
              'sistema' => 'SIAE',
              'title' => $title,
              'num_cta' => $num_cta,
              'identidad' => $identidad,
              'irr_acta' => $irr_acta,
              'irr_cert' => $irr_cert,
              'irr_migr' => $irr_migr,
              'paises' => $paises,
              'nacionalidades' => $nacionalidades,
              'roles_us' => $roles_us
            ];
            $ws_SIAE = Web_Service::find(1);
            $trayectoria = new WSController();
            $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

            $siae['trayectoria'] = $trayectoria;
            
            //Escuelas de interés (Finalizadas o en curso que cubran al menos el 70% de créditos)
            $siae['escuelas'] = array();
            foreach ($trayectoria->situaciones as $situacion) {
              if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35' 
                || ($situacion->causa_fin == null and $situacion->porcentaje_totales >= 70.00)){
                array_push($siae['escuelas'], $situacion);
              }
            }

            //Registro de las firmas en el sistema del alumno
            $siae['firmas'] = $firmas;

            //Informacion de nivel licenciatura
            foreach ($trayectoria->situaciones as $value) {
                if($value->nivel == 'L')
                {
                    $siae['lic'] = $value;
                }
            }

            DB::disconnect('mysql2');
            $datos = $siae;

          }
          //Si en SIAE tampoco se encontró, se busca en DGIRE
          else{

            $ws_DGIRE = new WSController();
            $ws_DGIRE = $ws_DGIRE->ws_DGIRE($num_cta);

            //Verificamos si DGIRE no tiene información del alumno, notificamos
            if(property_exists($ws_DGIRE->respuesta, "error")){

              $descripcion = $ws_DGIRE->respuesta->error->descripcion;
              $vista = '/errors/error_info';
              $datos = ['descripcion' => $descripcion];

            }
            //En caso de que sí cuente con ella, continuamos
            else{

              $vista = '/menus/captura_datos';
              $info = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno;
              //Validacion para el sexo
              if($info->sexo == 1){
                $sexo_db = "MASCULINO";
              }
              else if($info->sexo == 2){
                $sexo_db = "FEMENINO";
              }
              else{
                $sexo_db = NULL;
              }
              //Validación para la nacionalidad
              if($info->nacionalidad == "M"){
                $id_nacionalidad = 1;
              }
              else{
                $id_nacionalidad = NULL;
              }
              $situaciones = array();

              //Datos necesarios para identidad
              $identidad = (object) [
                'cuenta' => $info->numeroCuenta,
                'nombres' => $info->nombre,
                'apellido1' => $info->apellidoPaterno,
                'apellido2' => $info->apellidoMaterno,
                'curp' => $info->curp,
                'sexo' => $sexo_db,
                'nacimiento' => $info->fechaNacimiento,
                'nacionalidad' => $id_nacionalidad,
                'entidad-nacimiento' => NULL
              ];

              //Situaciones del alumno (niveles B y L)
              array_push($situaciones, $situacion = (object) [
                                            'plantel_nombre' => $info->nombreEscuelaBachillerato,
                                            'nivel' => "B",
                                            'plantel_clave' => NULL,
                                            'folio_certificado' => NULL,
                                            'seleccion_fecha' => NULL,
                                            'mes_anio' => NULL,
                                            'inicio_periodo' => NULL,
                                            'fin_periodo' => NULL,
                                            'promedio' => $info->promedioBachillerato,
                                            'pais_cve' => NULL,
                                            'num_cta' => $info->numeroCuenta,
                                            'irre_cert' => NULL
              ]);

              array_push($situaciones, $situacion = (object) [
                                            'plantel_nombre' => $info->nombreEscuelaLicenciatura,
                                            'nivel' => "L",
                                            'plantel_clave' => NULL,
                                            'folio_certificado' => NULL,
                                            'seleccion_fecha' => NULL,
                                            'mes_anio' => NULL,
                                            'inicio_periodo' => NULL,
                                            'fin_periodo' => NULL,
                                            'promedio' => $info->promedioLicenciatura,
                                            'pais_cve' => NULL,
                                            'num_cta' => $info->numeroCuenta,
                                            'irre_cert' => NULL
              ]);

              $trayectoria = (object) [
                'cuenta' => $info->numeroCuenta,
                'situaciones' => $situaciones
              ];

              $lic = (object) [
                'nivel' => "L",
                'plan_clave' => (int)$info->clavePlanLicenciatura,
                'carrera_nombre' => NULL,
                'plan_nombre' => $info->nombrePlanLicenciatura
              ];

              $dgire = [
                'sistema' => 'DGIRE',
                'title' => $title,
                'num_cta' => $num_cta,
                'trayectoria' => $trayectoria,
                'identidad' => $identidad,
                'irr_acta' => $irr_acta,
                'irr_cert' => $irr_cert,
                'irr_migr' => $irr_migr,
                'paises' => $paises,
                'nacionalidades' => $nacionalidades,
                'roles_us' => $roles_us,
                'lic' => $lic
              ];

              //Escuelas de interés (Finalizadas o en curso que cubran al menos el 70% de créditos)
              $dgire['escuelas'] = $situaciones;

              //Registro de las firmas en el sistema del alumno
              $dgire['firmas'] = $firmas;

              DB::disconnect('mysql2');
              $datos = $dgire;

            }

          }

        }

        return view($vista, $datos);
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

      $num_cta = $request->num_cta;

      $sistema = $request->sistema;
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

      $condoc = DB::connection('mysql2')->select('select * from alumnos WHERE num_cta = '.$num_cta);

        //Verificamos si el alumno se encuentra en la BD del CONDOC
        if($condoc != NULL){

          $nombres = $condoc[0]->nombre_alumno;
          $apellido1 = $condoc[0]->primer_apellido;
          $apellido2 = $condoc[0]->segundo_apellido;

          $trayectoria = DB::connection('mysql2')->select('select * from trayectorias WHERE num_cta = '.$num_cta);
          $plan_est = $trayectoria[0]->num_planestudios;
          $nivel = $trayectoria[0]->id_nivel;
          $carrera_nombre = $trayectoria[0]->nombre_carrera;
          $orientacion = $trayectoria[0]->nombre_planestudios;

          dd($orientacion);

          DB::disconnect('mysql2');

        }
        //Si es vacía, obtenermos información del WS
        else{

          //Verificamos si la información proviene del SIAE
          if($sistema == 'SIAE'){

            $ws_SIAE = Web_Service::find(2);
            $identidad = new WSController();
            $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
               
            $ws_SIAE = Web_Service::find(1);
            $trayectoria = new WSController();
            $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

            $nombres = $identidad->nombres;
            $apellido1 = $identidad->apellido1;
            $apellido2 = $identidad->apellido2;
            $plan_est = $trayectoria->situaciones[$num_situaciones]->plan_clave;
            $nivel = $trayectoria->situaciones[$num_situaciones]->nivel;
            $carrera_nombre = $trayectoria->situaciones[$num_situaciones]->carrera_nombre;
            $orientacion = $trayectoria->situaciones[$num_situaciones]->plan_nombre;

            //Información de escuelas de interés (Finalizadas)
            $nivel_esc = array();
            foreach ($trayectoria->situaciones as $situacion) {
              if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35'){
                array_push($nivel_esc, $situacion->nivel);
              }
            }
                
            $sql = Alumno::insert(
              array('num_cta' => $num_cta,
                    'curp' => $curp,
                    'foto' => null,
                    'nombre_alumno' => $nombres,
                    'primer_apellido' => $apellido1,
                    'segundo_apellido' => $apellido2,
                    'sexo' => $sexo,
                    'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $fecha_nac))),
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
                    'num_planestudios' => (int)$plan_est,
                    'nombre_planestudios' => $orientacion, //¿Son lo mismo?
                    'num_cta'=> $num_cta,
                    'avance_creditos' => (float)$situacion->porcentaje_totales,
                    'cumple_requisitos' => $porcentaje, //1 cumple, 0 no cumple
                    'id_nivel' => $nivel,
                    'nombre_carrera' => $situacion->carrera_nombre
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

            foreach($nivel_esc as $key=>$value) {
              $sql3 = Esc_Proc::insertGetId(
                array('nombre_escproc' => $escuela_proc[$key],
                      'nivel' => $nivel_esc[$key],
                      'clave' => $cct[$key],
                      'folio_certificado' => (int)$folio_cert[$key],
                      'seleccion_fecha' => (int)$seleccion_fecha[$key],
                      'mes_anio' => date('Y-m-d', strtotime(str_replace('/', '-', $mes_anio[$key]))),
                      'inicio_periodo' => (int)$inicio_periodo[$key],
                      'fin_periodo' => (int)$fin_periodo[$key],
                      'promedio' => (float)$promedio[$key],
                      'pais_cve' => (int)$entidad_esc[$key],
                      'num_cta' => $num_cta
              ));
            }

          }
          //En caso contrario, buscamos en DGIRE
          else{



          }
        }

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
        if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35' 
                || ($situacion->causa_fin == null and $situacion->porcentaje_totales >= 70.00)){
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

      dd($identidad);

      return view('/menus/prueba', ['num_cta'=> $num_cta, 'identidad' => $identidad, 
        'irr_acta' => $irr_acta, 'irr_cert' => $irr_cert, 'paises' => $paises]); 
    } 

}
