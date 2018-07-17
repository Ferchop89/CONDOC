<?php

use Illuminate\Database\Seeder;
use App\Models\Niveles;

class NivelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new Niveles();
        $table->id_nivel = 'B';
        $table->nombre_nivel = 'BACHILLERATO';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'D';
        $table->nombre_nivel = 'DOCTORADO';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'E';
        $table->nombre_nivel = 'ESPECIALIDAD';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'I';
        $table->nombre_nivel = 'INICIACIÓN UNIVERSITARIA';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'L';
        $table->nombre_nivel = 'LICENCIATURA';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'M';
        $table->nombre_nivel = 'MAESTRÍA';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'S';
        $table->nombre_nivel = 'SECUNDARIA';
        $table->save();

        $table = new Niveles();
        $table->id_nivel = 'T';
        $table->nombre_nivel = 'TÉCNICO';
        $table->save();
    }
}
