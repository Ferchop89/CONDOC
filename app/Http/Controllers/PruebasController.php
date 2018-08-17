<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\WSController;
use App\Models\{User, Role, Procedencia, Web_Service, Menu, Solicitud};

class PruebasController extends Controller
{
    public function prueba(){
        return view('/pruebas/menu_prueba');
    }
    public function seederCtas(){
        $ctas = array(
            '305016614',
        );
        foreach ($ctas as $cta) {
            $ws_SIAE = Web_Service::find(2);
            $identidad = new WSController();
            $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $cta, $ws_SIAE->key);
            // dd($identidad);
            $nombre = $identidad->apellido1."*".$identidad->apellido2."*".$identidad->nombres;
            $curp = $identidad->curp;
            $fechaNac = $identidad->nacimiento;
            $genero = $identidad->sexo;
            $ws_SIAE = Web_Service::find(1);
            $trayectoria = new WSController();
            $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $cta, $ws_SIAE->key);
            // dd($trayectoria);
            $file=fopen("matriculas.txt","a") or die("Problemas");
  //vamos añadiendo el contenido


            foreach ($trayectoria->situaciones as $key => $value)
            {
                if($value->nivel == 'L')
                {
                    $avance = $value->porcentaje_totales;
                    $nivel = $value->nivel;
                    $generacion = $value->generacion;
                    $plantelClv = $value->plantel_clave;
                    $nombrePlantel = $value->plantel_nombre;
                    $carreraClv = $value->carrera_clave;
                    $nombreCarrera = $value->carrera_nombre;
                    $planClv = $value->plan_clave;
                    $nombrePlan = $value->plan_nombre;
                    $sistema = "SIAE";
                    $datos = '$Acuentas['. ($key-1) .'] = '."[(string)'$cta','$nombre','$curp',$fechaNac,'$genero','$avance','$nivel','$generacion','$plantelClv','$nombrePlantel',$carreraClv,'$nombreCarrera','$planClv','$nombrePlan','$sistema'];";

                    fputs($file,$datos);
                    fputs($file,"\n");

                    var_dump("$datos");
                }
            }
            fclose($file);
            // $nivel =
        }
    }
}
