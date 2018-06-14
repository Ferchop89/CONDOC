<?php

use Illuminate\Database\Seeder;
use App\Models\IrregularidadesRE as IRE;

class IrregularidadesRESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 1;
        $table->cat_nombre = 'SIN IRREGULARIDADES';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 2;
        $table->cat_nombre = 'FALTA ACTA DE NACIMIENTO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 3;
        $table->cat_nombre = 'FECHA DE NACIMIENTO INCOMPLETA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 4;
        $table->cat_nombre = 'FECHA DE REGISTRO INCOMPLETA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 5;
        $table->cat_nombre = 'REGISTRO EXTEMPORANEO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 6;
        $table->cat_nombre = 'SE REGISTRO ANTES DE NACER';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 7;
        $table->cat_nombre = 'FALTAN DATOS DEL PADRE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 8;
        $table->cat_nombre = 'FALTA EL SEGUNDO APELLIDO DEL LA MADRE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 9;
        $table->cat_nombre = 'FALTA OFICIO DE REGISTRO EXTEMPORANEO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 10;
        $table->cat_nombre = 'PRESENTAR ACTA NAC DIRECTA DEL LIBRO REG';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 11;
        $table->cat_nombre = 'FALTA LEGALIZ ACT NAC ANTE EMBAJ DE PAIS';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 12;
        $table->cat_nombre = 'REGISTRADO EN EXTRANJERO PADRES MEXICANO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 13;
        $table->cat_nombre = 'ENMENDADURA EN NOMBRE O NOMBRES';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 14;
        $table->cat_nombre = 'ENMENDADURA EN APELLIDO PATERNO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 15;
        $table->cat_nombre = 'ENMENDADURA EN APELLIDO MATERNO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 16;
        $table->cat_nombre = 'ENMENDADURA EN FECHA DE REGISTRO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 17;
        $table->cat_nombre = 'ENMENDADURA EN FECHA DE NACIMIENTO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 18;
        $table->cat_nombre = 'ENMENDADURA EN APELLIDO DEL PADRE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 19;
        $table->cat_nombre = 'ENMENDADURA EN APELLIDO DE LA MADRE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 20;
        $table->cat_nombre = 'FALTA TRADUCCION AL ESPAÑOL';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 22;
        $table->cat_nombre = 'NOM ALUMNO EN ACTA DIF DE ANOTA MARGINAL';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 23;
        $table->cat_nombre = 'NO TIENE SELLO DEL JUZGADO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 24;
        $table->cat_nombre = 'NO TIENE FIRMA DEL JUEZ';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 25;
        $table->cat_nombre = 'ACTA MUTILADA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 26;
        $table->cat_nombre = 'FALTA COPIA DIRECTA DEL LIBRO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 27;
        $table->cat_nombre = 'ORIGINAL Y 2 COPIAS DEL ACTA NACIMIENTO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 41;
        $table->cat_nombre = 'REQ ACTA CON TRADUC OF AL IDIOMA ESPAÑOL';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 42;
        $table->cat_nombre = 'REQ ACTA APOSTILLADA POR EMBAJADA DE MÉX';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 1;
        $table->cat_subcve = 98;
        $table->cat_nombre = 'REPORTA OTRA CURP';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 1;
        $table->cat_nombre = 'SIN IRREGULARIDADES';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 2;
        $table->cat_nombre = 'FALTA CERTIFICADO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 3;
        $table->cat_nombre = 'FALTA LEGALIZACION GOBIERNO DEL ESTADO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 4;
        $table->cat_nombre = 'CLAVE ESCUELA INCOMPLETA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 5;
        $table->cat_nombre = 'CLAVE EDUCACION TECNOLOGICA INCOMPLETA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 6;
        $table->cat_nombre = 'INCOMPLETA Y SIN CLAVE DE LENGUA EXTRANG';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 7;
        $table->cat_nombre = 'OMISION DE LUGAR Y/O FECHA DE EXPEDICIO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 8;
        $table->cat_nombre = 'OMISION DEL NOMBRE DEL DIRECTOR';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 9;
        $table->cat_nombre = 'OMISION DE LA FIRMA DEL DIRECTOR';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 10;
        $table->cat_nombre = 'OMISION SELLO PARA CANCELAR FOTOGRAFIA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 11;
        $table->cat_nombre = 'SELLO ENCIMADO, MANCHADO, INCOMPLETO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 12;
        $table->cat_nombre = 'FOLIOS NEGRO Y ROJO DIFERENTES';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 13;
        $table->cat_nombre = 'DOCUMEN MANCHADO, CON ENMENDADURAS, ROTO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 14;
        $table->cat_nombre = 'NOMBRE DIFERENTE AL ACTA DE NACIMIENTO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 15;
        $table->cat_nombre = 'FALTA CIERRE KARDEX, ESPERA DE INF AREA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 16;
        $table->cat_nombre = 'EN ESPERA DE INFORMACIO POR PARTE DE SEP';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 17;
        $table->cat_nombre = 'GRADOS CON EQUIVALENCIA O REVALIDADOS';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 18;
        $table->cat_nombre = 'DE ESCUELAS INCORPORADAS A LA UNAM';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 19;
        $table->cat_nombre = 'CERTIFICADO ENMICADO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 20;
        $table->cat_nombre = 'NO VALIDADO POR DICTAMENES';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 21;
        $table->cat_nombre = 'NO REVALIDADO POR DGIRE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 22;
        $table->cat_nombre = 'SIN FECHA DE EXPEDICION';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 23;
        $table->cat_nombre = 'FALTA CIERRE DE KARDEX';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 24;
        $table->cat_nombre = 'FALTA OFICIO DE REVALIDACIÓN';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 2;
        $table->cat_subcve = 25;
        $table->cat_nombre = 'BAJO PROMEDIO';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 1;
        $table->cat_nombre = 'SIN IRREGULARIDADES';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 2;
        $table->cat_nombre = 'SIN 100% CREDITOS';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 3;
        $table->cat_nombre = 'ASIG POSTERIOR';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 4;
        $table->cat_nombre = 'ART. 19';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 5;
        $table->cat_nombre = 'SIN REV O CON';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 6;
        $table->cat_nombre = 'NO ESTA CERRADA';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 7;
        $table->cat_nombre = 'ERROR EN NOMBRE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 8;
        $table->cat_nombre = 'ERROR EN NO. EXPEDIENTE';
        $table->cat_nombre1 = '';
        $table->save();

        $table = new IRE();
        $table->cat_cve = 3;
        $table->cat_subcve = 9;
        $table->cat_nombre = 'ERROR EN CLAVES';
        $table->cat_nombre1 = '';
        $table->save();
    }
}
