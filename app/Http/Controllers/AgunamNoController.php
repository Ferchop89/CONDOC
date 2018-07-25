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
    $title = 'Expedientes no encontrados en AGUNAM';
    return view('noagunam/lista_noagunam',['expedientes'=>$expedientes, 'title'=>$title]);
    // return view('noagunam/lista_noagunam', compact('title','expedientes'));
  }
  public function alta_noagunam(Request $request){

     $request->validate([
       'cuenta' => ['required', 'numeric', 'digits:9', new ctaNoAgunam]
     ],[
       'cuenta.required' => 'Numero de cuenta obligatorio',
       'cuenta.numeric' => 'El Número de cuenta debe ser numérico',
       'cuenta.digits' => 'El Número de cuenta debe tener una longitud de 9 caracteres'
     ]);

     $cuenta = request()->cuenta;
     // como pasó la validacion, damos de alta un registro en noAgunam

     // Buscamos en la lista de expedientes NOagunam el expediente que vamos a dar de alta
     $expedientes = DB::table('agunamno')
                        ->where('solicitudes.cuenta',$cuenta)
                        ->join('cortes','agunamno.corte_id','=','cortes.id')
                        ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                        ->select('agunamno.id',
                                 'agunamno.encontrado_at',
                                 'solicitudes.cuenta',
                                 'solicitudes.nombre'
                                 )
                        ->GET()->first();

     if ($expedientes!=null) {
       // El registro se encontraba borrado, así que solo lo recuperamos.
       AgunamNo::withTrashed()->find($expedientes->id)->restore();
     } else {
       // El registro no existia, así que lo damos de alta
       $corteId = Solicitud::where('cuenta',$cuenta)->first()->CorteLista->id;
       // Damos de alta el registro
       $noagunam = new AgunamNo();
       $noagunam->corte_id = $corteId; // único campo obligatorio
       $noagunam->save();
     }

     // regresamos a la lista para visualizar en Nuevo registro
     return redirect()->route('agunam/expedientes_noagunam');
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

      $title = 'Edición de expedientes no encontrados en AGUNAM';

      return view('noagunam/editar_noagunam',['expediente'=> $expOK, 'title'=>$title, 'agunam' => $agunam, 'edita'=>$edita]);
  }

  public function salvar_noagunam(AgunamNo $expediente){
    // actualización del registro;

    // dd($expediente);
    $data = request()->validate
    (
      ['norecibido' => 'sometimes|date',
       'encontrado' => 'sometimes|nullable|date|after_or_equal:norecibido'],
      [ 'encontrado.required' => 'La fecha en se encontró el expediente es obligatoria',
        'encontrado.after_or_equal' => 'La fecha de expediente encontrado debe ser posterior a la recepción del listado en CERCONDOC']
    );

    $encontrado = request()->input('encontrado');
    $descrip    = request()->input('descrip');


    // los demas campos de noagunam
    $expediente->encontrado_at = $encontrado;
    $expediente->descripcion = ($descrip!=null)? $descrip: "";
    $expediente->update();

    // return redirect()->route('agunam/expedientes');
    // return redirect()->route('noagunam/ver_noagunam',['expediente'=>$expediente]);
    $title = 'Salvar expediente';

    // dd($expediente->id);
    return redirect()->route('ver_noagunam',['expediente'=>$expediente,'title'=>$title]);

    // return view('noagunam/ver_noagunam',['expediente' => $expediente->id, 'title' => $title ]);
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

      $title = 'Vista de expediente no encontrado en AGUNAM';

      return view('noagunam/ver_noagunam',['expediente'=> $expOK, 'title'=>$title, 'agunam' => $agunam, 'edita'=>$edita]);
  }

  public function eliminar_noagunam(AgunamNo $expediente)
  {
      // soft delete registros de expedientes no encontrados.
     $expediente->delete();

     return redirect()->route('agunam/expedientes_noagunam');
  }


}
