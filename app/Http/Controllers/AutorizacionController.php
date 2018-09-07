<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AutorizacionController extends Controller
{
    public function showATI()
    {
      $hoy = Carbon::now()->format("d/m/Y");

      $day = substr($hoy, 0, 2);
      $month = substr($hoy, 3, 2);
      $year = substr($hoy, 6, 4);
      $fecha = Carbon::create($year, $month, $day);
      $day = $fecha->formatLocalized('%d');
      $month = $fecha->formatLocalized('%B');
      $year = $fecha->formatLocalized('%Y');

      return view('/autorizacion_t_info')->with(compact('day', 'month', 'year'));
    }

    public function postATI(Request $request){

      $request->validate([
          'nombre' => 'required',
          'curp' => 'required|min:18|max:18|regex:/^[A-Z]{4}[0-9]{2}[0-1][0-9][0-9]{2}[M,H][A-Z]{5}[0-9]{2}$/',
          'num_tel' => 'required|numeric',
          'num_cel' => 'required|numeric|digits:10',
          'correo' => 'required|email',
          'acepto' => 'required'
          ],[
           'nombre.required' => 'Debes proporcionar tu nombre completo',
           'curp.required' => 'Debes proporcionar tu CURP',
           'curp.min' => 'El CURP debe ser de 18 caracteres.',
           'curp.max' => 'El CURP debe ser de 18 caracteres.',
           'curp.regex' => 'El formato de CURP es incorrecto',
           'num_tel.required' => 'Debes proporcionar tu número de teléfono fijo',
           'num_tel.numeric' => 'El número de teléfono fijo deben ser solo dígitos',
           'num_cel.required' => 'Debes proporcionar tu número de teléfono celular',
           'num_cel.numeric' => 'El número de teléfono celular deben ser solo dígitos',
           'num_cel.digits' => 'El número de teléfono celular deben ser de 10 dígitos',
           'correo.required' => 'Debes proporcionar tu correo electrónico',
           'correo.email' => 'El correo electrónico no tiene el formato correcto',
           'acepto.required' => 'Debes aceptar lo notificado'
      ]);

      $nombre = $_POST['nombre'];
      $curp = $_POST['curp'];
      $num_tel = $_POST['num_tel'];
      $num_cel = $_POST['num_cel'];
      $correo = $_POST['correo'];
      $acepto = $_POST['acepto']; //on

      dd($acepto);

    }
}
