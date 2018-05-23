<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SOAPClient;

class WSController extends Controller
{
    public function trayectorias(){
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('soap.wsdl_cache_ttl', '0');
        ini_set("default_socket_timeout", 5);

        $key = SHA1('He seguido la trayectoria en la que he creido y he confiado en mi mismo / Antonio Saura');
        // parametros de entrada para SOAP
        $cta=request('trayectoria');
        // $cta = '313335127'; // con causa 72
         // $cta = '410060533'; // con causa 72
         // $cta = '308010769'; //Foto
         // $cta = '305016614'; //Fenando
         // $cta = '079332938'; //Guillermo
        // $cta = '081581988'; // defuncion
        // $cta = '414045101'; // expulsion
        // $cta = 317241309; // suspension temporal
        // $cta = '097157782'; // con sede
        // $cta = '096229688'; // normalizada por vigencia
        // $cta = '081360558'; // asignatura en plan nuevo
        // $cta = '300337895'; // cambio de area

        $parametros = array(
          'key' => $key,
          'cta' => $cta
        );

        try {

          $wsdl = 'https://www.dgae-siae.unam.mx/ws/soap/ssre_try_srv.php?wsdl';

          $opts = array(
            'proxy_host' => "132.248.205.1",
            'proxy_port' => 8080,
            //'proxy_login' => 'el_login',
            //'proxy_password' => 'el_password',
            'connection_timeout' => 10 , // tiempo de espera
            'encoding' => 'ISO-8859-1',
            'trace' => true,
            'exceptions' => true
          );
          $client = new SOAPClient($wsdl, $opts);
          // dd($client->__getTypes());
          $response = $client->return_trayectoria($parametros);

        }
        catch (SoapFault $exception) {

            echo "<pre>SoapFault: ".print_r($exception, true)."</pre>\n";
            echo "<pre>faultcode: '".$exception->faultcode."'</pre>";
            echo "<pre>faultstring: '".$exception->getMessage()."'</pre>";
        }
        // return redirect()-route("ruta")->white($response->situaciones);
        return $response->situaciones;
        // dd($response->situaciones[0]->plantel_clave);


    }
    function formatXmlString($xml){
        $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
        $token      = strtok($xml, "\n");
        $result     = '';
        $pad        = 0;
        $matches    = array();
        while ($token !== false) :
            if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
              $indent=0;
            elseif (preg_match('/^<\/\w/', $token, $matches)) :
              $pad--;
              $indent = 0;
            elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
              $indent=1;
            else :
              $indent = 0;
            endif;
            $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
            $result .= $line . "\n";
            $token   = strtok("\n");
            $pad    += $indent;
        endwhile;
        return $result;
    }
}
