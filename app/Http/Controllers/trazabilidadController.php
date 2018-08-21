<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Corte;
use App\Models\Agunam;


class trazabilidadController extends Controller
{
  public function traza()
  {
    $title = 'Trazabilidad de Solicitudes de Revisión de Estudios';
    // $html = (request()->cuenta==null)? '': $this->trazaConsulta();
    $data =  (request()->cuenta==null)? '': $this->trazabilidad();

    // dd($data);

    return view('consultas.traza',compact('title','data'));
  }

  public function trazabilidad()
  {
    $data = request()->validate([
      'cuenta' => ['required', 'numeric', 'digits:9'],
      'cuenta' => 'exists:solicitudes'
    ],[
      'cuenta.required' => 'Numero de cuenta obligatorio',
      'cuenta.numeric' => 'El Número de cuenta debe ser numérico',
      'cuenta.digits' => 'El Número de cuenta debe tener una longitud de 9 caracteres',
      'cuenta.exists' => 'No se ha solicitado Revisión de Estudios para este Número de Cuenta'
    ]);
    $cuenta = request()->cuenta;

    $html = $this->dataTraza($cuenta,'solicitud');

    return $html;
  }

  public function dataTraza($cuenta,$tipo)
{
    // Consulta de las solicitudes o citatorios asociados a un numero de cuenta.
    //  Diferenciamos Solicitudes o Citatorios.
    if ($tipo=='solicitud') {
       $consulta = Solicitud::where('cuenta',$cuenta)->
                                 where('citatorio',false)->get()->toArray();
    } else { // Citatorios
       $consulta = Solicitud::where('cuenta',$cuenta)->
                                 where('citatorio',true)->get()->toArray();
    }
    return $consulta;
  }

  public function trazaConsulta($cuenta,$carrera,$plan)
  {
    $title = 'Trazabilidad completa';
    // dd($cuenta,$carrera,$plan);
    $solicitud = $this->dataTrazaSolicitud($cuenta,$carrera,$plan,'solicitud');
    $trazaCompleta = $this->IntegraTrazas($cuenta,$carrera,$plan);
    // dd($solicitud);
    return  view('consultas.trazaConsulta',compact('title','solicitud','trazaCompleta'));
  }

  public function IntegraTrazas($cuenta,$carrera,$plan)
  {
    // Genera una actividad por cada traza.
    $html="<table class='table table-bordered table-hover'>";
      $html=$html."<thead>";
        $html=$html."<tr>";
          $html=$html."<th>Actividad</th>";
          $html=$html."<th>Responsable</th>";
          $html=$html."<th>Fecha</th>";
          $html=$html."<th></th>";
        $html=$html."</tr>";
      $html=$html."</thead>";
      // un registro por cada traza
      $html=$html.$this->trazaSolicitud($cuenta,$carrera,$plan,'solicitud');
      $html=$html.$this->trazaCorte($cuenta,$carrera,$plan,'solicitud');
      $html=$html.$this->trazaAgunamIda($cuenta,$carrera,$plan,'solicitud');
      $html=$html.$this->trazaAgunamVuelta($cuenta,$carrera,$plan,'solicitud');
    $html=$html."</table>";

    return $html;
  }

  public function dataTrazaSolicitud($cuenta,$carrera,$plan,$tipo)
  {
    // Consulta de trazabilidad para un citatorio
    //  Diferenciamos Solicitudes o Citatorios.
    if ($tipo=='solicitud') {
       $consulta = Solicitud::where('cuenta',$cuenta)->
                              where('carrera_id',$carrera)->
                              where('plan_id',$plan)->
                              where('citatorio',false)->get()->toArray();
    } else { // Citatorios
      // Pendiente Citatorios
    }

    return $consulta;
  }

  public function trazaSolicitud($cuenta,$carrera,$plan,$tipo)
  {
    // Datos de la solicitud que vienen de la tabla Solicitudes
    if ($tipo=='solicitud') {
       $consulta = Solicitud::where('cuenta',$cuenta)->
                              where('carrera_id',$carrera)->
                              where('plan_id',$plan)->
                              where('citatorio',false)->get()->toArray();
    } else { // Citatorios
      // Pendiente Citatorios
    }
    $html = '';
    if ($consulta!=[]) {
      $procede = User::find($consulta[0]['user_id'])->procede()->first()->procedencia;
      $html=$html."<tr>";
        $html=$html."<td><strong>CAPTURA SOLICITUD</strong></td>";
        $html=$html."<td><strong>".$procede."</strong></td>";
        $html=$html."<td><strong>".$consulta[0]['created_at']."</strong></td>";
      $html=$html."</tr>";
    }
    return $html;
  }

