<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SOAPClient;

class WSController extends Controller
{
    public function ws($nombre, $num_cta, $key)
    {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('soap.wsdl_cache_ttl', '0');
        ini_set("default_socket_timeout", 5);

        //$key = SHA1('He seguido la trayectoria en la que he creido y he confiado en mi mismo / Antonio Saura');
        // parametros de entrada para SOAP
        // $cta=request('trayectoria');
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

        $key = iconv("UTF-8//TRANSLIT", "WINDOWS-1252", $key);

        $key=SHA1($key);

        $parametros = array(
          'key' => $key,
          'cta' => $num_cta
        );

        try {
            if($nombre == 'trayectoria')
                $wsdl = 'https://www.dgae-siae.unam.mx/ws/soap/ssre_try_srv.php?wsdl';
            elseif ($nombre == 'identidad') {
                $wsdl = 'https://www.dgae-siae.unam.mx/ws/soap/dgae_idn_srv.php?wsdl';
          }
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
          if($nombre == 'trayectoria')
          {
              $response = $client->return_trayectoria($parametros);
          }
          elseif ($nombre ==  'identidad') {
              $response = $client->return_identidad($parametros);
          }
        }
        catch (SoapFault $exception) {

            echo "<pre>SoapFault: ".print_r($exception, true)."</pre>\n";
            echo "<pre>faultcode: '".$exception->faultcode."'</pre>";
            echo "<pre>faultstring: '".$exception->getMessage()."'</pre>";
        }
        if(empty($response->cuenta))
        {
            return $response->mensaje;
        }
        return $response;
    }
}
