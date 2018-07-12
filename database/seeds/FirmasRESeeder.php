<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Firmas;

class FirmasRESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $table = new Firmas();
        $table->firm_cve = '51';
        $table->firm_nombre = 'ANTONIO DIAZ (CAP EMTIT)';
        $table->firm_cargo = 'SUBDIRECTOR';
        $table->firm_cve_capt = 'CDH01';
        $table->firm_nivel = '51';
        $table->firm_ofic = '04';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = '51';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '52';
        $table->firm_nombre = 'LAURA CASTILLO(BAJAS EXP)';
        $table->firm_cargo = 'JEFE DPTO';
        $table->firm_cve_capt = 'CDH01';
        $table->firm_nivel = '52';
        $table->firm_ofic = '04';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = '52';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '53';
        $table->firm_nombre = 'JUANITA RIOS MEND (BORRA FEC ENV A TIT)';
        $table->firm_cargo = 'OFICINISTA';
        $table->firm_cve_capt = 'RMJ01';
        $table->firm_nivel = '53';
        $table->firm_ofic = '05';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = '53';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '54';
        $table->firm_nombre = 'SRA. SUSANA CARRILLO HERNÁNDEZ';
        $table->firm_cargo = 'Jefa del Departamento';
        $table->firm_cve_capt = 'SCH01';
        $table->firm_nivel = NULL;
        $table->firm_ofic = '10';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //1 -----------
        $table->firm_cve1 = '54';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '55';
        $table->firm_nombre = 'DIANA GONZALEZ';
        $table->firm_cargo = 'JEFA TITULOS';
        $table->firm_cve_capt = 'GND01';
        $table->firm_nivel = '55';
        $table->firm_ofic = NULL;
        $table->firm_obs = 'PARA MOD LIBYFOJ2000';
        $table->firm_firma = NULL;
        $table->firm_cve1 = '55';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '56';
        $table->firm_nombre = 'ENRIQUETA LOPEZ';
        $table->firm_cargo = 'OFICINISTA';
        $table->firm_cve_capt = 'LME01';
        $table->firm_nivel = '56';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = '56';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'uhh';
        $table->firm_nombre = 'Lic. Hilda Laura Castillo Díaz';
        $table->firm_cargo = 'Jefa del Departamento de Revisión';
        $table->firm_cve_capt = 'cdefgk';
        $table->firm_nivel = '04';
        $table->firm_ofic = '04';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //2 -------------
        $table->firm_cve1 = 'BOLO10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'vuyhh';
        $table->firm_nombre = 'Lic. Diana González Nieto';
        $table->firm_cargo = 'Jefa del Depto. de Exámenes y Títulos';
        $table->firm_cve_capt = 'cdefgl';
        $table->firm_nivel = '05';
        $table->firm_ofic = '05';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //3 -------------
        $table->firm_cve1 = 'CANC10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'wzhh';
        $table->firm_nombre = 'Sra. Maria de los Angeles Aldama Castro';
        $table->firm_cargo = 'Jefe de Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefgi';
        $table->firm_nivel = '02';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'DZEM10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'y{hh';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'Jefe de Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefgo';
        $table->firm_nivel = '02';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'SEYE10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '}whh';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'Jefe de Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefgp';
        $table->firm_nivel = '02';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'SINA10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '{';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'SUPERVISOR';
        $table->firm_cve_capt = 'SUPERV';
        $table->firm_nivel = '00';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'SUPERV';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 't~hh';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'Jefe de Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefgs';
        $table->firm_nivel = '02';
        $table->firm_ofic = '03';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'AKIL10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '~hh';
        $table->firm_nombre = 'MVZ. Alicia E. Bretón García';
        $table->firm_cargo = 'Jefe del Depto. Serv. Soc. y Exám. Prof.';
        $table->firm_cve_capt = 'cdefgu';
        $table->firm_nivel = '63';
        $table->firm_ofic = '20';
        $table->firm_obs = 'mientras comienza el';
        $table->firm_firma = NULL; //4 -------------
        $table->firm_cve1 = 'TZIN10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '{hh';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'Jefe de Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefgz';
        $table->firm_nivel = '02';
        $table->firm_ofic = NULL;
        $table->firm_obs = 'prueba';
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'PRUE10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'v|hh';
        $table->firm_nombre = 'Lic. Juan Manuel Montiel Rosado';
        $table->firm_cargo = 'Jefa de la Oficina de Revisiones UAP';
        $table->firm_cve_capt = 'cdefgv';
        $table->firm_nivel = '72';
        $table->firm_ofic = 'A';
        $table->firm_obs = 'Autoriza Jua Montiel';
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'CHUM10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'uxwhh';
        $table->firm_nombre = 'Sr. Alfonso Cruz Arroyo';
        $table->firm_cargo = 'Jefa de la Oficina de Revisiones UAP';
        $table->firm_cve_capt = 'cdefgx';
        $table->firm_nivel = '72';
        $table->firm_ofic = 'B';
        $table->firm_obs = 'Autoriza Alfonso';
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'YACA10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '~uhh';
        $table->firm_nombre = 'Lic. Susana Reyes Ortíz';
        $table->firm_cargo = 'Jefe del Dpto. de Rev. de Estudios y Certificacion';
        $table->firm_cve_capt = 'cdefgt';
        $table->firm_nivel = '62';
        $table->firm_ofic = '20';
        $table->firm_obs = 'mientras comienza el';
        $table->firm_firma = NULL; //5 ----------
        $table->firm_cve1 = 'KANT10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'p1';
        $table->firm_nombre = 'Cristina Gómez Esteves';
        $table->firm_cargo = 'Jefa de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefh-';
        $table->firm_nivel = '00';
        $table->firm_ofic = '00';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = '=ýËÊÉÈ';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '~yhh';
        $table->firm_nombre = 'Sra. Maria de los Angeles Aldama Castro';
        $table->firm_cargo = 'Jefa de Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefhb';
        $table->firm_nivel = '02';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'OPIC10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'k~';
        $table->firm_nombre = 'Sra. Maria de los Angeles Aldama Castro';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefhc';
        $table->firm_nivel = NULL;
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //6 --------------
        $table->firm_cve1 = '8WIOPM';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'tkw|j';
        $table->firm_nombre = 'C.P. Agustín Mercado';
        $table->firm_cargo = 'Director de Certificación y Control Documental';
        $table->firm_cve_capt = 'cdefhd';
        $table->firm_nivel = '06';
        $table->firm_ofic = '02';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //7 --------------
        $table->firm_cve1 = 'A7BME2';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'uyh*';
        $table->firm_nombre = 'Dr. Gustavo González Bonilla --cve-yhh';
        $table->firm_cargo = 'Subdirector de Certificación y Control Documental';
        $table->firm_cve_capt = '*defgm';
        $table->firm_nivel = '06';
        $table->firm_ofic = '02';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'YAXC1ò';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'borra2';
        $table->firm_nombre = 'ANTONIO DIAZ (CAP EMTIT)';
        $table->firm_cargo = 'SUBDIRECTOR';
        $table->firm_cve_capt = 'DGA01';
        $table->firm_nivel = '50';
        $table->firm_ofic = '09';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //8 --------------
        $table->firm_cve1 = '/;=<*ú';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '58';
        $table->firm_nombre = 'Lic. Susana Reyes Ortíz';
        $table->firm_cargo = 'Jefe del Dpto. de Rev. de Estudios y Certificacion';
        $table->firm_cve_capt = 'cdefgq';
        $table->firm_nivel = NULL;
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //9 -----------
        $table->firm_cve1 = '58';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '59';
        $table->firm_nombre = 'Lic. Lourdes García Quinto';
        $table->firm_cargo = 'Jefe del Depto. Serv. Soc. y Exám. Prof.';
        $table->firm_cve_capt = 'cdefgr';
        $table->firm_nivel = NULL;
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //10 -----------
        $table->firm_cve1 = '59';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'vuwim';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'Jefe se Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefhg';
        $table->firm_nivel = '02';
        $table->firm_ofic = '08';
        $table->firm_obs = 'para norma hernandez';
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'CASA25';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '60';
        $table->firm_nombre = 'Lic. Graciela Robles Rodriguez';
        $table->firm_cargo = 'Jefa del Dpto.de Rev.de Estudios y Certificación';
        $table->firm_cve_capt = 'cdefhe';
        $table->firm_nivel = '00';
        $table->firm_ofic = '20';
        $table->firm_obs = '30/06/2008';
        $table->firm_firma = NULL; //11 ------------
        $table->firm_cve1 = '60';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'w}ik';
        $table->firm_nombre = NULL;
        $table->firm_cargo = 'Jefe se Sección de Revisión de Estudios';
        $table->firm_cve_capt = 'cdefgi';
        $table->firm_nivel = '02';
        $table->firm_ofic = NULL;
        $table->firm_obs = '19/03/2013';
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'DILI23';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '|?x?WX';
        $table->firm_nombre = 'Jose Luis Vazquez Rodriguez';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefgj';
        $table->firm_nivel = NULL;
        $table->firm_ofic = NULL;
        $table->firm_obs = 'provisional incapaci';
        $table->firm_firma = NULL; //12 -----------------
        $table->firm_cve1 = NULL;
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '{?~?hk';
        $table->firm_nombre = 'Guadalupe Navarrete Romero';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefia';
        $table->firm_nivel = '03';
        $table->firm_ofic = '03';
        $table->firm_obs = 'solicitada por laura';
        $table->firm_firma = NULL; //13 -------------
        $table->firm_cve1 = 'HPIM13';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '61';
        $table->firm_nombre = 'Lic. Jesús Javier Cruz Velazquez';
        $table->firm_cargo = 'Jefe del Dpto. de Rev. de Estudios y Certificación';
        $table->firm_cve_capt = 'cdefgh';
        $table->firm_nivel = NULL;
        $table->firm_ofic = '20';
        $table->firm_obs = 'sustituido x maribel';
        $table->firm_firma = NULL; //14 ---------------
        $table->firm_cve1 = 'UNAM18';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'y}zf??';
        $table->firm_nombre = 'Guadalupe Navarrete Romero';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefic';
        $table->firm_nivel = '03';
        $table->firm_ofic = '08';
        $table->firm_obs = 'temp x defuncion jl';
        $table->firm_firma = NULL; //15 ------------
        $table->firm_cve1 = 'FIE0SH';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '?lhWX';
        $table->firm_nombre = 'Maria Ines Lara Izaguirre';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefid';
        $table->firm_nivel = NULL;
        $table->firm_ofic = '08';
        $table->firm_obs = 'Solicitado por Agust';
        $table->firm_firma = NULL; //16 ---------
        $table->firm_cve1 = NULL;
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'wv?d?}';
        $table->firm_nombre = 'Lic. Maribel Landero Diaz';
        $table->firm_cargo = 'Jefa del Dpto. de Rev. de Estudios y Certificación';
        $table->firm_cve_capt = 'cdefib';
        $table->firm_nivel = NULL;
        $table->firm_ofic = '20';
        $table->firm_obs = 'Oficio dgire 2015052';
        $table->firm_firma = NULL; //17 -------------
        $table->firm_cve1 = 'CHOO3E';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'vuhj';
        $table->firm_nombre = 'Lic. Susana Reyes Ortíz';
        $table->firm_cargo = 'Jefa del Depto. Serv. Soc. y Titulación';
        $table->firm_cve_capt = 'cdefhf';
        $table->firm_nivel = NULL;
        $table->firm_ofic = '20';
        $table->firm_obs = '30/06/2008';
        $table->firm_firma = NULL; //18 ---------
        $table->firm_cve1 = 'CALI12';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'jjWX';
        $table->firm_nombre = 'Lic. Maribel Landero Díaz';
        $table->firm_cargo = 'Jefa del Dpto. Serv. Soc. y Titulación';
        $table->firm_cve_capt = 'cdefie';
        $table->firm_nivel = '46';
        $table->firm_ofic = '20';
        $table->firm_obs = 'Oficio DGIR/096/2016';
        $table->firm_firma = NULL; //19 ------------
        $table->firm_cve1 = 'LM54';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = 'nkd~o';
        $table->firm_nombre = 'José Luis Vázquez Rodríguez';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefgn';
        $table->firm_nivel = '03';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'TIXM10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '888â';
        $table->firm_nombre = 'José Luis Vázquez Rodríguez';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefha';
        $table->firm_nivel = '03';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'HUEU10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '#$%&ò';
        $table->firm_nombre = 'José Luis Vázquez Rodríguez';
        $table->firm_cargo = 'Jefe de la Oficina de Revisiones';
        $table->firm_cve_capt = 'cdefgj';
        $table->firm_nivel = '03';
        $table->firm_ofic = NULL;
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'CHIC10';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '?kmWX';
        $table->firm_nombre = 'Lic. Mario Mendoza Guzmán';
        $table->firm_cargo = 'Jefe del Dpto de Rev. de Estudios y Certificación';
        $table->firm_cve_capt = 'cdefif';
        $table->firm_nivel = NULL;
        $table->firm_ofic = '20';
        $table->firm_obs = 'Oficio DGIR/096/2016';
        $table->firm_firma = NULL; //20 -----------
        $table->firm_cve1 = 'MM67';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '??znh?';
        $table->firm_nombre = 'MVZ Alicia Edith Bretón García';
        $table->firm_cargo = 'Jefa del Dpto. de Rev. de Estudios y Certificación';
        $table->firm_cve_capt = 'cdefig';
        $table->firm_nivel = '43';
        $table->firm_ofic = '20';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL; //21 --------
        $table->firm_cve1 = 'TPE81S';
        $table->save();

        $table = new Firmas();
        $table->firm_cve = '100';
        $table->firm_nombre = 'Joshuah Dickens';
        $table->firm_cargo = 'PRUEBA';
        $table->firm_cve_capt = 'abcde';
        $table->firm_nivel = '10';
        $table->firm_ofic = '10';
        $table->firm_obs = NULL;
        $table->firm_firma = NULL;
        $table->firm_cve1 = 'PRUE10';
        $table->save();

    }
}
