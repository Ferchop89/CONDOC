<?php
namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WSController;
use Illuminate\Support\Facades\DB;
use App\Models\{Web_Service, IrregularidadesRE, Paises,
                Niveles, User, Trayectoria, Nacionalidades,
                Registro_RE, Alumno, Esc_Proc};
use Illuminate\Support\Facades\Auth;
use Hash;
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

      return redirect()->route('solicitud_RE', ['num_cta'=>$request->num_cta]);
    }
    public function showInfoSolicitudRE($num_cta)
    {
      $dto= new WSController();
      $dto=$dto->trayectorias($num_cta);
      $trayectorias_75 = array();
      $generacion=substr($num_cta, 1, -6);
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
          $total_situaciones = DB::connection('mysql2')->select('select * from esc__procs WHERE num_cta = '.$num_cta.' ORDER BY FIELD(nivel, "S","B", "T", "L")');

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
            'entidad-nacimiento' => $alumno[0]->pais_cve,
            'irre_doc' => $alumno[0]->irre_doc,
            'folio_doc' => $alumno[0]->folio_doc
          ];
          foreach($total_situaciones as $situacion){
            $sit = (object) [
              'plantel_nombre' => $situacion->nombre_escproc,
              'nivel' => $situacion->nivel,
              'plantel_clave' => $situacion->clave,
              'seleccion_fecha' => $situacion->seleccion_fecha,
              'mes_anio' => $situacion->mes_anio,
              'inicio_periodo' => $situacion->inicio_periodo,
              'fin_periodo' => $situacion->fin_periodo,
              'promedio' => $situacion->promedio,
              'num_cta' => $situacion->num_cta,
              'irre_cert' => $situacion->irre_cert,
              'folio_cert' => $situacion->folio_cert,
              'sistema_escuela' => $situacion->sistema_escuela
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
            'sistema' => $alumno[0]->sistema_personal,
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

          //En caso de no encontrarse, se busca primero en SIAE
          $ws_SIAE = Web_Service::find(2);
          $identidad = new WSController();
          $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

          if(isset($identidad) && (isset($identidad->mensaje) && $identidad->mensaje == "El Alumno existe")){

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
              if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35' || $situacion->causa_fin == '11'
                || ($situacion->causa_fin == null and $situacion->porcentaje_totales >= 70.00 )){
                $situacion->sistema_escuela = 'SIAE';
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

            //En caso de que el alumno curse licenciatura y cumpla 70% de créditos, prosigue la RE
            if(isset($siae['lic']) && $siae['lic']->porcentaje_totales >= 70.00){
              $vista = '/menus/captura_datos';
              $datos = $siae;
            }
            //En caso contrario, se notifica según sea el caso
            else{
              if(isset($siae['lic']) && $siae['lic']->porcentaje_totales < 70.00){
                $vista = '/errors/error_info';
                $datos = ['descripcion' => "El alumno no cumple con el porcentaje requerido."];
              }
              else{
                $vista = '/errors/error_info';
                $datos = ['descripcion' => "El alumno no cursa licenciatura."];
              }
            }

            DB::disconnect('mysql2');

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

              //Verificamos que el alumno este en nivel Licenciatura
              if($info->nivelAcademico == "05"){
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

                //Situaciones del alumno (par Licenciatura y el nivel inmediato anterior)
                array_push($situaciones, $situacion = (object) [
                                              'plantel_nombre' => $info->nombreEscuelaBachillerato,
                                              'nivel' => "B",
                                              'plantel_clave' => NULL,
                                              'folio_cert' => NULL,
                                              'seleccion_fecha' => NULL,
                                              'mes_anio' => NULL,
                                              'inicio_periodo' => NULL,
                                              'fin_periodo' => NULL,
                                              'promedio' => $info->promedioBachillerato,
                                              'num_cta' => $info->numeroCuenta,
                                              'irre_cert' => NULL,
                                              'sistema_escuela' => 'DGIRE'
                ]);

                array_push($situaciones, $situacion = (object) [
                                              'plantel_nombre' => $info->nombreEscuelaLicenciatura,
                                              'nivel' => "L",
                                              'plantel_clave' => NULL,
                                              'folio_cert' => NULL,
                                              'seleccion_fecha' => NULL,
                                              'mes_anio' => NULL,
                                              'inicio_periodo' => NULL,
                                              'fin_periodo' => NULL,
                                              'promedio' => $info->promedioLicenciatura,
                                              'num_cta' => $info->numeroCuenta,
                                              'irre_cert' => NULL,
                                              'sistema_escuela' => 'DGIRE'
                ]);

                $trayectoria = (object) [
                  'cuenta' => $info->numeroCuenta,
                  'situaciones' => $situaciones
                ];

                //Obtenemos el nombre de la carrera
                $carrera = DB::connection('mysql2')->select('select car_car_siae from carreras WHERE car_cve_plt_car = '.$info->cveCarrera);
                $res = DB::connection('mysql2')->select('select carr_siae_nombre from carr_siae WHERE carr_siae_cve = '.$carrera[0]->car_car_siae);

                $lic = (object) [
                  'nivel' => "L",
                  'plan_clave' => (int)$info->clavePlanLicenciatura,
                  'carrera_nombre' => $res[0]->carr_siae_nombre,
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
              //En caso contrario, se notifica que no procede la Revisión de Estudios
              else{
                $vista = '/errors/error_info';
                $datos = ['descripcion' => "El alumno no cursa Licenciatura"];
              }
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

      ////////// SE NECESITAN : NIVELES Y NOMBRES DE PLANES //////////
      $db = DB::connection('mysql2')->select('select nivel, nombre_plan from esc__procs WHERE num_cta = '.$num_cta.' ORDER BY FIELD(nivel, "S","B", "T", "L")');
      $db_nivel = array();
      $db_plan = array();
      foreach ($db as $consulta) {
        array_push($db_nivel, $consulta->nivel);
        array_push($db_plan, $consulta->nombre_plan);
      }
      ////////// SE NECESITAN : NIVELES Y NOMBRES DE PLANES //////////

      $curp = $_POST['curp'];
      $sexo = $_POST['sexo'];
      $nacionalidad = $_POST['nacionalidad'];
      $fecha_nac = $_POST['fecha_nac'];
      $lugar_nac = $_POST['lugar_nac'];
      $folio_doc = $_POST['folio_doc'];
      if($nacionalidad == "2"){
        $irregularidad_doc = $_POST['irregularidad_doc_cert'];
      }else{
        $irregularidad_doc = $_POST['irregularidad_doc_act'];
      }
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
      $direccion_firma = $request->input('direccion_firma');

      $condoc = DB::connection('mysql2')->select('select * from alumnos WHERE num_cta = '.$num_cta);

        //Verificamos si el alumno se encuentra en la BD del CONDOC
        if($condoc != NULL){

          $alumno = DB::connection('mysql2')->table('alumnos')->where('num_cta', $num_cta);
          $esc_proc = DB::connection('mysql2')->select('select * from esc__procs WHERE num_cta = '.$num_cta.' ORDER BY FIELD(nivel, "S","B", "T", "L")');
          $esc = DB::connection('mysql2')->table('esc__procs')->where('num_cta', $num_cta);
          $trayectoria = DB::connection('mysql2')->select('select * from trayectorias WHERE num_cta = '.$num_cta);
          $registro = DB::connection('mysql2')->select('select * from registro__r_es WHERE num_cta = '.$num_cta);

          if($curp != $condoc[0]->curp){
            $alumno->update(['curp' => $curp, 'sistema_personal' => "CONDOC"]);
          }
          if($sexo != $condoc[0]->sexo){
            $alumno->update(['sexo' => $sexo, 'sistema_personal' => "CONDOC"]);
          }
          if($nacionalidad != $condoc[0]->id_nacionalidad){
            $alumno->update(['id_nacionalidad' => $nacionalidad, 'sistema_personal' => "CONDOC"]);
          }
          if($fecha_nac != date('d/m/Y', strtotime($condoc[0]->fecha_nacimiento))){
            $alumno->update(['fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $fecha_nac))), 'sistema_personal' => "CONDOC"]);
          }
          if($lugar_nac != $condoc[0]->pais_cve){
            $alumno->update(['pais_cve' => $lugar_nac, 'sistema_personal' => "CONDOC"]);
          }
          if($folio_doc != $condoc[0]->folio_doc){
            $alumno->update(['folio_doc' => $folio_doc, 'sistema_personal' => "CONDOC"]);
          }
          if($irregularidad_doc != $condoc[0]->irre_doc){
            $alumno->update(['irre_doc' => $irregularidad_doc, 'sistema_personal' => "CONDOC"]);
          }
          foreach ($esc_proc as $key=>$value) {
            if($escuela_proc[$key] != $esc_proc[$key]->nombre_escproc){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['nombre_escproc' => $escuela_proc[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("1-".$key);
            }
            if($cct[$key] != $esc_proc[$key]->clave){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['clave' => $cct[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("2-".$key);
            }
            if($folio_cert[$key] != (int)$esc_proc[$key]->folio_cert){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['folio_cert' => (int)$folio_cert[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("3-".$key." -----  ".$db_nivel[$key]." ------- ".$db_plan[$key]." ------ ".$folio_cert[$key]);
            }
            if($seleccion_fecha[$key] != (int)$esc_proc[$key]->seleccion_fecha){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['seleccion_fecha' => (int)$seleccion_fecha[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("4-".$key);
            }
            //Si se seleccionó el periodo, hacemos null la fecha
            if($seleccion_fecha[$key] == 0){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['mes_anio' => NULL, 'inicio_periodo' => (int)$inicio_periodo[$key], 'fin_periodo' => (int)$fin_periodo[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("5-".$key);
            }
            //En caso contrario, hacemos null periodo
            else{
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['inicio_periodo' => NULL, 'fin_periodo' => NULL, 'mes_anio' => date('Y-m-d', strtotime(str_replace('/', '-', $mes_anio[$key]))), 'sistema_escuela' => "CONDOC"]);
                  //dd("6-".$key);
            }
            if($promedio[$key] != (float)$esc_proc[$key]->promedio){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['promedio' => (float)$promedio[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("7-".$key);
            }
            if($irregularidad_esc[$key] != $esc_proc[$key]->irre_cert){
              $esc->where('nivel', '=', $db_nivel[$key])
                  ->where('nombre_plan', '=', $db_plan[$key])
                  ->update(['irre_cert' => $irregularidad_esc[$key], 'sistema_escuela' => "CONDOC"]);
                  //dd("8-".$key);
            }
          }

        }
        //Si es vacía, obtenermos información del WS
        else{

          $ws_SIAE = Web_Service::find(2);
          $identidad = new WSController();
          $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

          //Verificamos si la información proviene del SIAE
          if(isset($identidad) && (isset($identidad->mensaje) && $identidad->mensaje == "El Alumno existe")){
               
            $ws_SIAE = Web_Service::find(1);
            $trayectoria = new WSController();
            $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

            $num_situaciones = count($trayectoria->situaciones)-1;
            $nombres = $identidad->nombres;
            $apellido1 = $identidad->apellido1;
            $apellido2 = $identidad->apellido2;
            $plan_est = $trayectoria->situaciones[$num_situaciones]->plan_clave;
            $nivel = $trayectoria->situaciones[$num_situaciones]->nivel;
            $carrera_nombre = $trayectoria->situaciones[$num_situaciones]->carrera_nombre;
            $orientacion = $trayectoria->situaciones[$num_situaciones]->plan_nombre;

            //Niveles de escuelas de interés
            $nivel_esc = array();
            $info_sit = array();
            foreach ($trayectoria->situaciones as $situacion) {
              if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35' || $situacion->causa_fin == '11'
                || ($situacion->causa_fin == null and $situacion->porcentaje_totales >= 70.00)){
                array_push($nivel_esc, $situacion->nivel);
                array_push($info_sit, $situacion);
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
                    'pais_cve' => (int)$lugar_nac,
                    'sistema_personal' => 'SIAE',
                    'irre_doc' => (int)$irregularidad_doc,
                    'folio_doc' => (int)$folio_doc
            ));

            $sql1 = Trayectoria::insertGetId(
              array('generacion' => (int)$situacion->generacion,
                    'num_planestudios' => (int)$plan_est,
                    'nombre_planestudios' => $orientacion, //¿Son lo mismo?
                    'num_cta'=> $num_cta,
                    'avance_creditos' => (float)$situacion->porcentaje_totales,
                    'cumple_requisitos' => 1, //Para este punto ya debe cumplirlo
                    'id_nivel' => $nivel,
                    'nombre_carrera' => $situacion->carrera_nombre
            ));

            /*$sql2 = Registro_RE::insertGetId(
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
            ));*/

            foreach($nivel_esc as $key=>$value) {
              if((int)$seleccion_fecha[$key] == 0){ //Si se elige periodo, se hace null la fecha
                $mes_anio_ = NULL;
                $inicio_p = (int)$inicio_periodo[$key];
                $fin_p = (int)$fin_periodo[$key];
              }
              else{ //En caso contrario, se hace null el periodo
                $mes_anio_ = date('Y-m-d', strtotime(str_replace('/', '-', $mes_anio[$key])));
                $inicio_p = NULL;
                $fin_p = NULL;
              }
              $sql3 = Esc_Proc::insertGetId(
                array('nombre_escproc' => $escuela_proc[$key],
                      'nivel' => $nivel_esc[$key],
                      'clave' => $cct[$key],
                      'seleccion_fecha' => (int)$seleccion_fecha[$key],
                      'mes_anio' => $mes_anio_,
                      'inicio_periodo' => $inicio_p,
                      'fin_periodo' => $fin_p,
                      'promedio' => (float)$promedio[$key],
                      'num_cta' => $num_cta,
                      'irre_cert' => $irregularidad_esc[$key],
                      'folio_cert' => (int)$folio_cert[$key],
                      'sistema_escuela' => 'SIAE',
                      'nombre_plan' => $info_sit[$key]->plan_nombre
              ));
            }

          }
          //En caso contrario, buscamos en DGIRE
          else{

            $ws_DGIRE = new WSController();
            $ws_DGIRE = $ws_DGIRE->ws_DGIRE($num_cta);

            $info = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno;

            //Obtenemos el nombre de la carrera
            $carrera = DB::connection('mysql2')->select('select car_car_siae from carreras WHERE car_cve_plt_car = '.$info->cveCarrera);
            $res = DB::connection('mysql2')->select('select carr_siae_nombre from carr_siae WHERE carr_siae_cve = '.$carrera[0]->car_car_siae);

            $sql = Alumno::insert(
              array('num_cta' => $num_cta,
                    'curp' => $curp,
                    'foto' => null,
                    'nombre_alumno' => $info->nombre,
                    'primer_apellido' => $info->apellidoPaterno,
                    'segundo_apellido' => $info->apellidoMaterno,
                    'sexo' => $sexo,
                    'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $fecha_nac))),
                    'id_nacionalidad' => (int)$nacionalidad,
                    'pais_cve' => (int)$lugar_nac,
                    'sistema_personal' => 'DGIRE',
                    'irre_doc' => (int)$irregularidad_doc,
                    'folio_doc' => (int)$folio_doc
            ));

            $sql1 = Trayectoria::insertGetId(
              array('generacion' => NULL,
                    'num_planestudios' => (int)$info->clavePlanLicenciatura,
                    'nombre_planestudios' => $info->nombrePlanLicenciatura, //¿Son lo mismo?
                    'num_cta'=> $num_cta,
                    'avance_creditos' => NULL,
                    'cumple_requisitos' => 1, //Para este punto ya debe cumplirlo
                    'id_nivel' => "L", //También debe cumplirlo 
                    'nombre_carrera' => $res[0]->carr_siae_nombre
            ));

            /*$sql2 = Registro_RE::insertGetId(
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
            ));*/

            $nivel_esc = array("B", "L");

            foreach($nivel_esc as $key=>$value) {
              if((int)$seleccion_fecha[$key] == 0){ //Si se elige periodo, se hace null la fecha
                $mes_anio_ = NULL;
                $inicio_p = (int)$inicio_periodo[$key];
                $fin_p = (int)$fin_periodo[$key];
              }
              else{ //En caso contrario, se hace null el periodo
                $mes_anio_ = date('Y-m-d', strtotime(str_replace('/', '-', $mes_anio[$key])));
                $inicio_p = NULL;
                $fin_p = NULL;
              }
              if($nivel_esc[$key] == "L"){
                $plan = $info->nombrePlanLicenciatura;
              }else{
                $plan = NULL;
              }
              $sql3 = Esc_Proc::insertGetId(
                array('nombre_escproc' => $escuela_proc[$key],
                      'nivel' => $nivel_esc[$key],
                      'clave' => $cct[$key],
                      'seleccion_fecha' => (int)$seleccion_fecha[$key],
                      'mes_anio' => $mes_anio_,
                      'inicio_periodo' => $inicio_p,
                      'fin_periodo' => $fin_p,
                      'promedio' => (float)$promedio[$key],
                      'num_cta' => $num_cta,
                      'irre_cert' => $irregularidad_esc[$key],
                      'folio_cert' => (int)$folio_cert[$key],
                      'sistema_escuela' => 'DGIRE',
                      'nombre_plan' => $plan
              ));
            }

          }
        }

        //Firmas
        $hoy = new DateTime();
        $firmas = DB::connection('mysql2')->select('select actualizacion_nombre from registro__r_es WHERE num_cta = '.$num_cta);
        if($firmas[0]->actualizacion_nombre == NULL){
          $sql2 = Registro_RE::insertGetId(
                  array('actualizacion_nombre' => Auth::user()->name,
                        'actualizacion_fecha' => $hoy->format("Y-m-d"),
                        'num_cta' => $num_cta
          ));
        }else{
          DB::connection('mysql2')->table('registro__r_es')->where('num_cta', $num_cta)->update(['actualizacion_nombre' => Auth::user()->name,
                        'actualizacion_fecha' => $hoy->format("Y-m-d")]);
        }

        if($jsec_firma != NULL){
          $pass = Hash::check($jsec_firma, Auth::user()->password); //Suponemos firma = contraseña por ahora
          if($pass){
            DB::connection('mysql2')->table('registro__r_es')->where('num_cta', $num_cta)->update(['jsec_nombre' => Auth::user()->name,
                          'jsec_fecha' => $hoy->format("Y-m-d")]);
          }else{
            dd("Código incorrecto");
          }
        }
        if($jarea_firma != NULL){
          $pass = Hash::check($jarea_firma, Auth::user()->password); //Suponemos firma = contraseña por ahora
          if($pass){
            DB::connection('mysql2')->table('registro__r_es')->where('num_cta', $num_cta)->update(['jarea_nombre' => Auth::user()->name,
                          'jarea_fecha' => $hoy->format("Y-m-d")]);
          }else{
            dd("Código incorrecto");
          }
        }
        if($jdepre_firma != NULL){
          $pass = Hash::check($jdepre_firma, Auth::user()->password); //Suponemos firma = contraseña por ahora
          if($pass){
            DB::connection('mysql2')->table('registro__r_es')->where('num_cta', $num_cta)->update(['jdepre_nombre' => Auth::user()->name,
                          'jdepre_fecha' => $hoy->format("Y-m-d")]);
          }else{
            dd("Código incorrecto");
          }
        }
        if($jdeptit_firma != NULL){
          $pass = Hash::check($jdeptit_firma, Auth::user()->password); //Suponemos firma = contraseña por ahora
          if($pass){
            DB::connection('mysql2')->table('registro__r_es')->where('num_cta', $num_cta)->update(['jdeptit_nombre' => Auth::user()->name,
                          'jdeptit_fecha' => $hoy->format("Y-m-d")]);
          }else{
            dd("Código incorrecto");
          }
        }
        if($direccion_firma != NULL){
          $pass = Hash::check($direccion_firma, Auth::user()->password); //Suponemos firma = contraseña por ahora
          if($pass){
            DB::connection('mysql2')->table('registro__r_es')->where('num_cta', $num_cta)->update(['direccion_nombre' => Auth::user()->name,
                            'direccion_fecha' => $hoy->format("Y-m-d")]);
          }else{
            dd("Código incorrecto");
          }
        }


      DB::disconnect('mysql2');
      return redirect()->route('home');
    }

    public function showSolicitudAut(){
      $title = "Autorización Revisión de Estudios";

      return view('/menus/autorizacion_re', ['title' => $title]);
    }

    public function postSolicitudAut(Request $request){
      $request->validate([
          'num_cta' => 'required|numeric|digits:9'
          ],[
           'num_cta.required' => 'El campo es obligatorio',
           'num_cta.numeric' => 'El campo debe contener solo números',
           'num_cta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);

      $title = "Autorización Revisión de Estudios";
      $num_cta = $request->num_cta;

      $sql = DB::connection('mysql2')->select('select jdepre_fecha from registro__r_es WHERE num_cta = '.$num_cta);

      //Si la Revisión de Estudios no está finalizada, mostramos el error
      if($sql == null || $sql[0]->jdepre_fecha == null){
        return view('/errors/error_info', ['descripcion' => "La Revisión de Estudios del alumno no está finalizada"]);
      }
      else{
        return redirect()->route('imprimePDF_RE', compact('num_cta'));
      }

    }

    public function PdfRevEstudios(){

      $num_cta = $_GET['num_cta'];

      $alumno = DB::connection('mysql2')->select('select * from alumnos WHERE num_cta = '.$num_cta);
      $nacionalidad = DB::connection('mysql2')->select('select nacionalidad from nacionalidades WHERE id_nacionalidad = '.$alumno[0]->id_nacionalidad);
      $carrera = DB::connection('mysql2')->select('select nombre_carrera from trayectorias WHERE num_cta = '.$num_cta);
      $f = DB::connection('mysql2')->select('select jdepre_fecha from registro__r_es WHERE num_cta = '.$num_cta);
      setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish'); //Para mostrar en español
      $fecha = strftime("%d de %B de %Y", strtotime($f[0]->jdepre_fecha));
      $facultad = DB::connection('mysql2')->select('select clave from esc__procs WHERE num_cta = '.$num_cta.' AND nivel = "L"');
      $num_ctag = substr($alumno[0]->num_cta, 0, -8)."-".substr($alumno[0]->num_cta, 1, -1)."-".substr($alumno[0]->num_cta, -1);
      //Adaptamos el formato de la clave para poder hacer la consulta
      if(strlen($facultad[0]->clave) == 1){
        $plan_est = "00".(string)$facultad[0]->clave;
      }
      else if(strlen($facultad[0]->clave) == 2){
        $plan_est = "0".(string)$facultad[0]->clave;
      }
      else{
        $plan_est = (string)$facultad[0]->clave;
      }
      $encargado_info = DB::connection('mysql2')->select('select plan_nombre, plan_encargado, plan_cargo from planteles WHERE plan_cve = '.$plan_est);
      $alumno_info = array('nombre_completo' => $alumno[0]->primer_apellido." * ".$alumno[0]->segundo_apellido." * ".$alumno[0]->nombre_alumno,
                           'num_cta' => $num_ctag, 
                           'nacionalidad' => $nacionalidad[0]->nacionalidad,
                           'carrera_nombre' => $carrera[0]->nombre_carrera);
      $jefe_oficina_re = DB::connection('mysql2')->select('select firm_nombre,firm_cargo,firm_firma from firmas WHERE firm_cargo = "Jefe de la Oficina de Revisiones" and firm_ofic is not null');
      $jefe_depto_re = DB::connection('mysql2')->select('select firm_nombre,firm_cargo,firm_firma from firmas WHERE firm_cargo = "Jefa del Departamento de Revisión" and firm_ofic is not null');

      //Creamos el contenido del documento
      $vista = $this->finalizacionRE($encargado_info,$alumno_info,$fecha,$jefe_oficina_re,$jefe_depto_re);
      $view = \View::make('consultas.autorizacionRE_PDF', compact('vista'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      return $pdf->stream('RE_'.$alumno_info['num_cta'].'.pdf');

    }

    public function finalizacionRE($encargado_info, $alumno_info, $fecha, $jefe_oficina_re, $jefe_depto_re){

      $composite = "";
      $composite .= "<div class='container documento_are'>";
      $composite .= "<div class='row'>";
      $composite .= "<div class='col-xs-12'>";
      $composite .= "<div class='doc'>";
      $composite .= "<div id='top'>";
      $composite .= "<table>";
      $composite .= "<tr>";
      $composite .= "<td><img src='images/escudo_unam_solowblack.svg' height='150' width='115'></td>";
      $composite .= "<td class='tit_pdf'>";
      $composite .= "<p>";
      $composite .= "<div>SECRETARÍA GENERAL</div>";
      $composite .= "<div>DIRECCIÓN GENERAL DE ADMON. ESCOLAR</div>";
      $composite .= "<div>DIRECCIÓN DE CERTIFICACIÓN Y CONTROL DOCUMENTAL</div>";
      $composite .= "</p>";
      $composite .= "<p>";
      $composite .= "<div>DEPARTAMENTO DE REVISIÓN DE ESTUDIOS</div>";
      $composite .= "<div>OFICINA DE REVISIÓN DE ESTUDIOS</div>";
      $composite .= "<div>PROFESIONALES Y DE POSGRADO</div>";
      $composite .= "</p>";
      $composite .= "</td>";
      $composite .= "</tr>";
      $composite .= "</table>";
      $composite .= "</div>";
      $composite .= "<div id='cuerpo'>";
      $composite .= "<div class='test'>Impresión de prueba</div>";
      $composite .= "<p>";
      $composite .= "<div>".$encargado_info[0]->plan_nombre."</div>";
      $composite .= "<div>".$encargado_info[0]->plan_encargado."</div>";
      $composite .= "<div>".$encargado_info[0]->plan_cargo."</div>";
      $composite .= "<div>P r e s e n t e.</div>";
      $composite .= "</p>";
      $composite .= "<p>";
      $composite .= "Hago de su conocimiento que con fecha ".$fecha." se realizó la revisión documental del expediente escolar del alumno
                    que se menciona a continuación, por lo cual ruego a usted programe el examen profesional, o elabore la documentación
                    correspondiente según la opción de titulación, una vez cubiertos la totalidad de los requisitos académicos:";
      $composite .= "</p>";
      $composite .= "<p>";
      $composite .= "<table>";
      $composite .= "<colgroup>";
      $composite .= "<col span='2' id='cons'>";
      $composite .= "</colgroup>";
      $composite .= "<tr>";
      $composite .= "<td>Alumno: </td>";
      $composite .= "<td><b>".$alumno_info['nombre_completo']."</b></td>";
      $composite .= "</tr>";
      $composite .= "<tr>";
      $composite .= "<td>Número de cuenta: </td>";
      $composite .= "<td><b>".$alumno_info['num_cta']."</b></td>";
      $composite .= "</tr>";
      $composite .= "<tr>";
      $composite .= "<td>Nacionalidad: </td>";
      $composite .= "<td><b>".$alumno_info['nacionalidad']."</b></td>";
      $composite .= "</tr>";
      $composite .= "<tr>";
      $composite .= "<td>Carrera: </td>";
      $composite .= "<td><b>".$alumno_info['carrera_nombre']."</b></td>";
      $composite .= "</tr>";
      $composite .= "</table>";
      $composite .= "</p>";
      $composite .= "<p>";
      $composite .= "Sin otro particular, aprovecho la ocasión para enviarle un coordial saludo.";
      $composite .= "</p>";
      $composite .= "<div id='atte'>";
      $composite .= "<p>";
      $composite .= "<div>A t e n t a m e n t e</div>";
      $composite .= "<div>''POR MI RAZA HABLARÁ EL ESPÍRITU''</div>";
      $composite .= "</p>";
      $composite .= "</div>";
      $composite .= "</div>";
      $composite .= "<div>";
      $composite .= "<p>";
      $composite .= "<table style='width: 100%;'>";
      $composite .= "<tr class='t_dos'>";
      $composite .= "<td><img src='data:image/png;base64,".base64_encode( $jefe_oficina_re[0]->firm_firma )."' height='120' width='120'/></td>";
      $composite .= "<td><img src='data:image/png;base64,".base64_encode( $jefe_depto_re[0]->firm_firma )."' height='120' width='230'/></td>";
      $composite .= "</tr>";
      $composite .= "<tr class='t_dos'>";
      $composite .= "<td>".$jefe_oficina_re[0]->firm_nombre."</td>";
      $composite .= "<td>".$jefe_depto_re[0]->firm_nombre."</td>";
      $composite .= "</tr>";
      $composite .= "<tr class='t_dos'>";
      $composite .= "<td>".$jefe_oficina_re[0]->firm_cargo."</td>";
      $composite .= "<td>".$jefe_depto_re[0]->firm_cargo."</td>";
      $composite .= "</tr>";
      $composite .= "</table>";
      $composite .= "</p>";
      $composite .= "</div>";
      $composite .= "</div>";
      $composite .= "</div>";
      $composite .= "</div>";
      $composite .= "</div>";

      return $composite;
    }

    public function showAgregarEsc($num_cta)
    {

      $title = "Agregar escuela de procedencia";

      $datos = [
        'title' => $title,
        'num_cta' => $num_cta,
        'nombres_nivel' => NULL,
        'escuelas' => NULL
      ];

      $ws_SIAE = Web_Service::find(2);
      $identidad = new WSController();
      $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

      //Verificamos si la información proviene del SIAE
      if(isset($identidad) && (isset($identidad->mensaje) && $identidad->mensaje == "El Alumno existe")){

        $ws_SIAE = Web_Service::find(1);
        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
        
        //Niveles de interés dado el número de cuenta
        $niveles = array();

        //Información de escuelas de interés (Finalizadas)
        $escuelas = array();

        foreach ($trayectoria->situaciones as $situacion) {
          if($situacion->causa_fin == '14' || $situacion->causa_fin == '34' || $situacion->causa_fin == '35' || $situacion->causa_fin == '11'
            || ($situacion->causa_fin == null and $situacion->porcentaje_totales >= 70.00)){          
            $existe = DB::connection('mysql2')->select("select * from esc__procs WHERE num_cta = ".$num_cta." and nivel = '".$situacion->nivel."' and nombre_escproc = '".$situacion->plantel_nombre."'");
            if($existe == NULL){
              array_push($escuelas, $situacion);
              if(!in_array($situacion, $niveles)){ //No duplicamos niveles
                $value = $situacion->nivel;
                array_push($niveles, $value);
              }
            }
          }
        }

        //Nombres completos de cada nivel
        $nombres_nivel = array();
        foreach($niveles as $nvl){
          $value = DB::connection('mysql2')->select('select id_nivel, nombre_nivel from niveles WHERE id_nivel = "'.$nvl.'"');
          array_push($nombres_nivel, $value[0]);
        }
        if($escuelas == NULL){
          $vista = '/errors/error_info';
          $datos = ['descripcion' => "No hay escuelas para agregar."];
        }else{
          $siae = [
            'title' => $title,
            'num_cta' => $num_cta,
            'nombres_nivel' => $nombres_nivel,
            'escuelas' => $escuelas
          ];
          DB::disconnect('mysql2');
          $vista = '/menus/agregar_esc';
          $datos = $siae;
        }
      
      }else{ //Si no se encontró en SIAE, se obtiene de DGIRE

        $ws_DGIRE = new WSController();
        $ws_DGIRE = $ws_DGIRE->ws_DGIRE($num_cta);
        $info = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno;

        $niveles = [(object)['id_nivel' => "B", 'nombre_nivel' => "BACHILLERATO"], 
                    (object)['id_nivel' => "L", 'nombre_nivel' => "LICENCIATURA"]];

        $escuelas = array();
        $nombres_nivel = array();
        foreach($niveles as $nvl){
          $existe = DB::connection('mysql2')->select("select * from esc__procs WHERE num_cta = ".$num_cta." and nivel = '".$nvl->id_nivel."'");
          if($existe == NULL){
            if($nvl->id_nivel == "L"){
              array_push($escuelas, (object)['nivel' => $nvl, 'plantel_nombre' => $info->nombreEscuelaBachillerato, 'plan_nombre' => $info->nombrePlanLicenciatura]);
            }
            else{
              array_push($escuelas, (object)['nivel' => $nvl, 'plantel_nombre' => $info->nombreEscuelaLicenciatura]);
            }
            if(!in_array($nvl, $nombres_nivel)){ //No duplicamos niveles
              array_push($nombres_nivel, $nvl);
            } 
          }
        }

        if($escuelas == NULL){
          $vista = '/errors/error_info';
          $datos = ['descripcion' => "No hay escuelas para agregar."];
        }else{
          $dgire = [
            'title' => $title,
            'num_cta' => $num_cta,
            'nombres_nivel' => $nombres_nivel,
            'escuelas' => $escuelas
          ];
          DB::disconnect('mysql2');
          $vista = '/menus/agregar_esc';
          $datos = $dgire;
        }

      }

      return view($vista, $datos);
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

      $num_cta = $request->input('num_cta');
      $nivel_escuela = $request->input('nivel_escuela');
      $nombre_escuela = $request->input('nombre_escuela');
      $plan_estudios = $request->input('plan');

      $ws_SIAE = Web_Service::find(2);
      $identidad = new WSController();
      $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

      //Verificamos si la información proviene del SIAE
      if(isset($identidad) && (isset($identidad->mensaje) && $identidad->mensaje == "El Alumno existe")){

        $ws_SIAE = Web_Service::find(1);
        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

        foreach ($trayectoria->situaciones as $situacion){
          //En caso de que el alumno curse más de una licenciatura, se consideran todas
          if(($situacion->nivel == "L" && $nivel_escuela == "L") && $situacion->plan_nombre == $plan_estudios){
            $sql = Esc_Proc::insertGetId(
              array('nombre_escproc' => $situacion->plantel_nombre,
                    'nivel' => $nivel_escuela,
                    'clave' => $situacion->plantel_clave,
                    'seleccion_fecha' => NULL,
                    'mes_anio' => NULL,
                    'inicio_periodo' => NULL,
                    'fin_periodo' => NULL,
                    'promedio' => NULL,
                    'num_cta' => $num_cta,  
                    'irre_cert' => NULL, 
                    'folio_cert' => NULL,
                    'sistema_escuela' => 'SIAE',
                    'nombre_plan' => $situacion->plan_nombre
            ));
          }else if($situacion->nivel == $nivel_escuela && $situacion->plantel_nombre == $nombre_escuela){
            $sql = Esc_Proc::insertGetId(
              array('nombre_escproc' => $situacion->plantel_nombre,
                    'nivel' => $nivel_escuela,
                    'clave' => $situacion->plantel_clave,
                    'seleccion_fecha' => NULL,
                    'mes_anio' => NULL,
                    'inicio_periodo' => NULL,
                    'fin_periodo' => NULL,
                    'promedio' => NULL,
                    'num_cta' => $num_cta,  
                    'irre_cert' => NULL, 
                    'folio_cert' => NULL,
                    'sistema_escuela' => 'SIAE',
                    'nombre_plan' => $situacion->plan_nombre
            ));
          } 
        }

      }else{
        $sql = Esc_Proc::insertGetId(
          array('num_cta' => $num_cta, 'nivel' => $nivel_escuela, 'nombre_escproc' => $nombre_escuela, 'nombre_plan' => $plan_estudios)
        );
      }

      return redirect()->route('rev_est', ['num_cta' => $request->num_cta]);
    }

    public function showQuitarEsc($num_cta){

      $title = "Quitar escuela de procedencia";
      $vista = '/menus/quitar_esc';
      $datos = [
        'title' => $title,
        'num_cta' => $num_cta
      ];

      $niveles_bd = DB::connection('mysql2')->select('select nivel from esc__procs WHERE num_cta = '.$num_cta);
      $niveles = array();
      $escuelas_temp = array();
      $escuelas = array();
      foreach ($niveles_bd as $nvl) {
        //Niveles en la base de datos
        $value = DB::connection('mysql2')->select('select * from niveles WHERE id_nivel = "'.$nvl->nivel.'"');
        array_push($niveles, $value[0]);
        //Información de cada nivel
        $value2 = DB::connection('mysql2')->select('select nombre_escproc, nombre_plan, nivel from esc__procs WHERE num_cta = '.$num_cta.' and nivel = "'.$nvl->nivel.'"');
        array_push($escuelas_temp, $value2[0]);
      }

      foreach ($escuelas_temp as $esc) {
        $val = array('plantel_nombre' => $esc->nombre_escproc, 'plan_nombre' => $esc->nombre_plan, 'nivel' => $esc->nivel);
        array_push($escuelas, $val);
      }

      $datos['nombres_nivel'] = $niveles;
      $datos['escuelas'] = $escuelas;

      return view($vista, $datos);
      
    }

    public function validarQuitarInformacion(Request $request)
    {

      $request->validate([
          'num_cta' => 'required|numeric|digits:9'
          ],[
           'num_cta.required' => 'El campo es obligatorio',
           'num_cta.numeric' => 'El campo debe contener solo números',
           'num_cta.digits'  => 'El campo debe ser de 9 dígitos',
      ]);

      $num_cta = $request->input('num_cta');
      $nivel_escuela = $request->input('nivel_escuela');
      $nombre_escuela = $request->input('nombre_escuela');
      $plan_estudios = $request->input('plan');

      if($nivel_escuela == "L"){
        $sql = DB::connection('mysql2')->delete("delete from esc__procs WHERE num_cta = ".$num_cta." and nivel ='".$nivel_escuela."' and nombre_plan = '".$plan_estudios."'");
      }else{
        $sql = DB::connection('mysql2')->delete("delete from esc__procs WHERE num_cta = ".$num_cta." and nivel ='".$nivel_escuela."' and nombre_escproc = '".$nombre_escuela."'");
      }

      return redirect()->route('rev_est', ['num_cta' => $request->num_cta]);
    }

    public function prueba($num_cta){

      $ws_SIAE = Web_Service::find(2);
      $identidad = new WSController();
      $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

      $ws_SIAE = Web_Service::find(1);
      $trayectoria = new WSController();
      $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);

      $ws_DGIRE = new WSController();
      $ws_DGIRE = $ws_DGIRE->ws_DGIRE($num_cta);

      dd($ws_DGIRE);
    }

}
