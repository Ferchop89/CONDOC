<?php
namespace App\Http\Controllers;

use DB;
use Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\WSController;


use App\Models\{Solicitud, Web_Service, IrregularidadesRE, Baches, Paises,
                Niveles, User, Trayectoria, Nacionalidades,
                Registro_RE, Alumno, Esc_Proc};

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
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
        $title = "Solicitud de Revisión de Estudios";
        $solicitudPrevia = DB::table('solicitudes')
                         ->select('id', 'cuenta', 'plantel_id', 'carrera_id', 'plan_id', 'citatorio', 'pasoACorte', 'cancelada')
                         ->where('cuenta',$num_cta)
                         ->GET()->toArray();

        $ws_SIAE = Web_Service::find(1);
        $trayectoria = new WSController();
        $trayectoria = $trayectoria->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
        $trayectorias_75 = array();
        $generacion=substr($num_cta, 1, -6);
        $msj="";
        // dd($trayectoria);

        if($trayectoria != "El alumno no tiene trayectoria")
        {
            $ws_SIAE = Web_Service::find(2);
            $identidad = new WSController();
            $identidad = $identidad->ws_SIAE($ws_SIAE->nombre, $num_cta, $ws_SIAE->key);
            // dd($identidad);
            //If plantel->trayectia == user->plantel
            foreach ($trayectoria->situaciones as $value) {
                if ($value->porcentaje_totales >= 75.00) {
                    if($value->nivel == 'L')
                    {
                        if($value->causa_fin == '11' || $value->causa_fin == null || $value->causa_fin == '14')
                        {
                            array_push($trayectorias_75, $value);
                            if(Auth::user()->procedencia_id != $value->plantel_clave){
                                    $msj = "El alumno con número de cuenta ".$num_cta." no cuenta con carreras dentro del plantel";
                                    Session::flash('error', $msj);
                            }
                        }
                    }
                }
                else {
                    $msj = "El alumno con número de cuenta ".$num_cta." no cumple con los requisitos necesarios";
                    Session::flash('error', $msj);
                }
            }
            if($generacion == '06' || $generacion == '07' || $generacion == '08' || $generacion == '09' || $generacion == '10' || $generacion == '11')
            {
                // dd($trayectorias_75);
                $tipo = 0;
                $msj = "El alumno con número de cuenta ".$num_cta." no cuenta con documentación.";
                return view('/menus/solicitud_RE_info', ['title' =>$title, 'identidad' => $identidad, 'trayectoria' => $trayectorias_75, 'solicitudes' => $solicitudPrevia, 'msj' => $msj, 'tipo' => $tipo]);
            }
            else {
                $tipo=1;
                return view('/menus/solicitud_RE_info', ['title' =>$title, 'identidad' => $identidad, 'trayectoria' => $trayectorias_75, 'solicitudes' => $solicitudPrevia, 'msj' => $msj, 'tipo' => $tipo]);
            }
        }
        else {
            $msj = "El número de cuenta es incorrecto.";
            Session::flash('error', $msj);
            return redirect()->route('captura.num_cta')->withInput();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSolicitud(Request $request)
    {
        // $datos = $request->all();
        $solicitud = new Solicitud();
        $solicitud->nombre = $request->input("nombre");
        $solicitud->cuenta = $request->input("num_cta");
        $solicitud->avance = $request->input("avance");
        $solicitud->plantel_id = $request->input("plantel_id");
        $solicitud->carrera_id = $request->input("carrera_id");
        $solicitud->plan_id = $request->input("plan_id");
        $solicitud->tipo = 1;
        $solicitud->citatorio = 0;
        $solicitud->pasoACorte = 0;
        $solicitud->cancelada = 0;
        $solicitud->user_id = Auth::User()->id;
        $solicitud->save();
        $msj = "La solicitud ha sido creada exitosamente";
        Session::flash('info', $msj);
        return redirect()->route('solicitud_RE', $request->input("num_cta"))->withInput();
        // Si no existe, creamos el usuario con el plantel como procedencia.

        // dd($datos, Auth::User()->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitud $solicitud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function cancelSolicitud(Solicitud $solicitud)
    {
        dd("Cancelación");
    }
}
