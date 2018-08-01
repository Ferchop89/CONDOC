<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Corte;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Procedencia;
use App\Models\Agunam;
use Illuminate\Support\Facades\Input;

class InformesController extends Controller
{
  public function cortes()
  {
    $title = "Bandeja de Solicitudes de Revisión de Estudios";
    // $this->liberaSolicitudes();
    // escuelas de las que provienen las solicitudes sin listado
    $escuelas = $this->escuelaDeProcedencia();
    // construccion del DropDown en HMTL con las escuelas de las que provienen las solicitudes sin liesc_Html
    $escuelasHtml = $this->escuelasDeProcedenciaHtml($escuelas,request('facesc'));
    // liberamos algunos registros para pruebas
    $solicitudesW = $this->solicitudesWeb(request('facesc')) ;
    // tabla HTML de cuentas pendientes de listado, separadas por dia
    $sol_Html = $this->solicitudesHtml($solicitudesW);

    return view('consultas.solicitud_rs',[
            'title' => $title,
            'solW_cta'=>count($solicitudesW),
            'sol_Html'=>$sol_Html,
            'esc_Html'=>$escuelasHtml
          ]);
  }
  public function cortesVista()
  {
    // Vista para la consulta de solicitudes y citatorios.

    // En su primera carga, toma varores de la base de datos, sino, selecciona y enviados por submit
    $a = $m = $o = array();

    // Ultima fecha que tiene información.
    $ultimaSol= Solicitud::latest()->first();

    $fecha = (request()->fecha_v==null)? $ultimaSol->created_at : Carbon::createFromFormat('Y-m-d',request()->fecha_v);
    $plantel  = (request()->plantel_id==null)? '' : request()->plantel_id;

    $fecha_1 = clone $fecha; $fecha_2 = clone $fecha;

    $title = "Consulta de Solicitudes de Revisión de Estudios";
    // $this->liberaSolicitudes();
    // escuelas de las que provienen las solicitudes
    $escuelas = $this->escuelaDeProcedencia_V($fecha_1);

    // Consultamos todas las solicitudes, incluye citatorios y excluye canceladas
    $solicitudesW = $this->solicitudesSyC_V($fecha_2,$plantel);

    // tabla HTML de cuentas pendientes de listado, separadas por dia
    $sol_Html = $this->solicitudesHtml($solicitudesW);

    return view('consultas.solicitud_vw',[
            'title' => $title,
            'solW_cta'=>count($solicitudesW),
            'sol_Html'=>$sol_Html,
            'plantel' =>$plantel,
            'escuelas'=>$escuelas,
            'fecha_Sel' => $fecha
          ]);
  }
  public function escuelaDeProcedencia_V($fecha)
  {
    // DropDown menu de procedencias para listados restringido a las solicitudes del mes de la fecha.

    // Generamos rango de fechas al $inicio y $final de mes.
    $inicio = clone $fecha->startOfMonth(); $final = clone $fecha->endOfMonth();

    // Seleccionamos todas las escuelas que reportaron del inicio al final del mes de la fecha seleccionada.
    $data = DB::table('solicitudes')
              ->whereBetween('solicitudes.created_at',[$inicio, $final])
              ->where('pasoACorte',false)
              ->where('cancelada',false)
              ->join('users','solicitudes.user_id','=','users.id')
              ->join('procedencias','users.procedencia_id','=','procedencias.id')
              ->select('procedencias.id',
                       'procedencias.procedencia')
              ->groupBy('procedencias.id','procedencias.procedencia')
              ->pluck('procedencias.procedencia','procedencias.id')->all();
    return $data;
  }
  public function escuelaDeProcedencia()
  {
    // DropDown menu de procedencias para listados.
    $pendiente = array();
    //
    $data = DB::table('solicitudes')
              ->select('user_id')
              ->where('pasoACorte',false)
              ->where('cancelada',false)
              ->groupBy('user_id')
              ->pluck('user_id')->all();

    foreach ($data as $value) {
      $procede_id = User::where('id',$value)->first()->procedencia_id;
      $procede    = Procedencia::where('id',$procede_id)->first()->procedencia;
      if (!in_array($procede, $pendiente)) { array_push ( $pendiente, $procede); }
    }
    sort($pendiente);
    return $pendiente;
  }
  public function escuelasDeProcedenciaHtml( $facesc, $seleccion)
  {
    // dd($facesc,$seleccion,$tipo);
      // Elabora el Form Select. sin selección si no se ha seleccionada ninguna escuela de procedencia.
      sort($facesc);array_unshift($facesc,'Selecciona una opción');
      $html = "<select  name='facultad' id='facultad' onchange='location = this.value;'>";

      foreach ($facesc as $value) {
        if ($value!='Selecciona una opción') {
          $valorSel = ($value==$seleccion) ? ' selected ' : ''; // Valor Seleccionado
          $html .= "<option value='/cortes?facesc=".$value."' ".$valorSel.">".$value."</option>";
        } else
        {
          $html .= "<option value='/cortes' selected >".$value."</option>";
        }
      }
      $html .= "</select>";
      return $html;
  }
  public function escuelasDeProcedenciaHtml_V( $facesc, $seleccion)
  {
    // dd($facesc,$seleccion,$tipo);
      // Elabora el Form Select. sin selección si no se ha seleccionada ninguna escuela de procedencia.
      sort($facesc);array_unshift($facesc,'Selecciona una opción');
      $html = "<select  name='facultad' id='facultad' onchange='location = this.value;'>";

      foreach ($facesc as $value) {
        if ($value!='Selecciona una opción') {
          $valorSel = ($value==$seleccion) ? ' selected ' : ''; // Valor Seleccionado
          $html .= "<option value='/cortesV?facesc=".$value."' ".$valorSel.">".$value."</option>";
        } else
        {
          $html .= "<option value='/cortesV' selected >".$value."</option>";
        }
      }
      $html .= "</select>";
      return $html;
  }
  public function solicitudesSyC($facesc)
  {
      // Solicitudes y citatorios para consulta.  Excluye canceladas.

      // Generación de solicitudes para organizar en listados de Solicitudes y Citatorios
      if ($facesc!=null) {
        // Recuperamos el/los usuarios que dieron de alta los registros
        $procede_id    = Procedencia::where('procedencia','=',$facesc)->pluck('id')->first();
        $procede_users = Procedencia::find($procede_id)->users->pluck('id')->toArray();

        $pendientes =     Solicitud::select('id','cuenta','tipo','created_at','user_id')
                          ->where('cancelada',false)
                          ->wherein('user_id',$procede_users)
                          ->orderBy('created_at','desc')
                          ->get()->toArray();
      } else {
        $pendientes =     Solicitud::select('id','cuenta','tipo','created_at','user_id')
                          ->where('cancelada', false)
                          ->orderBy('created_at','desc')
                          ->get()->toArray();
      }
      return $pendientes;
  }
  public function solicitudesSyC_V($fecha,$plantel)
  {
      // Solicitudes y citatorios para consulta.  Excluye canceladas.
      // Generamos rango de fechas al $inicio y $final de mes.
      $fecha1 = clone $fecha; $fecha2 = clone $fecha;
      $inicio = clone $fecha1->startOfMonth(); $final = clone $fecha2->endOfMonth();

      if ($plantel == '') {
          // no se espeficia un plantel, se elige solo las solicitudes de una fecha
          $data = Solicitud::select('id','cuenta','tipo','created_at','user_id')
                      ->where('cancelada',false)
                      ->whereDate('created_at', '=', $fecha->toDateString())
                      ->orderBy('created_at','desc')
                      ->get()->toArray();
      } else {
        // Usuarios que tienen las misma procedencia.
        $procede_users = Procedencia::find($plantel)->users->pluck('id')->toArray();

        // filtramos usuarios del plantel y  rango de fechas
        $data = Solicitud::select('id','cuenta','tipo','created_at','user_id')
                    ->whereBetween('solicitudes.created_at',[$inicio, $final])
                    ->wherein('user_id',$procede_users) // En caso de haber varios usuarios en una procencia
                    ->where('cancelada',false)
                    ->orderBy('created_at','desc')
                    ->get()->toArray();
      }
      return $data;
  }
  public function solicitudesWeb($facesc)
  {
      // Generación de solicitudes para organizar en listados de Solicitudes y Citatorios
      if ($facesc!=null) {
        // Recuperamos el/los usuarios que dieron de alta los registros
        $procede_id    = Procedencia::where('procedencia','=',$facesc)->pluck('id')->first();
        $procede_users = Procedencia::find($procede_id)->users->pluck('id')->toArray();

        $pendientes =     Solicitud::select('id','cuenta','tipo','created_at','user_id')
                          ->where('pasoACorte',false)
                          ->where('cancelada',false)
                          ->wherein('user_id',$procede_users)
                          ->orderBy('created_at','desc')
                          ->get()->toArray();
      } else {
        $pendientes =     Solicitud::select('id','cuenta','tipo','created_at','user_id')
                          ->where('pasoACorte',false)
                          ->where('cancelada', false)
                          ->orderBy('created_at','desc')
                          ->get()->toArray();
      }
      return $pendientes;
  }
  public function solicitudesWeb2($facesc)
  {
      // Generación de solicitudes para organizar en listados de Solicitudes y Citatorios
      if ($facesc!=null) {
        // Recuperamos el/los usuarios que dieron de alta los registros
        $procede_id    = Procedencia::where('procedencia','=',$facesc)->pluck('id')->first();
        $procede_users = Procedencia::find($procede_id)->users->pluck('id')->toArray();

        $pendientes =     Solicitud::select('id','cuenta','tipo','created_at','user_id')
                          ->where('pasoACorte',false)
                          ->where('cancelada',false)
                          ->where('tipo',1)
                          ->wherein('user_id',$procede_users)
                          ->orderBy('cuenta','desc')
                          ->get()->toArray();
      } else {
        $pendientes =     Solicitud::select('id','cuenta','tipo','created_at','user_id')
                          ->where('pasoACorte',false)
                          ->where('cancelada', false)
                          ->where('tipo',1)
                          ->orderBy('cuenta','desc')
                          ->get()->toArray();
      }
      return $pendientes;
  }
  public function solicitudesHtml($pendientes)
  {
      // Genera una tabla de solicitudes que no han pasado a revisión.
      $xfecha = ""; $i=0; $trs=""; $test = true;
      $revs = 0; $citas = 0; $facesc = array();

     while ($i<count($pendientes)) { // itera una vez por dia
       $xfecha = substr($pendientes[$i]['created_at'],0,10);
       $cuentas=""; $citatorios="";
       while ( ( $i<count($pendientes) ) && ($xfecha == substr($pendientes[$i]['created_at'],0,10) ) )
       { // itera todas las solicitudes
         // Recabamos las cuentas 1 Normales y 0 citatorios.
         if ($pendientes[$i]['tipo']==1) {
           $cuentas = $pendientes[$i]['cuenta'].' '.$cuentas; $revs++; }
         if ($pendientes[$i]['tipo']==0) {
           $citatorios = $pendientes[$i]['cuenta'].' '.$citatorios; $citas++; }
         $i++;
       }
       $xfecha = explode("-",$xfecha);
       // Columna fecha
       $fecha    = "<td>"."<b><a>".$xfecha[2]."  -  ".$xfecha[1]."/".$xfecha[0]."</a></b>"."</td>";
       // Columnas de Solicitudes y Citatorios
       $cuentas    = "<td>"."<p class='matriculas'>".$cuentas."</p>"."</td>";
       $citatorios = "<td>"."<p class='matriculas'>".$citatorios."</p>"."</td>";
       $tr = "<tr>".$fecha.$cuentas.$citatorios."<tr/>";
       $trs = $trs.$tr;
     }

     $table = "<table class='table table-bordered table-hover'>";
     $table = $table."<thead class='thead-dark'>";
     $table = $table."<tr>";
     $table = $table."<th width='10%'><strong>Fecha</strong></th>";
     // Se agregan dos columnas, una solicitudes y otra citatorios.
     $table = $table."<th><strong>Solicitudes: ".$revs."</strong></th>";
     $table = $table."<th width='10%'><strong>Citatorios: ".$citas."</strong></th>";
     $table = $table."</tr>";
     $table = $table."</thead>";
     $salida = $table.$trs."</table>";
     return $salida;
  }
  public function liberaSolicitudes()
  {
    // Borramos los ultimos registros de la tabla de Registros
    $deletedRows = Corte::where('solicitud_id','>',600)->delete();
    Solicitud::where('id','>',600)->update(['pasoACorte'=>false]);
    // Volvemos a generar las listas una vez restringidos los Registros
    // Agrupamiento y ordenamiento de cortes y listados
    Agunam::truncate(); // eliminamos los registros de listas agunamUpdate
    // reconstituimos las listas Agunam.
    $data = DB::table('cortes')
            ->select('listado_corte','listado_id')
            ->groupBy('listado_corte','listado_id')
            ->orderByRaw('CONCAT(SUBSTR(listado_corte,7,4),SUBSTR(listado_corte,4,2),SUBSTR(listado_corte,1,2),listado_id) asc')
            ->get()->toArray();
    foreach ($data as $value) {
        $regis = new Agunam();
        $regis->listado_corte = $value->listado_corte;
        $regis->listado_id    = $value->listado_id;
        $regis->user_id = 1;
        $regis->Solicitado_at = null;
        $regis->Recibido_at = null;
        $regis->save();
    }
  }
  public function creaListas()
  {
      $data = request()->validate
      (
        ['lista'           => ['required','integer','between:1,10']],
        ['lista.required' => 'El campo Listados es obligatorio',
         'lista.integer'  => 'El campo Listados debe ser numerico',
         'lista.between'  => 'El campo Listados debe estar entre:min - :max']
      );

      // Cantidad de listados
      $p = $_POST['lista'];
      // Si se selecciono escuela de procedencia, extrae la escuela del link. /cortes?facesc=Escuela_03; o deja un nulo
      $facs = ($_POST['facultad']!='/cortes') ? explode('=', $_POST['facultad'] )[1] : '';
       // Recuperamos las solicitudes filtradas o sin filtrar.
      // $list = ($facs!='') ? $this->solicitudesWeb(true,$facs) : $this->solicitudesWeb(false,$facs) ;
      $list = $this->solicitudesWeb2($facs);

      // dd($list);
      // Dividimos los registros en conjuntos de arreglos
      $listlen = count( $list );
      $partlen = floor( $listlen / $p );
      $partrem = $listlen % $p;
      $particion = array();
      $mark = 0;
      for ($px = 0; $px < $p ; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $particion[$px] = array_slice( $list, $mark, $incr );
        $mark += $incr;
      }
      // dd($particion);
      $this->altaListas($particion);

      // Si se trata de pruebas, se regeneran los archivos
      if (request()->input('pruebas')!=null) {
        $this->liberaSolicitudes();
      }
      return redirect('/cortes');
    }
  public function altaListas($particion)
  {
    // dd($particion);
      // Consulta del ultimo listado registrado para un determinado corte.
      $corte = Carbon::now()->format("d.m.Y");
      $lista_ini = Corte::where('listado_corte',$corte)
                    ->orderBy('listado_id','desc')
                    ->pluck('listado_id')
                    ->first();
      // Numero consecutivo de listado;
      $lista_ini = ($lista_ini==null)? 1: $lista_ini+1;

      for ($i=0; $i < count($particion) ; $i++) {
        for ($x=0; $x < count($particion[$i]) ; $x++) {
          // buscamos la solicitud para saber si no esta cancelada ni es citatorio
          // $solicitud = Solicitud::find($particion[$i][$x]['id']);
          if ( $particion[$i][$x]['tipo']==1 ) { // no se trata de un citatorio
            // Modificamos y guardamos la solicitud
            $solicitud = Solicitud::find($particion[$i][$x]['id']);
            $solicitud->pasoACorte = true;
            $solicitud->save();
            // Generamos un nuevo registros de revisión
            $rev_est = new Corte();
            $rev_est->solicitud_id = $particion[$i][$x]['id'] ;
            $rev_est->listado_corte = Carbon::now()->format("d.m.Y");
            $rev_est->listado_id = $lista_ini+$i;
            $rev_est->user_id = Auth::User()->id;
            $rev_est->save();
          }
        }
      }
      // Alta de cortes y listas en la tabla Agunam.
      if (count($particion[0])>0) {
        for ($i=0; $i < count($particion) ; $i++) {
            $agunam = new Agunam();
            $agunam->listado_corte = Carbon::now()->format("d.m.Y");
            $agunam->listado_id = $lista_ini+$i;
            $agunam->user_id = Auth::User()->id;
            $agunam->Solicitado_at = null;
            $agunam->Recibido_at = null;
            $agunam->save();
        }
      }
    }

    public function consultaListas()
    {
      // este conjunto de datos, debe ser enviado en la funcion superior.
        $listas =    Corte::orderBy('listado_corte','asc')
                        ->orderBy('listado_id','desc')->get();

    }
}
