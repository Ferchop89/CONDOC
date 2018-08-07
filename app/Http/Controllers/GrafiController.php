<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use DB;

class GrafiController extends Controller
{
    //
    public function solicitudes()
    {
        // Genera las graficas de solicitudes y citatorios

        // En su primera carga, toma varores de la base de datos, sino, selecciona y enviados por submit
        $a = $m = $o = array();
        $a = $this->solicitudesAnio();
        $aSel = (request()->anio_id==null)? max($a)             : request()->anio_id;
        $m = $this->solicitudesMes($aSel);
        $mSel = (request()->mes_id==null)? substr(max($m),0,2)  : request()->mes_id; // "07. Julio" obtenemos el '07'
        $o = $this->solicitudesOrigen($aSel,$mSel);
        $oSel = (request()->origen_id==null)? ''                : request()->origen_id;

        // Asimamos esos arreglos para los select de la vista
        $anio   = $a;  // arreglo de años y el valor seleccionado (ultimo año)
        $mes    = $m;  // arreglo de meses y valor sleccionado (ultimo mes)
        $origen = $o;  // arreglo de procedencias y el valor seleccionado (todas las procedencias)

        // Grafico de barras
        $Titulo = 'SOLICITUDES DE REVISIÓN DE ESTUDIOS';
        $ejeX   = 'DIA DEL MES';
        $ejeY   = 'SOLICITUDES';
        $chart1 = $this->bar_Genera($mSel,$aSel,$oSel,$Titulo,$ejeX,$ejeY);
        $data = $this->dataBarra($mSel,$aSel,$oSel);
        // Grafico pie
        $chart2 = $this->pie_Genera($mSel,$aSel,$oSel,'General');

        // Titulo de la vista, Tablero de Control
        $title = 'Tablero Control';
         // Renderizamos en la vista.
         return view('graficas/solycita', compact('chart1','chart2','anio', 'aSel','mes','mSel','origen','oSel','data','title'));
         // return view('graficas/solycita', compact('chart1','chart2','procedencia','mes','origen','periodos'));
    }

    public function bar_Genera($paraMes,$anio,$paraProc,$Titulo,$ejeX,$ejeY)
    {
        // Generamos el grafico de barra a partir de los datos

        // $arreglo contiene los datos de la consulta en arrenglo de llave-pair
        $arreglo = $this->dataBarra($paraMes,$anio,$paraProc);
        // $arreglo = $this->dataBarra('05','2018','010');
        // El $arreglo se pasa a tres arreglos uno de etiquetas (dias de mes), otro de Solicitudes ($data1) y Citatorios ($data2)
        $labels = $data1 = $data2 = array();
        foreach ($arreglo as $key => $value) {
          array_push($labels,$key);
          array_push($data1,$value[0]);
          array_push($data2,$value[1]);
        }
        // Componemos el arreglo para el gráfico con etiquetas y datos
        $chart = $this->bar_Grafico($labels,$data1,$data2,$Titulo,$ejeX,$ejeY);

        return $chart;
    }

    public function pie_Genera($paraMes,$anio,$paraProc,$nombreGraf)
    {
        // Generamos el grafico de pie a partir de los datos

        // $arreglo contiene los datos de la consulta en arrenglo de llave-pair
        $data = $this->dataPie($paraMes,$anio,$paraProc);

        // El $arreglo se pasa a tres arreglos uno de etiquetas (dias de mes), otro de Solicitudes ($data1) y Citatorios ($data2)
        $labels = ['Solicitudes','Citatorios'];
        // Componemos el arreglo para el gráfico con etiquetas y datos
        $chart = $this->pie_Grafico($labels,$data,$nombreGraf);

        return $chart;
    }

    public function bar_Grafico($labels,$data1,$data2,$Titulo,$ejeX,$ejeY)
    {
      // grafico de barras de 2 conjuntos de datos

      $chartjs = app()->chartjs
        ->name('grafico')
        ->type('bar')
        ->size(['width' => 900, 'height' => 380])
        ->labels($labels)
        ->datasets([
            [
                "label" => "Solicitud",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $data1,
            ],
            [
                "label" => "citatorio",
                'backgroundColor' => "palegreen",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $data2,
            ]
        ])
        ->options([]);

        $chartjs->optionsRaw([
          'legend' => [
              'display' => true,
              'labels' => [
                  'fontColor' => '#000'
              ]
          ],
          'title' => [
            'display' => true,
            'text' => $Titulo,
            'fontSize' => 18
          ],
          'scales' => [
              'xAxes' => [
                  [
                    'scaleLabel' => ['display' => true, 'labelString'=>$ejeX],
                    'stacked' => false,
                    'gridLines' => ['display' => true]
                  ]
              ],
              'yAxes' => [
                [
                    'scaleLabel' => ['display' => true, 'labelString'=>$ejeY],
                    'ticks' => [
                        'min' => 0,
                        'stepSize' => 1
                    ]

                ]
              ]
          ]
        ]);

        return $chartjs;
    }

