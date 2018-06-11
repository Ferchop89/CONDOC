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

        // $key = SHA1('He seguido la trayectoria en la que he creido y he confiado en mi mismo / Antonio Saura');
        // $key = SHA1('Nadie puede definir tu identidad, tu personalidad. Al fin y al cabo cada uno es responsable de qui?n y como es / Chinogizbo');
        // echo "<pre>";
        // var_dump($key);
        // echo "</pre>";
        $key = iconv("UTF-8//TRANSLIT", "WINDOWS-1252", $key);

        $key=SHA1($key);
        // echo "<pre>";
        // var_dump($key);
        // echo "</pre>";
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
