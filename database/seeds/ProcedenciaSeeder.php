<?php

use Illuminate\Database\Seeder;
use App\Models\Procedencia;

class ProcedenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // El primer registro de procedencia es UNAM
        // $procede =    new Procedencia();
        // $procede->procedencia = 'UNAM';
        // $procede->save();

        // oficinas
        $procede = new Procedencia();
        $procede->id = 1001; $procede->procedencia = 'DEPTO. REVISIÓN DE ESTUDIOS';
        $procede->responsabilidad = 'DGAE';
        $procede->save();

        $procede = new Procedencia();
        $procede->id = 1 ; $procede->procedencia = '001 ARQUITECTURA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 2 ; $procede->procedencia = '002 ARTES Y DISEÑO';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 4 ; $procede->procedencia = '004 CIENCIAS POLÍTICAS Y SOCIALES';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 5 ; $procede->procedencia = '005 QUÍMICA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 6 ; $procede->procedencia = '006 CONTADURÍA Y ADMINISTRACIÓN';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 8 ; $procede->procedencia = '008 ECONOMIA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 10  ; $procede->procedencia = '010 FILOSOFÍA Y LETRAS';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 14 ; $procede->procedencia = '014 ODONTOLOGÍA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 16 ; $procede->procedencia = '016 VETERINARIA Y ZOOTÉCNIA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 300 ; $procede->procedencia = '300 IZTACALA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 400 ; $procede->procedencia = '400 ARAGÓN';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 91 ; $procede->procedencia = '091 ENSENADA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 95 ; $procede->procedencia = '095 JURIQUILLA';
        $procede->responsabilidad = 'OFICINA 03';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 3 ; $procede->procedencia = '003 CIENCIAS';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 7 ; $procede->procedencia = '007 DERECHO';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 9 ; $procede->procedencia = '009 ENFERMERÍA Y OBSTETRÍCIA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 11 ; $procede->procedencia = '011 INGENIERÍA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 12 ; $procede->procedencia = '012 MEDICINA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 13 ; $procede->procedencia = '013 MÚSICA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 15 ; $procede->procedencia = '015 TRABAJO SOCIAL';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 19 ; $procede->procedencia = '019 PSICOLOGÍA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 100 ; $procede->procedencia = '100 CUATITLÁN';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 200 ; $procede->procedencia = '200 ACATLÁN';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 500 ; $procede->procedencia = '500 ZARAGOZA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 600 ; $procede->procedencia = '600 LEÓN';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 700 ; $procede->procedencia = '700 MORELIA';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 55 ; $procede->procedencia = '055 GENÓMICAS';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();
        $procede = new Procedencia();
        $procede->id = 90 ; $procede->procedencia = '090 TEMIXCO';
        $procede->responsabilidad = 'OFICINA 08';
        $procede->save();

        // Registros de procedencia Facultad o Escuela
        // factory(Procedencia::class,19)->create();
    }
}
