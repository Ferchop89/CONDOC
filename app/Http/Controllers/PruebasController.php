<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class PruebasController extends Controller
{
    public function prueba(){
        return view('/pruebas/menu_prueba');
    }
}
