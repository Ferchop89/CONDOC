<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\{User, Role, Procedencia, Web_Service, Menu, Solicitud};
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\WSController;
use NuSoap;
use Session;

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
        return $datos;
    }
    public function saveRecepcion(){
        // $solicitud=Solicitud::where('cuenta', request()->input('num_cta'))
        //     ->first();
        if($this->solicitudExistente(request()->input('num_cta')))
        {
            $solicitudes = $this->citatoriosSolicitud(request()->input('num_cta'));
        }
        else
        {
            // code...
        }

        $solicitudes = $this->citatoriosSolicitud(request()->input('num_cta'));
        dd($solicitudes);

        /*Citatorios*/
        if($solicitud == null)
        {
            $msj = "En los registros, no existe Solicitud de Revisión de Estudios relacionada al Número de Cuenta ".request()->input('num_cta');
            Session::flash('error', $msj);
            return redirect()->route('recepcion', ['num_cta' => request()->input('num_cta')]);
        }
        elseif ($solicitud->pasoACorte == 1) {
            $msj = "La solictud se encuentra en proceso de Revisión de Estudio";
            Session::flash('info', $msj);
            return redirect()->route('recepcion', ['num_cta' => request()->input('num_cta')]);
        }
        elseif ($solicitud->cancelada_id != null) {
            $msj = "La solictud fue cancelada con el identificador ".$solicitud->cancelada_id;
            Session::flash('info', $msj);
            return redirect()->route('recepcion', ['num_cta' => request()->input('num_cta')]);
        }
        elseif ($solicitud->citatorio == 1 && $solicitud->pasoACorte == 0)
        {
            $solicitud->pasoACorte = 1;
            $solicitud->update();
            $msj = "Se registro recepción de expediente por parte del alumno: ".request()->input('nombreC')." con Número de Cuenta: ".request()->input('num_cta');
            Session::flash('success', $msj);
            return redirect()->route('recepcion', ['num_cta' => request()->input('num_cta')]);
        }
        elseif ($solicitud->NoAgunam->isNotEmpty()) {
            dd($solicitud->NoAgunam);
        }
        // dd("fin");
    }
    public function solicitudExistente($num_cta){
        $solicitud = Solicitud::where('cuenta', $num_cta)
            ->get();
        return $solicitud->isEmpty();
    }
    public function citatoriosSolicitud($num_cta){
        $citatorios=Solicitud::where('cuenta', $num_cta)
            ->where('citatorio', 1)
            ->where('pasoAcorte', 0)
            ->get();
        $citatorios = $citatorios->toArray();
        return $citatorios;
    }

}
