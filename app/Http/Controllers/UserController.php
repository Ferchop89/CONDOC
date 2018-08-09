<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\{User, Role, Procedencia, Web_Service, Menu};
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\WSController;
use NuSoap;

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
        $title = "Recepción de Expedientes";
        // var_dump(isset($_GET['num_cta']));
        if (isset($_GET['num_cta'])) {
            $respuesta = $this->datosExpedientes($_GET['num_cta']);
            return view('menus/recepcion_expedientes', ['title' => $title, 'datos' => $respuesta]);
        }
        else {
            return view('menus/recepcion_expedientes', ['title' => $title]);
        }
    }

    public function datosExpedientes($num_cta){

        $ws_SIAE = Web_Service::find(2);
        $identidad = new WSController();
        $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
        // dd($identidad);
        $datos = array(
            "sistema" => NULL,
            "num_cta" => $num_cta,
            "app" => NULL,
            "apm" => NULL,
            "nombres" => NULL,
            "fecha_nac" => NULL,
            "genero" => NULL,
            "nivel_SIAE" => NULL,
            "plantel_clave_SIAE" => NULL,
            "carrera_clave_SIAE" => NULL,
            "plan_clave_SIAE" => NULL,
            "carr_clv_plt_carr" => NULL,
            "carr_nombre_plan" => NULL,
            "titulo" => NULL
        );
        $msj = "";
        if(isset($identidad->mensaje) && $identidad->mensaje == "El Alumno existe")
        {
            $id = array('sistema' => 'SIAE','num_cta' => $identidad->cuenta, 'app' => $identidad->apellido1, 'apm' => $identidad->apellido2, 'nombres' => $identidad->nombres, 'fecha_nac' => $identidad->nacimiento, 'genero' => $identidad->sexo);
            $ws_SIAE = Web_Service::find(1);
            $trayectoria = new WSController();
            $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
            // dd($trayectoria);
            foreach ($trayectoria->situaciones as $value) {
                if($value->nivel == 'L')
                {
                    $id['nivel_SIAE'] = $value->nivel;
                    $id['plantel_clave_SIAE'] = $value->plantel_clave;
                    $id['carrera_clave_SIAE'] = $value->carrera_clave;
                    $plan_clave = $value->plan_clave;
                    $value->plan_clave = str_pad($plan_clave, 4, "0", STR_PAD_LEFT);
                    $id['plan_clave_SIAE'] = $value->plan_clave;
                }
            }
            // dd(DB::connection('condoc_old')->enableQueryLog());
            $plantel = DB::connection('condoc_old')->select('select car_cve_plt_car, car_nom_plan from carreras WHERE car_car_siae = '.$id['carrera_clave_SIAE'].' AND car_plan_siae = '.$id['plan_clave_SIAE']);
            if($plantel == NULL)
            {
                // $plantel = DB::connection('condoc_old')->select('select * WHERE mapeocarreracincotres = '.$id['carrera_clave_SIAE']);
                $id['carr_siae_nombre'] = '00000';
                $id['carr_clv_plt_carr'] = '000';
                $id['carr_nombre_plan'] = '000';

            }
             else {
                $id['carr_clv_plt_carr'] = $plantel[0]->car_cve_plt_car;
                $id['carr_nombre_plan'] = $plantel[0]->car_nom_plan;
             }
             if($id['genero'] == 'FEMENINO')
             {
                 $titulo = DB::connection('condoc_old')->select('select ori_grado_titulo_fem from orientaciones WHERE ori_plan = '.$id['plantel_clave_SIAE'].' AND ori_carr = '.$id['carr_clv_plt_carr']);
                 $id['titulo'] = $titulo[0]->ori_grado_titulo_fem;
             }
             else {
                 $titulo = DB::connection('condoc_old')->select('select ori_grado_titulo_masc from orientaciones WHERE ori_plan = '.$id['plantel_clave_SIAE']);
                 $id['titulo'] = $titulo[0]->ori_grado_titulo_masc;
             }
             // dd($titulo, $id);
            DB::disconnect('condoc_old');
            $datos = $id;
            // dd($trayectoria, $identidad, $datos);
        }
        else {
            // dd("DGIRE");
            $ws_DGIRE = new WSController();
            $ws_DGIRE = $ws_DGIRE->ws_DGIRE($num_cta);
            // dd($ws_DGIRE->respuesta->datosAlumnos->datosAlumno->apellidoPaterno);
            $datos["sistema"] = "DGIRE";
            $datos["num_cta"] = $num_cta;
            $datos["app"] = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno->apellidoPaterno;
            $datos["apm"] = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno->apellidoMaterno;
            $datos["nombres"] = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno->nombre;
            $datos["fecha_nac"] = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno->fechaNacimiento;
            if($ws_DGIRE->respuesta->datosAlumnos->datosAlumno->sexo == 1)
            {
                $datos["genero"] = "MASCULINO";
            }
            else {
                $datos["genero"] = "FEMENINO";
            }
            $datos["carr_clv_plt_carr"] = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno->cvePlantel;
            $datos["carr_nombre_plan"] = $ws_DGIRE->respuesta->datosAlumnos->datosAlumno->nombrePlan;
            // $datos["titulo"] => $ws_DGIRE->respuesta->datosAlumnos->
            // dd($ws_DGIRE->respuesta->datosAlumnos);
        }
        return $datos;
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
        $num_cta=request()->input('num_cta');

        // dd($respuesta);
        // return redirect()->route('recepcion', ['datos' => $datos]);
        // return redirect()->route('recepcion')->with('datos', $datos);
        // return redirect()->route('profile', ['id' => 1]);
        // return redirect()->route('route.name', [$param]);
        return redirect()->route('recepcion', ['num_cta' => $num_cta]);
    }

}
