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
      $planteles['1']='0001 FACULTAD DE ARQUITECTURA'
      $planteles['2']='0002 FACULTAD DE ARTES Y DISEÑO'
      $planteles['3']='0003 FACULTAD DE CIENCIAS'
      $planteles['4']='0004 FACULTAD DE CIENCIAS POLITICAS Y SOCIALES'
      $planteles['5']='0005 FACULTAD DE QUIMICA'
      $planteles['6']='0006 FACULTAD DE CONTADURIA Y ADMON'
      $planteles['7']='0007 FACULTAD DE DERECHO'
      $planteles['8']='0008 FACULTAD DE ECONOMIA'
      $planteles['9']='0009 ESCUELA NAL DE ENFERMERIA Y OBSTETRICIA'
      $planteles['10']='0010 FACULTAD DE FILOSOFIA Y LETRAS'
      $planteles['12']='0012 FACULTAD DE MEDICINA'
      $planteles['13']='0013 FACULTAD DE MUSICA'
      $planteles['14']='0014 FACULTAD DE ODONTOLOGIA'
      $planteles['15']='0015 ESCUELA NACIONAL DE TRABAJO SOCIAL'
      $planteles['16']='0016 FAC DE MED VETERINARIA Y ZOOTECNIA'
      $planteles['17']='0017 ESCUELA NACIONAL DE CIENCIAS DE LA TIERRA'
      $planteles['19']='0019 FACULTAD DE PSICOLOGIA'
      $planteles['21']='0021 E.N.P. 1 "GABINO BARREDA"'
      $planteles['22']='0022 E.N.P. 2 "ERASMO CASTELLANOS Q"'
      $planteles['23']='0023 E.N.P. 3 "JUSTO SIERRA"'
      $planteles['24']='0024 E.N.P. 4 "VIDAL CASTAÑEDA Y N."'
      $planteles['25']='0025 E.N.P. 5 "JOSE VASCONCELOS"'
      $planteles['26']='0026 E.N.P. 6 "ANTONIO CASO"'
      $planteles['27']='0027 E.N.P. 7 "EZEQUIEL A. CHAVEZ"'
      $planteles['28']='0028 E.N.P. 8 "MIGUEL E. SCHULZ"'
      $planteles['29']='0029 E.N.P. 9 "PEDRO DE ALBA"'
      $planteles['31']='0031 C.C.H. PLANTEL AZCAPOTZALCO'
      $planteles['32']='0032 C.C.H. PLANTEL NAUCALPAN'
      $planteles['33']='0033 C.C.H. PLANTEL VALLEJO'
      $planteles['34']='0034 C.C.H. PLANTEL ORIENTE'
      $planteles['35']='0035 C.C.H. PLANTEL SUR'
      $planteles['42']='0042 TRADUCCION'
      $planteles['46']='0046 COORDINACION DEL BACHILLERATO A DISTANCIA'
      $planteles['66']='0066 INSTITUTO DE BIOTECNOLOGIA'
      $planteles['90']='0090 INSTITUTO DE ENERGIAS RENOVABLES'
      $planteles['91']='0091 CENTRO DE NANOCIENCIAS Y NANOTECNOLOGIA'
      $planteles['94']='0094 CENTRO PENINSULAR EN HUMANIDADES Y CIENCIAS'
      $planteles['95']='0095 CENTRO DE FISICA APLICADA Y TECNOLOGIA AVANZADA'
      $planteles['97']='0097 CENTRO DE INVESTIGACIONES EN ECOSISTEMAS'
      $planteles['102']='0102 F.E.S. CUAUTITLAN (ARTES PLASTICAS)'
      $planteles['105']='0105 F.E.S. CUAUTITLAN (QUIMICA)'
      $planteles['106']='0106 F.E.S. CUAUTITLAN (CONTADURIA)'
      $planteles['111']='0111 F.E.S. CUAUTITLAN (INGENIERIA)'
      $planteles['116']='0116 F.E.S. CUAUTITLAN (VETERINARIA)'
      $planteles['118']='0118 F.E.S. CUAUTITLAN (AGRICOLA)'
      $planteles['195']='0195 F.E.S. CUAUTITLAN (TECNOLOGIA)'
      $planteles['201']='0201 F.E.S. ACATLAN (ARQUITECTURA)'
      $planteles['202']='0202 F.E.S. ACATLAN (ARTES PLASTICAS)'
      $planteles['203']='0203 F.E.S. ACATLAN (ACTUARIA)'
      $planteles['204']='0204 F.E.S. ACATLAN (CIENCIAS POLITICAS)'
      $planteles['207']='0207 F.E.S. ACATLAN (DERECHO)'
      $planteles['208']='0208 F.E.S. ACATLAN (ECONOMIA)'
      $planteles['210']='0210 F.E.S. ACATLAN (FILOSOFIA)'
      $planteles['211']='0211 F.E.S. ACATLAN (INGENIERIA)'
      $planteles['240']='0240 F.E.S. ACATLAN (COMPUTACION)'
      $planteles['241']='0241 F.E.S. ACATLAN (C IDIOMAS)'
      $planteles['243']='0243 F.E.S. ACATLAN (LENGUA EXTRANJERA)'
      $planteles['303']='0303 F.E.S. IZTACALA (BIOLOGIA)'
      $planteles['312']='0312 F.E.S. IZTACALA (MEDICINA)'
      $planteles['314']='0314 F.E.S. IZTACALA'
      $planteles['319']='0319 F.E.S. IZTACALA (PSICOLOGIA)'
      $planteles['342']='0342 F.E.S. IZTACALA (OPTOMETRIA)'
      $planteles['401']='0401 F.E.S. ARAGON (ARQUITECTURA)'
      $planteles['404']='0404 F.E.S. ARAGON (CIENCIAS POLITICAS)'
      $planteles['407']='0407 F.E.S. ARAGON (DERECHO)'
      $planteles['408']='0408 F.E.S. ARAGON (ECONOMIA)'
      $planteles['410']='0410 F.E.S. ARAGON (FILOSOFIA)'
      $planteles['411']='0411 F.E.S. ARAGON (INGENIERIA)'
      $planteles['420']='0420 F.E.S. ARAGON (AGROPECUARIO)'
      $planteles['503']='0503 F.E.S. ZARAGOZA (BIOLOGIA)'
      $planteles['505']='0505 F.E.S. ZARAGOZA (QUIMICAS)'
      $planteles['509']='0509 F.E.S. ZARAGOZA (ENFERMERIA)'
      $planteles['512']='0512 F.E.S. ZARAGOZA (MEDICINA)'
      $planteles['514']='0514 F.E.S. ZARAGOZA'
      $planteles['515']='0515 F.E.S. ZARAGOZA (TRABAJO SOCIAL)'
      $planteles['519']='0519 F.E.S. ZARAGOZA (PSICOLOGIA)'
      $planteles['604']='0604 E.N.E.S. LEON (CIENCIAS POLITICAS)'
      $planteles['606']='0606 E.N.E.S. LEON (CONTADURIA)'
      $planteles['608']='0608 E.N.E.S. LEON (ECONOMIA)'
      $planteles['612']='0612 E.N.E.S. LEON'
      $planteles['614']='0614 E.N.E.S. LEON'
      $planteles['642']='0642 E.N.E.S. LEON (OPTOMETRIA)'
      $planteles['666']='0666 E.N.E.S. LEON (GENOMICAS)'
      $planteles['702']='0702 E.N.E.S. MORELIA (ARTES PLASTICAS)'
      $planteles['703']='0703 E.N.E.S. MORELIA (CIENCIAS)'
      $planteles['704']='0704 E.N.E.S. MORELIA (CIENCIAS POLITICAS)'
      $planteles['710']='0710 E.N.E.S. MORELIA (FILOSOFIA)'
      $planteles['713']='0713 E.N.E.S. MORELIA (MUSICA)'
      $planteles['803']='0803 E.N.E.S. MERIDA (CIENCIAS)'
      $planteles['810']='0810 E.N.E.S. MERIDA (FILOSOFIA)'
      $planteles['1003']='1003 E.N.E.S. JURIQUILLA (CIENCIAS)'
      $planteles['1012']='1012 E.N.E.S. JURIQUILLA (MEDICINA)'
      $planteles['1066']='1066 E.N.E.S. JURIQUILLA (GENOMICAS)'
      $planteles['1090']='1090 E.N.E.S. JURIQUILLA (ENERGIAS RENOVABLES)'
      $planteles['1095']='1095 E.N.E.S. JURIQUILLA (TECNOLOGIA)'

      return $planteles;
    }

    public function grupos(){
      $grupos = array();
      // Genericas
      $grupos['100'] = '100 FES. Cuautitlán';
      $grupos['200'] = '200 FES Acatlán';
      $grupos['300'] = '300 FES Iztacala';
      $grupos['400'] = '400 FES. Aragón';
      $grupos['500'] = '500 FES. Zaragoza';
      $grupos['600'] = '600 ENES LEÓN';
      $grupos['700'] = '700 ENES MORELIA';
      return $grupos;        
    }
}