    public function pie_Grafico($labels,$data)
    {
      $chartjs = app()->chartjs
        ->name('pieChartTest')
        ->type('doughnut')
        ->size(['width' => 480, 'height' => 318])
        ->labels($labels)
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => $data
            ]
        ])
        ->options([]);
      return $chartjs;
    }

    public function dataBarra($mes,$anio,$procede)
    {
       // consultas diarias de solicitudes y citatorios.

       // Año y mes para filtrar la consulta.
        $mesAnio = "'".str_pad($mes,2,0,STR_PAD_LEFT).$anio."'";

        $query =  'select DATE_FORMAT(solicitudes.created_at, "%d") as dia, ';
        $query .=  'citatorio, ';
        $query .= 'count(*) as cantidad ';
        $query .= 'from solicitudes inner join users on users.id = solicitudes.user_id ';
        $query .= 'where DATE_FORMAT(solicitudes.created_at,"%m%Y") = '.$mesAnio.' ';
        $query .=  ($procede!='')? 'and users.procedencia_id = '.$procede.' ' : '';
        $query .= 'and cancelada = 0 ';
        $query .= 'group by citatorio, dia ';
        $query .= 'order by dia asc ';
        $data = DB::select($query);

        // mapeamos la consulta a una arreglo de dia=>[cantidad de solicitudes, cantidad de citatorios.]

        // arreglo que contiene las cantidades de 0-citatorios 0-solicitudes que son el value del Key (dia)
        $arreglo = array(); $tipo = [0,0];
        // Colocamos por cada llave (dia) una arreglo con la cantidad de citatorios [0] y solicitudes en [1]
        foreach ($data as $value) {
          if (array_key_exists($value->dia,$arreglo)) {
            // Un key (dia) puede tener hasta 2 registros, si existe la llave actualiza con la cantidad
            $arreglo[$value->dia][$value->citatorio] = $value->cantidad;
          } else {
            // Un key (dia) puede tener hasta 2 registros, no existe la llave se crea y apunta al array $tipo
            // y se uno de los dos indices (solicitud o citatoro) se actualiza con la cantidad
            $arreglo[$value->dia] = $tipo;
            $arreglo[$value->dia][$value->citatorio] = $value->cantidad;
          }
        }

        return $arreglo;
    }

    public function dataPie($mes,$anio,$procede)
    {
       // consultas diarias de solicitudes y citatorios.

       // dd($mes,$anio,$procede);

       // Año y mes para filtrar la consulta.
        $mesAnio = "'".str_pad($mes,2,0,STR_PAD_LEFT).$anio."'";

        $query =  'select citatorio, count(*) as cantidad ';
        $query .= 'from solicitudes inner join users on users.id = solicitudes.user_id ';
        $query .= 'where DATE_FORMAT(solicitudes.created_at,"%m%Y") = '.$mesAnio.' ';
        $query .=  ($procede!='')? 'and users.procedencia_id = '.$procede.' ' : '';
        $query .= 'and cancelada = 0 ';
        $query .= 'group by citatorio ';
        $query .= 'order by citatorio asc ';
        $data = DB::select($query);

        // arreglo que contiene dos items las cantidades de 0-citatorios 1-solicitudes
        $arreglo = array();
        // Si no existen los citatorios o las solicitudes, entonces creamos con un valor cero para poder graficar
        $arreglo['0'] = ( array_key_exists('0',$data) )? $data[0]->cantidad: 0; // solicitud normal
        $arreglo['1'] = ( array_key_exists('1',$data) )? $data[1]->cantidad: 0; // solicitud tipo citatorio

        // Colocamos por cada llave (dia) una arreglo con la cantidad de citatorios [0] y solicitudes en [1]
        return $arreglo;
    }

    public function solicitudesAnio()
    {
        // de las Solicitudes, obtenemos los años en un key-value array. ["2017"=>"2017","2108" => "2018"]
        $arreglo = array();
        $query =  'select DISTINCT DATE_FORMAT(solicitudes.created_at, "%Y") as anio from solicitudes ';
        $query .= 'where cancelada=0';
        $data = DB::select($query);
        foreach ($data as $value) {
          $arreglo[$value->anio] = $value->anio;
        }
        return $arreglo;
    }
    public function solicitudesMes($anio)
    {
      // Genera las graficas de solicitudes y citatorios
        $meses = $arreglo = array();
        $meses = ['01'=>'01. Enero','02'=>'02. Febrero','03'=>'03. Marzo','04'=>'04. Abril','05'=>'05. Mayo','06'=>'06. Junio',
                  '07'=>'07. Julio','08'=>'08. Agosto','09'=>'09. Septiembre','10'=>'10. Octubre','11'=>'11. Noviembre','12'=>'12. Diciembre'];

        // de las Solicitudes, obtenemos los meses en un key-value array ['05'=>'05', '06'=>'06']
        $arreglo = array();
        $query =  'select DISTINCT DATE_FORMAT(solicitudes.created_at, "%m") as mes from solicitudes ';
        $query .= 'where cancelada=0 AND ';
        $query .= 'DATE_FORMAT(solicitudes.created_at, "%Y")='.$anio;
        $data = DB::select($query);
        // creamos un arreglo key-value de los meses en los que hay información en solicitudes para un año determinado($anio)
        foreach ($data as $value) {
          // introducimos los valores del mes "02 Febrero" para aquellos meses disponibles en las Solicitudes
           $arreglo[$value->mes] = $meses[$value->mes];
        }
        return $arreglo;
    }
    public function solicitudesOrigen($anio,$mes)
    {
      // de las Solicitudes, obtenemos los procedencias en un key-value array ['100'=>'100 escuela 1']
        $arreglo = array();
        $arreglo['']='Todas las Procedencias';
        $data = DB::table('solicitudes')
                           ->whereRaw('DATE_FORMAT(solicitudes.created_at, "%m")="'.$mes.'"')
                           ->whereRaw('DATE_FORMAT(solicitudes.created_at, "%Y")="'.$anio.'"')
                           ->join('users','solicitudes.user_id','=','users.id')
                           ->join('procedencias','users.procedencia_id','=','procedencias.id')
                           ->selectRaw('DISTINCT procedencias.procedencia')
                           ->orderBy('procedencias.procedencia','ASC')
                           ->GET()->toArray();
         foreach ($data as $value) {
           $arreglo[substr($value->procedencia,0,3)] = $value->procedencia;
         }
         // agregamos un item superior para poder elegir alguna procedencia (o todas si no se elige ninguna)
         return $arreglo;
    }

}
