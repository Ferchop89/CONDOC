<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Corte;
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
        return view("consultas.vales", compact('vista'));
        // $view = \View::make('consultas.vales', compact('vista'))->render();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view)->setPaper('legal','portrait');
        // return $pdf->stream('Corte_'.str_replace('.','-',$corte).'_lista '.$lista.'.pdf');
    }
    public function Etiquetas()
    {
        $corte = $_GET['corte']; // fecha de corte
        $lista = $_GET['lista']; // numero de lista a imprimir del corte
        $data = $this->lista_Corte($corte,$lista); // solicitudes de la lista y corte
        $rpp = 14; // registros por pagina del archivo PDF
        $limitesPDF = $this->paginas(count($data),$rpp); // limites de iteracion para registros del PDF
        // dd($limitesPDF);
        $vista = $this->listaEtiquetasHTML($data,$corte,$lista,$limitesPDF); // generacion del content del PDF
        return view("consultas.etiquetas", compact('vista'));
        // $view = \View::make('consultas.etiquetas', compact('vista'))->render();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view);
        // return $pdf->stream('Corte_'.str_replace('.','-',$corte).'_lista '.$lista.'.pdf');
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
            $composite .= "</header>";
            $composite .= "<main>";
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
                $composite .= "<td class='columna_1'>".$data[$x]->cuenta."</td>";
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
            $composite .= "<main>";
            $y=0;
            for ($x=$limitesPDF[$i][0]; $x < $limitesPDF[$i][1] ; $x=$x+3)
            {
                $composite .= "<table class='lista'>";
                $composite .= "<tbody>";
                $composite .= "<thead>";
                $composite .= "<tr>";
                $composite .= "<th class='columna_1' scope='col'></th>";
                $composite .= "<th class='columna_2' scope='col'></th>";
                $composite .= "<th class='columna_3' scope='col'></th>";
                $composite .= "</tr>";
                $composite .= "</thead>";
                $composite .= "<tr>";
                $composite .= "<td class='col_1'>";
                $composite .= "<p class='test elem_$y'>Impresión de prueba</p>";
                $composite .= "<p class='num_cta elem_".($y)."'>".substr($data[$x]->cuenta,0,1)."-".substr($data[$x]->cuenta,1,7)."-".substr($data[$x]->cuenta,8,1)."</p>";
                $composite .= "<p class='nombre elem_".($y)."'>".strtoupper($data[$x]->nombre)."</p>";
                $composite .= "<p class='oficina elem_$y'>Oficina: REV DE ESTUDIOS PROFESIONALES Y POSGRADO</p>";
                $composite .= "<p class='fecha elem_$y'>".explode('-',explode(' ',$data[$x]->created_at)[0])[2].'-'
                               .explode('-',explode(' ',$data[$x]->created_at)[0])[1].'-'
                               .explode('-',explode(' ',$data[$x]->created_at)[0])[0].'; '
                               .substr(explode(' ',$data[$x]->created_at)[1],0,5)."</p>";
                $composite .= "</td>";
                if(isset($data[$x+1])){
                    $y++;
                    $composite .= "<td class='col_2'>";
                    $composite .= "<p class='test elem_$y'>Impresión de prueba</p>";
                    $composite .= "<p class='num_cta elem_".($y)."'>".substr($data[$x+1]->cuenta,0,1)."-".substr($data[$x+1]->cuenta,1,7)."-".substr($data[$x+1]->cuenta,8,1)."</p>";
                    $composite .= "<p class='nombre elem_".($y)."'>".strtoupper($data[$x+1]->nombre)."</p>";
                    $composite .= "<p class='oficina elem_$y'>Oficina: REV DE ESTUDIOS PROFESIONALES Y POSGRADO</p>";
                    $composite .= "<p class='fecha elem_$y'>".explode('-',explode(' ',$data[$x+1]->created_at)[0])[2].'-'
                                   .explode('-',explode(' ',$data[$x+1]->created_at)[0])[1].'-'
                                   .explode('-',explode(' ',$data[$x+1]->created_at)[0])[0].'; '
                                   .substr(explode(' ',$data[$x+1]->created_at)[1],0,5)."</p>";
                    $composite .= "</td>";
                }
                if (isset($data[$x+2])) {
                    $y++;
                    $composite .= "<td class='col_3'>";
                    $composite .= "<p class='test elem_$y'>Impresión de prueba</p>";
                    $composite .= "<p class='num_cta elem_".($y)."'>".substr($data[$x+2]->cuenta,0,1)."-".substr($data[$x+2]->cuenta,1,7)."-".substr($data[$x+2]->cuenta,8,1)."</p>";
                    $composite .= "<p class='nombre elem_".($y)."'>".strtoupper($data[$x+2]->nombre)."</p>";
                    $composite .= "<p class='oficina elem_$y'>Oficina: REV DE ESTUDIOS PROFESIONALES Y POSGRADO</p>";
                    $composite .= "<p class='fecha elem_$y'>".explode('-',explode(' ',$data[$x+2]->created_at)[0])[2].'-'
                                   .explode('-',explode(' ',$data[$x+2]->created_at)[0])[1].'-'
                                   .explode('-',explode(' ',$data[$x+2]->created_at)[0])[0].'; '
                                   .substr(explode(' ',$data[$x+2]->created_at)[1],0,5)."</p>";
                    $composite .= "</td>";
                    $composite .= "</tr>";
                    $composite .= "</tbody>";
                    $composite .= "</table>";
                    $y++;
                    if($y==9)
                    {
                        $y=0;
                    }
                }
            }
            $composite .= "</main>";
            $composite .= "<footer>";
            $composite .= "</footer>";
            $composite .= (($i+1)!=$paginas)? "<div class='page-break'></div>": "";
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
                $composite .= "</td>";
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
        $title = "Impresión de Listados";
        $reqFecha = request()->input('datepicker');
        if ($reqFecha==null) {
            $corte = $this->ultimoCorte();
        } else {
            $vfecha = explode("/",$reqFecha);
            $xfecha = $vfecha[0].".".$vfecha[1].".".$vfecha[2];
            $corte = $xfecha;
        }
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
        else {
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
    public function pdf()
    {
      dd('Hola');
    }

}
