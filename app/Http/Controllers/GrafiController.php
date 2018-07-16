<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedencia;
use DB;

class GrafiController extends Controller
{
    //
    public function diario(){

       $paraMes = 6;
       $anio = 2018;
       $paraProc = 4;

       $meses = array();
       $meses = ['01'=>'01. Enero','02'=>'02. Febrero','03'=>'03. Marzo','04'=>'04. Abril','05'=>'05. Mayo','06'=>'06. Junio',
                 '07'=>'07. Julio','08'=>'08. Agosto','09'=>'09. Septiembre','10'=>'10. Octubre','11'=>'11. Noviembre','12'=>'12. Diciembre'];

       $mes = $meses[str_pad($paraMes,2,'0',STR_PAD_LEFT)];
       $procedencia = Procedencia::find($paraProc)->procedencia;

       // Grafico con filtro de procedencia
       $chart1 = $this->barraGrafico($paraMes,$anio,$paraProc,'Particular');
       // Grafico sin filtro de procedencia.
       $chart2 = $this->barraGrafico($paraMes,$anio,null,'General');

        // Renderizamos en la vista.
        return view('graficas/example', compact('chart1','chart2','procedencia','mes','anio'));
    }

    public function barraGrafico($paraMes,$anio,$paraProc,$nombreGraf){
      // Generamos el grafico a partir de los datos

      // $arreglo contiene los datos de la consulta en arrenglo de llave-pair
      $arreglo = $this->dataProcede($paraMes,$anio,$paraProc);
      // El $arreglo se pasa a tres arreglos uno de etiquetas (dias de mes), otro de Solicitudes ($data1) y Citatorios ($data2)
      $lables = $data1 = $data2 = array();
      foreach ($arreglo as $key => $value) {
        array_push($lables,$key);
        array_push($data1,$value[0]);
        array_push($data2,$value[1]);
      }
      // Componemos el arreglo para el gráfico con etiquetas y datos
      $chart = $this->diarioGrafico($lables,$data1,$data2,$nombreGraf);

      return $chart;
    }

    public function diarioGrafico($lables,$data1,$data2,$nombreGraf){
      // grafico de barras de 2 conjuntos de datos

      $chartjs = app()->chartjs
        ->name($nombreGraf)
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($lables)
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

        return $chartjs;
    }

    public function dataProcede($mes,$anio,$procede){
       // consultas diarias de solicitudes y citatorios.

       // Año y mes para filtrar la consulta.
        $mesAnio = "'".str_pad($mes,2,0,STR_PAD_LEFT).$anio."'";

        $query =  'select DATE_FORMAT(solicitudes.created_at, "%d") as dia, ';
        $query .=  'citatorio, ';
        $query .= 'count(*) as cantidad ';
        $query .= 'from solicitudes inner join users on users.id = solicitudes.user_id ';
        $query .= 'where DATE_FORMAT(solicitudes.created_at,"%m%Y") = '.$mesAnio.' ';
        $query .=  ($procede!=null)? 'and users.procedencia_id = '.$procede.' ' : '';
        $query .= 'and cancelada = 0 ';
        $query .= 'group by citatorio, dia ';
        $query .= 'order by dia asc ';
        $data = DB::select($query);

        // mapeamos la consulta a una arreglo de dia=>[cantidad de solicitudes, cantidad de citatorios.]

        // arreglo que contiene las cantidades de 0-citatorios 1-solicitudes
        $arreglo = array(); $tipo = [0,0];
        // Colocamos por cada llave (dia) una arreglo con la cantidad de citatorios [0] y solicitudes en [1]
        foreach ($data as $value) {
          if (array_key_exists($value->dia,$arreglo)) {
            $arreglo[$value->dia][$value->citatorio] = $value->cantidad;
          } else {
            $arreglo[$value->dia] = $tipo;
            $arreglo[$value->dia][$value->citatorio] = $value->cantidad;
          }
        }
        return $arreglo;
    }
}
