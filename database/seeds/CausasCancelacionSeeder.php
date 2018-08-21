<?php

use Illuminate\Database\Seeder;
use App\Models\CausasCancelacion;

class CausasCancelacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new CausasCancelacion();
        $table->nombre = "Error al seleccionar carrera del alumno";
        $table->save();

        $table = new CausasCancelacion();
        $table->nombre = "Otro";
        $table->save();
    }
}
