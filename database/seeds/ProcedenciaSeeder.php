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
        // oficinas
        $procede = new Procedencia();
        $procede->id = 1001; $procede->procedencia = 'DEPTO. REVISIÓN DE ESTUDIOS';
        $procede->responsabilidad = 'DGAE';
        $procede->save();
        // Cargamos todas las procedencias de los catalogos de resplado y valores de inicio.
        $planteles = $this->plantel();
        foreach ($planteles as $key => $value) {
          $procede = new Procedencia();
          $procede->id = $key;
          $procede->procedencia = $value;
          $procede->responsabilidad = 'N.E. '.STR_PAD($key,3-STRLEN($key),'0',STR_PAD_LEFT);
          $procede->save();
        } // str_pad($value,8,'0',STR_PAD_LEFT)
        // Actualizamos los numeros de oficina que atiende cada plantel.
        // oficina 03
        $procede = Procedencia::find(1);    $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(2);    $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(4);    $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(5);    $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(6);    $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(8);    $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(10);   $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(14);   $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(16);   $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(300);  $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(400);  $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(91);   $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        $procede = Procedencia::find(95);   $procede->responsabilidad = 'OFICINA 03'; $procede->update();
        // oficina 08
        $procede = Procedencia::find(3);    $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(7);    $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(9);    $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(11);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(12);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(13);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(15);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(19);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(100);  $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(200);  $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(500);  $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(600);  $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(700);  $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(55);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
        $procede = Procedencia::find(90);   $procede->responsabilidad = 'OFICINA 08'; $procede->update();
    }
    // Arreglo de Planteles
    public function plantel()
    {
      $planteles = array();
      $planteles['1'] = '001 FACULTAD de ARQUITECTURA';
      $planteles['2'] = '002 FACULTAD de ARTES Y DISEÑO';
      $planteles['3'] = '003 FACULTAD de CIENCIAS';
      $planteles['4'] = '004 FACULTAD de CIENCIAS POLÍTICAS Y SOCIALES';
      $planteles['5'] = '005 FACULTAD de QUIMICA';
      $planteles['6'] = '006 FACULTAD de CONTADURÍA Y ADMINISTRACIÓN';
      $planteles['7'] = '007 FACULTAD de DERECHO';
      $planteles['8'] = '008 FACULTAD de ECONOMÍA';
      $planteles['9'] = '009 ESCUELA NACIONAL DE ENFERMERIA Y OBSTETRICIA';
      $planteles['10'] = '010 FACULTAD de FILOSOFIA Y LETRAS';
      $planteles['11'] = '011 FACULTAD de INGENIERÍA';
      $planteles['12'] = '012 FACULTAD de MEDICINA';
      $planteles['13'] = '013 FACULTAD de MUSICA';
      $planteles['14'] = '014 FACULTAD de ODONTOLOGÍA';
      $planteles['15'] = '015 ESCUELA NACIONAL DE TRABAJO SOLICIAL';
      $planteles['16'] = '016 FACULTAD DE MEDICINA, VETERINARIA Y ZOOTECNIA';
      // $planteles['17'] = '017 FACULTAD de Medicina Veterinaria y Zootecnia';
      $planteles['19'] = '019 FACULTAD DE PSICOLOGÍA';
      $planteles['20'] = '020 DIRECCIÓN GENERAL ESCUELA NACIONAL PREPARATORIA';
      $planteles['21'] = '021 ESCUELA NACIONAL PREPARATORIA 1';
      $planteles['22'] = '022 ESCUELA NACIONAL PREPARATORIA 2';
      $planteles['23'] = '023 ESCUELA NACIONAL PREPARATORIA 3';
      $planteles['24'] = '024 ESCUELA NACIONAL PREPARATORIA 4';
      $planteles['25'] = '025 ESCUELA NACIONAL PREPARATORIA 5';
      $planteles['26'] = '026 ESCUELA NACIONAL PREPARATORIA 6';
      $planteles['27'] = '027 ESCUELA NACIONAL PREPARATORIA 7';
      $planteles['28'] = '028 ESCUELA NACIONAL PREPARATORIA 8';
      $planteles['29'] = '029 ESCUELA NACIONAL PREPARATORIA 9';
      $planteles['30'] = '030 UACPYP';
      $planteles['31'] = '031 CCH Atzcapozalco';
      $planteles['32'] = '032 CCH Naucalpan';
      $planteles['33'] = '033 CCH Vallejo';
      $planteles['34'] = '034 CCH Oriente';
      $planteles['35'] = '035 CCH Sur';
      $planteles['39'] = '039 Unidad Académica del Ciclo de Bachillerato del CCH';
      $planteles['46'] = '046 Bachillerato Abierto y a distancia';
      $planteles['51'] = '051 CENTRO de CIENCIAS de LA ATMOSFERA';
      $planteles['52'] = '052 CENTRO de ESTUDIO SOBRE LA UNIVERSIDAD';
      $planteles['53'] = '053 CENTRO de INSTRUMENTOS';
      $planteles['54'] = '054 CENTRO de INVEST. HUMANISTICAS de MESOAMERICA Y EL';
      $planteles['55'] = '055 CENTRO de CIENCIAS GENOMICAS';
      $planteles['56'] = '056 CENTRO de INVESTIGACIONES SOBRE AMERICA deL NORTE';
      $planteles['57'] = '057 CENTRO de INVESTIGACIONES Y SERVICIOS MUSEOLOGICOS';
      $planteles['58'] = '058 CENTRO de INVEST. INTERDISCIPLINARIAS EN CIENCIAS';
      $planteles['59'] = '059 CENTRO de NEUROBIOLOGIA';
      $planteles['60'] = '060 CENTRO REGIONAL de INVESTIGACIONES MULTIDISCIPLINA';
      $planteles['61'] = '061 CENTRO UNIVERSITARIO de ESTUDIOS CINEMATOGRAFICOS';
      $planteles['62'] = '062 CENTRO UNIVERSITARIO de INVESTIGACIONES BIBLIOTECO';
      $planteles['63'] = '063 CENTRO UNIVERSITARIO de TEATRO';
      $planteles['64'] = '064 INSTITUTO de ASTRONOMIA';
      $planteles['65'] = '065 INSTITUTO de BIOLOGIA';
      $planteles['66'] = '066 INSTITUTO de BIOTECNOLOGIA';
      $planteles['67'] = '067 INSTITUTO de CIENCIAS deL MAR Y LIMNOLOGIA';
      $planteles['68'] = '068 INSTITUTO de CIENCIAS NUCLEARES';
      $planteles['69'] = '069 INSTITUTO de ECOLOGIA';
      $planteles['70'] = '070 INSTITUTO de FISICA';
      $planteles['71'] = '071 INSTITUTO de FISIOLOGIA CELULAR';
      $planteles['72'] = '072 INSTITUTO de GEOFISICA';
      $planteles['73'] = '073 INSTITUTO de GEOGRAFIA';
      $planteles['74'] = '074 INSTITUTO de GEOLOGIA';
      $planteles['75'] = '075 INSTITUTO de INGENIERIA';
      $planteles['76'] = '076 INSTITUTO de INVESTIGACIONES ANTROPOLOGICAS';
      $planteles['77'] = '077 INSTITUTO de INVESTIGACIONES BIBLIOGRAFICAS';
      $planteles['78'] = '078 INSTITUTO de INVESTIGACIONES BIOMEDICAS';
      $planteles['79'] = '079 INSTITUTO de INVESTIGACIONES ECONOMICAS';
      $planteles['80'] = '080 INSTITUTO de INVESTIGACIONES EN MATEMATICAS APL Y';
      $planteles['81'] = '081 INSTITUTO de INVESTIGACIONES EN MATERIALES';
      $planteles['82'] = '082 INSTITUTO de INVESTIGACIONES ESTETICAS';
      $planteles['83'] = '083 INSTITUTO de INVESTIGACIONES FILOLOGICAS';
      $planteles['84'] = '084 INSTITUTO de INVESTIGACIONES FILOSOFICAS';
      $planteles['85'] = '085 INSTITUTO de INVESTIGACIONES HISTORICAS';
      $planteles['86'] = '086 INSTITUTO de INVESTIGACIONES JURIDICAS';
      $planteles['87'] = '087 INSTITUTO de INVESTIGACIONES SOCIALES';
      $planteles['88'] = '088 INSTITUTO de MATEMATICAS';
      $planteles['89'] = '089 INSTITUTO de QUIMICA';
      $planteles['90'] = '090 INSTITUTO DE ENERGIAS RENOVABLES (TEMIXCO)';
      $planteles['91'] = '091 CENTRO DE NANOCIENCIAS Y NANOTECNOLOGIA';
      $planteles['92'] = '092 CENTRO de CIENCIAS FISICA';
      $planteles['93'] = '093 CENTRO COORDINADOR Y DIFUSOR de ESTUDIOS LATINOAME';
      $planteles['94'] = '094 CENTRO PEN EN HUM Y CIENCIAS  SOC MERIDA YUCATAN';
      $planteles['95'] = '095 CENTRO DE FISICA APLICADA Y TEC AVANZADA';
      $planteles['96'] = '096 CENTRO DE GEOCIENCIAS';
      $planteles['97'] = '097 CENTRO DE INVESTIGACIONES EN ECOSISTEMAS';
      $planteles['98'] = '098 CENTRO DE RADIOASTRONOMÍA Y ASTROFÍSICA';
      $planteles['99'] = '099 CENTRO DE INVESTIGACIÓN EN GEOGRAFÍA AMBIENTAL';
      $planteles['100'] = '100 FES. Cuautitlán';
      $planteles['102'] = '102 FES CUAUTITLAN';
      $planteles['105'] = '105 FES CUAUTITLAN (QUIMICAS)';
      $planteles['106'] = '106 FES CUAUTITLAN (CONTADURIA)';
      $planteles['111'] = '111 FES CUAUTITLAN (INGENIERIA)';
      $planteles['116'] = '116 FES CUAUTITLAN (VETERINARIA)';
      $planteles['118'] = '118 FES CUAUTITLAN (AGRICOLA)';
      $planteles['195'] = '195 FES CUAUTITLAN';
      $planteles['200'] = '200 FES Acatlán';
      $planteles['201'] = '201 FES ACATLAN (ARQUITECTURA)';
      $planteles['202'] = '202 FES ACATLAN';
      $planteles['203'] = '203 FES ACATLAN (CIENCIAS)';
      $planteles['204'] = '204 FES ACATLAN (CIENCIAS POLITICAS)';
      $planteles['207'] = '207 FES ACATLAN (DERECHO)';
      $planteles['208'] = '208 FES ACATLAN (ECONOMIA)';
      $planteles['210'] = '210 FES ACATLAN (FILOSOFIA)';
      $planteles['211'] = '211 FES ACATLAN (INGENIERIA)';
      $planteles['240'] = '240 FES ACATLAN (COMPUTACION)';
      $planteles['241'] = '241 FES ACATLAN (IDIOMAS)';
      $planteles['243'] = '243 FES ACATLAN (LENGUA EXTRANJERA)';
      $planteles['300'] = '300 FES Iztacala';
      $planteles['303'] = '303 FES IZTACALA (CIENCIAS)';
      $planteles['309'] = '309 FES IZTACALA (ENFERMERIA)';
      $planteles['312'] = '312 FES IZTACALA (MEDICINA)';
      $planteles['314'] = '314 FES IZTACALA (ODONTOLOGIA)';
      $planteles['319'] = '319 FES IZTACALA (PSICOLOGIA)';
      $planteles['342'] = '342 FES IZTACALA';
      $planteles['400'] = '400 FES. Aragón';
      $planteles['401'] = '401 FES ARAGON (ARQUITECTURA)';
      $planteles['404'] = '404 FES ARAGON (CIENCIAS POLITICAS)';
      $planteles['407'] = '407 FES ARAGON (DERECHO)';
      $planteles['408'] = '408 FES ARAGON (ECONOMIA)';
      $planteles['410'] = '410 FES ARAGON (FILOSOFIA)';
      $planteles['411'] = '411 FES ARAGON (INGENIERIA)';
      $planteles['420'] = '420 FES ARAGON (AGROPECUARIA)';
      $planteles['500'] = '500 FES. Zaragoza';
      $planteles['503'] = '503 FES ZARAGOZA (CIENCIAS)';
      $planteles['505'] = '505 FES ZARAGOZA (QUIMICAS)';
      $planteles['509'] = '509 FES ZARAGOZA (ENFERMERIA)';
      $planteles['512'] = '512 FES ZARAGOZA (MEDICINA)';
      $planteles['514'] = '514 FES ZARAGOZA (ODONTOLOGIA)';
      $planteles['519'] = '519 FES ZARAGOZA (PSICOLOGIA)';
      $planteles['600'] = '600 ENES LEÓN';
      $planteles['606'] = '606 ENES LEÓN';
      $planteles['608'] = '608 ENES LEÓN';
      $planteles['610'] = '610 ENES LEÓN';
      $planteles['612'] = '612 ENES LEÓN';
      $planteles['614'] = '614 ENES LEÓN';
      $planteles['620'] = '620 ENES LEÓN';
      $planteles['621'] = '621 ENES LEÓN';
      $planteles['666'] = '666 ENES LEÓN';
      $planteles['700'] = '700 ENES MORELIA';
      $planteles['702'] = '702 ENES MORELIA';
      $planteles['703'] = '703 ENES MORELIA';
      $planteles['704'] = '704 ENES MORELIA';
      $planteles['710'] = '710 ENES MORELIA';
      return $planteles;
    }
}
