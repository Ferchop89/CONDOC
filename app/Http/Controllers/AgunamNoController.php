<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgunamNo;
use App\Models\Agunam;
use App\Models\Solicitud;
use App\Models\Corte;
use DB;
use Carbon\Carbon;
use App\Rules\ctaNoAgunam;

class AgunamNoController extends Controller
{
  // Gestion de expedientes no encontrados en Agunam
  /*Método para listar usuarios*/
  public function expedientes(){
    // lista de expedientes no encontrados en agunam
    $expedientes = DB::table('agunamno')
                       ->where('agunamno.deleted_at','=',null)
                       ->join('cortes','agunamno.corte_id','=','cortes.id')
                       ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                       ->join('users','solicitudes.user_id','=','users.id')
                       ->join('procedencias','users.procedencia_id','=','procedencias.id')
                       ->select('agunamno.id',
                                'agunamno.encontrado',
                                'solicitudes.cuenta',
                                'solicitudes.nombre',
                                'procedencias.procedencia',
                                'cortes.listado_corte',
                                'cortes.listado_id',
                                'solicitudes.created_at'
                                )
                       ->GET();

    // dd($expedientes);agunam/expedientes
    $title = 'Expedientes no encontrados';
    return view('noagunam/lista_noagunam',['expedientes'=>$expedientes, 'title'=>$title]);
    // return view('noagunam/lista_noagunam', compact('title','expedientes'));
  }
  public function alta_noagunam(Request $request){

    $request->validate([
      'cuenta' => ['required', 'string', new ctaNoAgunam]
    ]);

    $cuenta = request()->cuenta;
    // como pasó la validacion, damos de alta un registro en noAgunam

    // buscamos el corte_id.
    $corteId = Solicitud::where('cuenta',$cuenta)->first()->CorteLista->id;

    // Damos de alta el registro
    $noagunam = new AgunamNo();
    $noagunam->corte_id = $corteId; // único campo obligatorio
    $noagunam->save();

    // regresamos a la lista para visualizar en Nuevo registro
    return redirect()->route('agunam/expedientes');
  }

  /*Método para editar información de un usuario*/
  public function editar_noagunam(AgunamNo $expediente)
  {
    // Edicion de expedientes no encontrados no en Agunam.
    $expOK = DB::table('agunamno')
                       ->where('agunamno.id','=',$expediente->id)
                       ->join('cortes','agunamno.corte_id','=','cortes.id')
                       ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                       ->join('users','solicitudes.user_id','=','users.id')
                       ->join('procedencias','users.procedencia_id','=','procedencias.id')
                       ->select('agunamno.id',
                                'agunamno.encontrado',
                                'agunamno.descripcion',
                                'agunamno.Encontrado_at',
                                'solicitudes.cuenta',
                                'solicitudes.nombre',
                                'procedencias.procedencia',
                                'cortes.listado_corte',
                                'cortes.listado_id',
                                'solicitudes.created_at'
                                )
                       ->GET()->first();
      // busqueda de las fechas del corte-listado.
      $agunam = Agunam::where('listado_corte',$expOK->listado_corte)
                      ->where('listado_id',$expOK->listado_id)->first();
      // Si se ha realizado la gestión de corte-lista, esto es, tienen fechas de solicitado y recibido
      $edita = ($agunam->Solicitado_at==null || $agunam->Recibido_at==null)? false: true;

      $title = 'Edicion Expedientes';

      return view('noagunam/editar_noagunam',['expediente'=> $expOK, 'title'=>$title, 'agunam' => $agunam, 'edita'=>$edita]);
  }

  public function salvar_noagunam($expediente){
    // actualización del registro
    $encontrado = request()->input('encontrado');
    $descrip    = request()->input('descrip');
    $fecha      = request()->input('actualiza');

    // dd($fecha);

    $exped = AgunamNo::find($expediente);
    $exped->descripcion = ($descrip!=null)? $descrip: "";
    $exped->encontrado = ($encontrado!=null)? true: false;
    $exped->Encontrado_at = $fecha;
    $exped->update();

    // return redirect()->route('agunam/expedientes');
    // return redirect()->route('noagunam/ver_noagunam',['expediente'=>$expediente]);
    $title = 'Salvar expediente';

    return view('noagunam/ver_noagunam',['expediente' => $exped_id, 'title' => $title ]);
    // return view('noagunam/ver_noagunam',['expediente' => $exped, 'title'=> $title]);
  }

  /*Método para visualizar información de un usuario*/
  public function ver_noagunam(AgunamNo $expediente)
  {
    // Edicion de expedientes no encontrados no en Agunam.
    $expOK = DB::table('agunamno')
                       ->where('agunamno.id','=',$expediente->id)
                       ->join('cortes','agunamno.corte_id','=','cortes.id')
                       ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                       ->join('users','solicitudes.user_id','=','users.id')
                       ->join('procedencias','users.procedencia_id','=','procedencias.id')
                       ->select('agunamno.id',
                                'agunamno.encontrado',
                                'agunamno.descripcion',
                                'agunamno.Encontrado_at',
                                'solicitudes.cuenta',
                                'solicitudes.nombre',
                                'procedencias.procedencia',
                                'cortes.listado_corte',
                                'cortes.listado_id',
                                'solicitudes.created_at'
                                )
                       ->GET()->first();
      // busqueda de las fechas del corte-listado.
      $agunam = Agunam::where('listado_corte',$expOK->listado_corte)
                      ->where('listado_id',$expOK->listado_id)->first();
      // Si se ha realizado la gestión de corte-lista, esto es, tienen fechas de solicitado y recibido
      $edita = ($agunam->Solicitado_at==null || $agunam->Recibido_at==null)? false: true;

      $title = 'Vista Expediente';

      return view('noagunam/ver_noagunam',['expediente'=> $expOK, 'title'=>$title, 'agunam' => $agunam, 'edita'=>$edita]);
  }

  public function eliminar_noagunam(AgunamNo $expediente)
  {
      // soft delete registros de expedientes no encontrados.
     $expediente->delete();

     return redirect()->route('agunam/expedientes');
  }


}
