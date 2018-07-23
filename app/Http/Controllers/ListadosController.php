<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Corte;
use App\Models\Agunam;
use App\Models\Procedencia;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use \Milon\Barcode\DNS1D;

class ListadosController extends Controller
{
    public function Pdfs()
    {
        $corte = $_GET['corte']; // fecha de corte
        $lista = $_GET['lista']; // numero de lista a imprimir del corte
        $data = $this->lista_Corte($corte,$lista); // solicitudes de la lista y corte
        $rpp = 40; // registros por pagina del archivo PDF
        $limitesPDF = $this->paginas(count($data),$rpp); // limites de iteracion para registros del PDF
        $vista = $this->listaHTML($data,$corte,$lista,$limitesPDF); // generacion del content del PDF
        // return view("consultas.listasPDF", compact('vista'));
        $view = \View::make('consultas.listasPDF', compact('vista'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('Corte_'.str_replace('.','-',$corte).'_lista '.$lista.'.pdf');
    }
    public function Vales()
    {
        $corte = $_GET['corte']; // fecha de corte
        $lista = $_GET['lista']; // numero de lista a imprimir del corte
        $data = $this->lista_Corte($corte,$lista); // solicitudes de la lista y corte
        $rpp = 9; // registros por pagina del archivo PDF
        $limitesPDF = $this->paginas(count($data),$rpp); // limites de iteracion para registros del PDF
        $vista = $this->listaValesHTML($data,$corte,$lista,$limitesPDF); // generacion del content del PDF
        // return view("consultas.vales", compact('vista'));
        $view = \View::make('consultas.vales', compact('vista'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal','portrait');
        return $pdf->stream('Corte_'.str_replace('.','-',$corte).'_lista '.$lista.'.pdf');
    }
    public function Etiquetas()
    {
        $corte = $_GET['corte']; // fecha de corte
        $lista = $_GET['lista']; // numero de lista a imprimir del corte
        $data = $this->lista_Corte($corte,$lista); // solicitudes de la lista y corte
        $rpp = 14; // registros por pagina del archivo PDF
        $limitesPDF = $this->paginas(count($data),$rpp); // limites de iteracion para registros del PDF
        $vista = $this->listaEtiquetasHTML($data,$corte,$lista,$limitesPDF); // generacion del content del PDF
        // return view("consultas.etiquetas", compact('vista'));
        $view = \View::make('consultas.etiquetas', compact('vista'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('Corte_'.str_replace('.','-',$corte).'_lista '.$lista.'.pdf');
    }
    public function paginas($total_rpp,$rpp)
    {
        // Arreglo de registros por Pagina
        // $total_rpp Total de registros; $rpp Registros por pagina
        $entero = intdiv($total_rpp,$rpp);
        $residuo = $total_rpp % $rpp;
        $a_limites = array();
        // Si existe un residuo se aumenta un ciclo para cubrir los registros residuales
        $cuenta = ($residuo>0)? $entero+1: $entero;
        for ($i=0; $i < $cuenta ; $i++) {
          $inferior = $i * $rpp;
          $superior  = (($total_rpp-$inferior)<$rpp)? $inferior+$residuo: $inferior+$rpp;
          $limites = array($inferior,$superior);
          array_push($a_limites,$limites);
        }
        return $a_limites;
    }

    public function listaHTML($data,$corte,$lista,$limitesPDF)
    {
        // numero de hojas
        $composite = "";
        $paginas = count($limitesPDF);
        for ($i=0; $i < $paginas ; $i++)
        {
            $composite .= "<header id='details' class='clearfix'>";
            $composite .= "<table class='table-header'>";
            $composite .= "<tr>";
            $composite .= "<td class='logo'><img src='images/escudo_unam_solowblack.svg' alt=''></td>";
            $composite .= "<td>";
            $composite .= "<h1>UNIVERSIDAD NACIONAL AUTONOMA DE MÉXICO</h1>";
            $composite .= "<h2>DIRECCIÓN GENERAL DE ADMINISTRACIÓN ESCOLAR</h2>";
            $composite .= "<h3>DEPARTAMENTO DE REVISIÓN DE ESTUDIOS PROFESIONALES</h3>";
            $composite .= "<h3>Listado de Solicitud de Expedientes       Corte:".str_replace('.','/',$corte)."-".$lista."</h3>";
            $composite .= "</td>";
            $composite .= "</tr>";
            $composite .= "</table>";
            // $composite .= "<div id='invoice'>";
            // // $composite .=     "<h1>CORTE: ".$corte."</h1>";
            // $composite .= "</div>";
            $composite .= "</header>";
            $composite .= "<main>";
            $composite .= "<div class='test'>Impresión de prueba</div>";
            $composite .= "<table class='lista'>";
            $composite .= "<thead>";
            $composite .= "<tr>";
            $composite .= "<th class='num' scope='col'><strong>#</strong></th>";
            $composite .= "<th class='num_cta'scope='col'><strong>NO. CTA.</strong></th>";
            $composite .= "<th class='nombre' scope='col'><strong>NOMBRE</strong></th>";
            $composite .= "<th class='fac' scope='col'><strong>ESCUELA O FACULTAD</strong></th>";
            $composite .= "<th class='fecha' scope='col'><strong>FECHA; HORA</strong></th>";
            $composite .= "</tr>";
            $composite .= "</thead>";
            $composite .= "<tbody>";
            for ($x=$limitesPDF[$i][0]; $x < $limitesPDF[$i][1] ; $x++)
            {
                $composite .= "<tr>";
                $composite .= "<th scope='row'>".($x+1)."</th>";
                $composite .= "<td class='columna_1'>".substr($data[$x]->cuenta,0,1)."-".substr($data[$x]->cuenta,1,7)."-".substr($data[$x]->cuenta,8,1)."</td>";
                // $composite .= "<p class='num_cta elem_".($y)."'>".substr($data[$x]->cuenta,0,1)."-".substr($data[$x]->cuenta,1,7)."-".substr($data[$x]->cuenta,8,1)."</p>";
                $composite .= "<td class='columna_2'>".strtoupper($data[$x]->nombre)."</td>";
                $composite .= "<td class='columna_3'>".strtoupper($data[$x]->procedencia)."</td>";
                $composite .= "<td class='columna_4'>".explode('-',explode(' ',$data[$x]->created_at)[0])[2].'-'
                               .explode('-',explode(' ',$data[$x]->created_at)[0])[1].'-'
                               .explode('-',explode(' ',$data[$x]->created_at)[0])[0].'; '
                               .substr(explode(' ',$data[$x]->created_at)[1],0,5)."</td>";
                $composite .= "</tr>";
            }
            $composite .= "</tbody>";
            $composite .= "</table>";
            $composite .= "</main>";
            $composite .= "<footer>";
            $composite .= "Hoja ".($i+1)." de ".$paginas;
            $composite .= "   --   ";
            $composite .= "fecha ".date('d/m/Y');
            $composite .= "</footer>";
            $composite .= (($i+1)!=$paginas)? "<div class='page-break'></div>": "";
        }
        return $composite;
    }


    public function listaValesHTML($data,$corte,$lista,$limitesPDF)
    {
        // numero de hojas
        $composite = "";
        $paginas = count($limitesPDF);
        for ($i=0; $i < $paginas ; $i++)
        {
            $composite .= "<header>";
            $composite .= "</header>";
            $composite .= "<main>";
            $composite .= "<div class='content'>";
            $y=0;
            for ($x=$limitesPDF[$i][0]; $x < $limitesPDF[$i][1] ; $x++)
            {
                if($x%3==0)
                {
                    // var_dump($x%3);
                    $composite .= "<div class='vale left'>";
                }
                elseif($x%3==1){
                    $composite .= "<div class='vale center'>";
                }
                else{
                    $composite .= "<div class='vale right'>";
                }
                $composite .= "<p class='test elem_$y'>Impresión de prueba</p>";
                $composite .= "<p class='num_cta elem_".($y)."'>".substr($data[$x]->cuenta,0,1)."-".substr($data[$x]->cuenta,1,7)."-".substr($data[$x]->cuenta,8,1)."</p>";
                $composite .= "<p class='nombre elem_".($y)."'>".strtoupper($data[$x]->nombre)."</p>";
                $composite .= "<p class='oficina elem_$y'>Oficina: REV DE ESTUDIOS PROFESIONALES Y POSGRADO</p>";
                $composite .= "<div class='fecha elem_$y'>";
                $composite .= "<p class='dia elem_$y'>".explode('-',explode(' ',$data[$x]->created_at)[0])[2]."</p>";
                $composite .= "<p class='mes elem_$y'>".explode('-',explode(' ',$data[$x]->created_at)[0])[1]."</p>";
                $composite .= "<p class='dia elem_$y'>".explode('-',explode(' ',$data[$x]->created_at)[0])[0]."</p>";
                $composite .= "</div>";
                $composite .= "</div>";
                // var_dump($y%3);
                if ($y%3==2){
                    $composite .= "<div class='linea'>";
                    $composite .= "</div>";
                }
                // elseif ($y%3==0 && $x == $limitesPDF[$i][1]-1 ) {
                //     $composite .= "<div class='linea'>";
                //     $composite .= "</div>";
                // }

                    $y++;
                    if($y==9)
                    {
                        $composite .= "</div>";
                        $y=0;
                    }
                }

        $composite .= "</main>";
        $composite .= "<footer>";
        $composite .= "</footer>";
        if($i < $paginas-1)
        {
            $composite .= "<div class='page-break'>";
            $composite .= "</div>";
            }
        }
        return $composite;
    }
    public function listaEtiquetasHTML($data,$corte,$lista,$limitesPDF)
    {
        // numero de hojas
        $composite = "";
        $paginas = count($limitesPDF);
        for ($i=0; $i < $paginas ; $i++)
        {
            $composite .= "<header>";
            $composite .= "</header>";
            $composite .= "<main>";
            $composite .= "<div class='content'>";
            $y=0;
            for ($x=$limitesPDF[$i][0]; $x < $limitesPDF[$i][1] ; $x++)
            {
                if($x%2==0)
                {
                    $composite .= "<div class='etiqueta left'>";
                }
                else {
                    $composite .= "<div class='etiqueta right'>";
                }
                $composite .= "<p class='test elem_$y'>Impresión de prueba</p>";
                $composite .= "<p class='num_cta elem_".($y)."'>".substr($data[$x]->cuenta,0,1)."-".substr($data[$x]->cuenta,1,7)."-".substr($data[$x]->cuenta,8,1)."</p>";
                $composite .= "<p class='nombre elem_".($y)."'>".strtoupper($data[$x]->nombre)."</p>";
                $composite .= "<p class='num_cta_big elem_".($y)."'>".substr($data[$x]->cuenta,0,1)."-".substr($data[$x]->cuenta,1,7)."-".substr($data[$x]->cuenta,8,1)."</p>";
                $d = new DNS1D();
                $d->setStorPath(__DIR__."/cache/");
                $composite.= "<div class='barcode'>".$d->getBarcodeHTML($data[$x]->cuenta, "C39", 1.6, 37)."</div>";
                // $composite .= "</td>";
                $composite .= "</div>";
                if ($y%2!=0){
                    $composite .= "<div class='linea'>";
                    $composite .= "</div>";
                }
                elseif ($y%2==0 && $x == $limitesPDF[$i][1]-1 ) {
                    $composite .= "<div class='linea'>";
                    $composite .= "</div>";
                }
                $y++;
                if($y==14)
                {
                    $y=0;
                }
            }
            $composite .= "</main>";
            $composite .= "<footer>";
            $composite .= "</footer>";
            if($i < $paginas-1)
            {
                $composite .= "<div class='page-break'>";
                $composite .= "</div>";
            }
        }
        return $composite;
    }
    public function listas()
    {
        // Generación de Listas por corte para ser impresas en PDF
        $title = "Impresión de Listados";
        // Eleccion de la fecha de corte. Si no se ha elegido, se escoge la ultima.
        $reqFecha = request()->input('datepicker');
        if ($reqFecha==null) {
            $corte = $this->ultimoCorte();
        } else {
            $vfecha = explode("/",$reqFecha);
            $xfecha = $vfecha[0].".".$vfecha[1].".".$vfecha[2];
            $corte = $xfecha;
        }
        // Se pulso el boton PDF o se eligio el cambio de fecha de corte para listar nuevos No de Cuenta.
        if (isset($_GET['btnLista'])) {
            $afecha = explode('/',$_GET['datepicker']); // Cambiar fecha de formate mm/dd/aaaa a dd.mm.aaaa
            $corte = $afecha[0].'.'.$afecha[1].'.'.$afecha[2];
            $lista = $_GET['btnLista'];
        return redirect()->route('imprimePDF',compact('corte','lista'));
        }
        elseif (isset($_GET['btnVale'])) {
            $afecha = explode('/',$_GET['datepicker']); // Cambiar fecha de formate mm/dd/aaaa a dd.mm.aaaa
            $corte = $afecha[0].'.'.$afecha[1].'.'.$afecha[2];
            $lista = $_GET['btnVale'];
        return redirect()->route('imprimeVale',compact('corte','lista'));
        }
        elseif (isset($_GET['btnEtiqueta'])) {
            $afecha = explode('/',$_GET['datepicker']); // Cambiar fecha de formate mm/dd/aaaa a dd.mm.aaaa
            $corte = $afecha[0].'.'.$afecha[1].'.'.$afecha[2];
            $lista = $_GET['btnEtiqueta'];
        return redirect()->route('imprimeEtiqueta',compact('corte','lista'));
        }
        else {// Cambio de fecha de corte y listado del mismo.
            $data = $this->listasxCorte($corte);
            $nListas = count($data);
            $xProcede  = $this->procedencias($data);
            return view('consultas.listasRev',[
                'title'=>$title,
                'data'=>$data,
                'corte' =>$corte,
                'nListas' => $nListas, // la consulta no arrojo listas
                'procede' => $xProcede
                ]);
      }
    }
    public function procedencias($data)
    {
      // Procedimiento para determinar si las listas provienen de una escuelas
      $procede = array();
      for ($i=0; $i <count($data) ; $i++) {
        $escuela = $data[$i][0]->procedencia; $cuenta = 0;
        for ($x=0; $x <count($data[$i]) ; $x++) {
          $cuenta = ($escuela==$data[$i][$x]->procedencia)? $cuenta+1: $cuenta;
        }
        $procede[$i] = ($cuenta==count($data[$i]))? 'Escuela: '.$escuela : "";
      }
      return $procede;
    }
    public function ultimoCorte()
    {
      $lista_ini = Corte::all()->last()->listado_corte;
      return $lista_ini;
    }
    public function listasxCorte($corte)
    {
        // cortes y listas relacionando las tablas para resolver llaves de la tabla.
        $cortes = DB::table('cortes')
                         ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                         ->join('users','solicitudes.user_id','=','users.id')
                         ->join('procedencias','users.procedencia_id','=','procedencias.id')
                         ->select('cortes.listado_corte','cortes.listado_id',
                                  'solicitudes.cuenta','solicitudes.nombre','solicitudes.user_id',
                                  'procedencias.procedencia','solicitudes.created_at')
                         ->where('cortes.listado_corte',$corte)
                         ->orderBy('cortes.listado_id','ASC')
                         ->orderBy('solicitudes.cuenta','ASC')
                         ->GET()->toArray();

         // Convertimos el arreglo continuo en un arreglo de listados
         $objetos = array();  // arreglo de objetos
         $listados = array(); // Arreglo de listados.
         // Si se consulta una fecha sin cortes, no se realiza proceso alguno.
         if ($cortes!=[]) {
           $listado = $cortes[0]->listado_id;
           for ($i=0; $i < count($cortes); $i++) {
              if ($cortes[$i]->listado_id == $listado) {
                array_push($objetos,$cortes[$i]);
                if (($i+1)==count($cortes)) {
                  array_push($listados, $objetos);
                }
              } else {
                array_push($listados, $objetos);
                $listado = $cortes[$i]->listado_id;
                $objetos = array();
                array_push($objetos,$cortes[$i]);
              }
           }
         }

         return $listados;
    }
    public function lista_Corte($corte,$lista)
    {
      $cortes = DB::table('cortes')
                         ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                         ->join('users','solicitudes.user_id','=','users.id')
                         ->join('procedencias','users.procedencia_id','=','procedencias.id')
                         ->select('cortes.listado_corte','cortes.listado_id',
                                  'solicitudes.cuenta','solicitudes.nombre','solicitudes.user_id',
                                  'procedencias.procedencia','solicitudes.created_at')
                         ->where('cortes.listado_corte',$corte)
                         ->where('cortes.listado_id',$lista)
                         ->orderBy('solicitudes.cuenta','ASC')
                         ->GET()->toArray();
      return $cortes;
    }
    public function gestionAgunam()
    {
      // Despliega los cortes y listas de un mes en particular para registrar envio y recepcion de Expedientes.
      $title = 'Gestión de Listas de expedientes en AGUNAM';
      // Obtenemos todos los cortes y las listas disponibles en un listado
      $data = Agunam::orderByRaw('CONCAT(SUBSTR(listado_corte,7,4),SUBSTR(listado_corte,4,2),SUBSTR(listado_corte,1,2)) DESC')
              ->orderBy('listado_id', 'ASC')
              ->get()
              ->toArray();
      // Si en la url viene la fecha de corte, extraemos año-mes para inicializar el campo en la vista
      if (isset($_GET['mes'])) {
        $A_mes = $_GET['mes'];
      }else {
        if (count($data)!=0) {
          $A_mes = substr($data[0]['listado_corte'],6,4).'-'.substr($data[0]['listado_corte'],3,2);
        } else {
          // No existen registro en la tabla cortes.
          $A_mes = "";
        }
      }
      // Filtramos el arreglo de cortes y listas disponibles si coinciden con el mes-año...
      $data_F = array();
      foreach ($data as $corte) {
        $Anio_mes = substr($corte['listado_corte'],6,4).'-'.substr($corte['listado_corte'],3,2);
        if ($Anio_mes==$A_mes) {
           // dd($Anio_mes,$A_mes);
           array_push($data_F,$corte);
        }
      }
      // buscamos si cada corte contiene una promocion o proviene de multiples escuelas.
      $cortes_plus = array();
      for ($i=0; $i < count($data_F) ; $i++) {
        $promo = DB::table('cortes')
                           ->join('solicitudes','cortes.solicitud_id','=','solicitudes.id')
                           ->join('users','solicitudes.user_id','=','users.id')
                           ->join('procedencias','users.procedencia_id','=','procedencias.id')
                           ->select('procedencias.procedencia')
                           ->where('cortes.listado_corte',$data_F[$i]['listado_corte'])
                           ->where('cortes.listado_id',$data_F[$i]['listado_id'])
                           ->groupBy('procedencias.procedencia')
                           ->GET()->toArray();
       $data_F[$i]['procedencia'] = (count($promo)==1)? $promo[0]->procedencia: "";
       array_push($cortes_plus,$data_F[$i]);
      }
      // enviamos a la vista, cortes-listas, el titulo y el año-mes.
      return view('listas.listaAgunam',[
              // 'listas'=>$data_F,
              'listas' => $cortes_plus,
              'title' =>$title,
              'mesCorte' =>$A_mes
            ]);
    }
    public function agunamUpdate($listado_corte,$listado_id)
    {
      // Actualizacion de Envio y Recibo de corte-lista.
      $title = 'Registro de Envio y Recepción de Listas';
      $corte = Agunam::where('listado_corte',$listado_corte)
                       ->where('listado_id',$listado_id)
                       ->get()
                       ->toArray();
      // El formato Año-mes de la consulta va como parametro
       $A_mes = substr($listado_corte,6,4).'-'.substr($listado_corte,3,2);
       // Enviamos a la vista el registro del corte que cumple con corte-listado y el mes de corte
       return view('listas.editar_agunam',[
               'agunam'=>$corte,
               'title'=>$title,
               'mesCorte' => $A_mes
             ]);
    }
    public function agunamUpdateOk()
    {
      // Registro de los cambios en la tabla cortes

      // El primer campo de fecha de Envio del listado se vuelve obligatoria
      $data = request()->validate
      (
        ['solicitar' => 'required|nullable|date',
         'recibir' => 'sometimes|nullable|date|after_or_equal:solicitar'],
        ['solicitar.required' => 'La Fecha de Envío AGUNAM obligatoria',
         'recibir.after_or_equal' => 'La fecha de Recepción del Listado, debe ser igual o posterior a su Envio']
      );
      $data =       request()->input('prueba');
      $corte =      request()->input('corte');
      $listado =    request()->input('listado');
      $solicitar =  request()->input('solicitar');
      $recibir =    request()->input('recibir');
      $lista = Agunam::where('listado_corte',$corte)
      ->where('listado_id',$listado)->first();

      // Si los campos de solicitado y recibido son nulos se almacenan nulos en la fecha
      $lista->Solicitado_at = ($solicitar!=null)? date($solicitar): null;
      $lista->Recibido_at =  ($recibir!=null)? date($recibir): null;
      $lista->update();
      // De regreso, el campo $A_mes nos sirve para filtrar los registros a un año-mes en particular.
      $A_mes = substr($corte,6,4).'-'.substr($corte,3,2);
      // Una ves actualizado el registro, regresamos a la vista de Cortes-Listado.
      return redirect()->route('AGUNAM',['mes'=>$A_mes]);
    }
}
