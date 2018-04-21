<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformesController extends Controller
{
  public function revisiones()
  {
    return view('consultas.solicitud_rs');
  }
}