  public function trazaCorte($cuenta,$carrera,$plan,$tipo)
  {
    // Datos del corte que vienen de la solicitud (updated_at) y de el usuario que realizó el corte
    if ($tipo=='solicitud') {
       $consulta = Solicitud::where('cuenta',$cuenta)->
                              where('carrera_id',$carrera)->
                              where('plan_id',$plan)->
                              where('citatorio',false)->get()->toArray();
    } else { // Citatorios
      // Pendiente Citatorios
    }
    $html = '';
    if ($consulta!=[]) {
      // Corte realizado
      $corte = Corte::where('solicitud_id',$consulta[0]['id'])->first();
      // Usuario que realiza la actividad
      $usuario = User::where('id',$corte->user_id)->first();
      // Obtenemos la Informacion
      $fechaCorte = ($corte==[])? '': $corte->updated_at;
      $listadoCorte = ($corte==[])? '': 'Realiza el Corte-listado ('.$corte->listado_corte.'-'.$corte->listado_id.')';
      // formacion del registro.
      $html=$html."<tr>";
        $html=$html."<td><strong>".strtoupper($listadoCorte)."</strong></td>";
        $html=$html."<td><strong>".strtoupper($usuario->name)."</strong></td>";
        $html=$html."<td><strong>".$fechaCorte."</strong></td>";
      $html=$html."</tr>";
    }
    return $html;
  }

  public function trazaAgunamIda($cuenta,$carrera,$plan,$tipo)
  {
    // Traza de el registro de la solicitud y entrega del listado hacia y desde agunam
    if ($tipo=='solicitud') {
       $consulta = Solicitud::where('cuenta',$cuenta)->
                              where('carrera_id',$carrera)->
                              where('plan_id',$plan)->
                              where('citatorio',false)->get()->toArray();
    } else { // Citatorios
      // Pendiente Citatorios
    }
    $html = '';
    if ($consulta!=[]) {
      // Corte realizado
      $corte = Corte::where('solicitud_id',$consulta[0]['id'])->first();
      $agunam = Agunam::where('listado_corte',$corte->listado_corte)->first();
      // Usuario que realiza la actividad
      $usuario = User::where('id',$agunam->user_id)->first();
      // Obtenemos la Informacion
      $fechaEnvio = ($agunam[0]['Solicitado_at']==null)? '--pendiente--': $agunam->Solicitado_at;
      $listadoCorte = ($corte==[])? '': 'Envio a Agunam Corte-listado ('.$corte->listado_corte.'-'.$corte->listado_id.')';
      // formacion del registro.
      $html=$html."<tr>";
        $html=$html."<td><strong>".strToUpper($listadoCorte)."</strong></td>";
        $html=$html."<td><strong>".strToUpper($usuario->name)."</strong></td>";
        $html=$html."<td><strong>".$fechaEnvio."</strong></td>";
      $html=$html."</tr>";
    }
    return $html;
  }

  public function trazaAgunamVuelta($cuenta,$carrera,$plan,$tipo)
  {
    // Traza de el registro de la solicitud y entrega del listado hacia y desde agunam
    if ($tipo=='solicitud') {
       $consulta = Solicitud::where('cuenta',$cuenta)->
                              where('carrera_id',$carrera)->
                              where('plan_id',$plan)->
                              where('citatorio',false)->get()->toArray();
    } else { // Citatorios
      // Pendiente Citatorios
    }
    $html = '';
    if ($consulta!=[]) {
      // Corte realizado
      $corte = Corte::where('solicitud_id',$consulta[0]['id'])->first();
      $agunam = Agunam::where('listado_corte',$corte->listado_corte)->first();
      // Usuario que realiza la actividad
      $usuario = User::where('id',$agunam->user_id)->first();
      // Obtenemos la Informacion
      $fechaRecibe = ($agunam[0]['Recibido_at']==null)? '--pendiente--': $agunam->Recibido_at;
      $listadoCorte = ($corte==[])? '': 'Recepcion del Corte-listado ('.$corte->listado_corte.'-'.$corte->listado_id.') en Cercondoc';
      // formacion del registro.
      $html=$html."<tr>";
        $html=$html."<td><strong>".strToUpper($listadoCorte)."</strong></td>";
        $html=$html."<td><strong>".strToUpper($usuario->name)."</strong></td>";
        $html=$html."<td><strong>".$fechaRecibe."</strong></td>";
      $html=$html."</tr>";
    }
    return $html;
  }

}
