<?php

use Illuminate\Database\Seeder;
use App\Models\{Solicitud, User, Procedencia, CancelacionSolicitud};
use Carbon\Carbon;
use Symfony\Component\Console\Helper\ProgressBar;
use Faker\Factory as Faker;



class SolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Agrega desde el inicio de 2018 hasta el dia actual, de 13 hasta las 19 horas.

        // La tabla Usuarios se da de alta a partir de los planteles. Así que damos de alta el primer usuarios
        // que es el que tiene el papel de Administrador. En el UserSeeder le orotgamos role  de Admin.
        $user = new User();
        $user->name = 'Administrador';
        $user->username = 'Administrador';
        $user->email = 'Admon@correo.com';
        $user->procedencia_id = '1001'; // Departamento de Rev. de Estudios
        $user->password = bcrypt('111111');
        $user->is_active = true;
        $user->remember_token = str_random(10);
        $user->save();

        // Solicitudes extraidas de usuarios existentes.
        $cuentas = $this->cuentas();

        // peso de los registros para la bandera cancelar
        $pesoCancelada = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1];
        $generacionX = array('06','07','08','09','10','11');

        // Fecha de inicio para simular el seeder. (año, mes, dia, hora, min, seg,local)
        $inicioSeed = Carbon::create(2018, 7, 2, 13, 0, 0, 'America/Mexico_City');
        // Fechas de inicio del seed hasta el dia de ahora.
        $inicio = clone $inicioSeed; $ahora = Carbon::now();
        // Dias transcurridos entre el incio y hoy incluyendo fines de semana
        $cuenta = $inicioSeed->diffIndays(Carbon::now());
        // dias transcurridos desde el inicio hasta ahora excluyendo fines de semana
        $diasHabiles = 0;
        for ($i=0; $i <= $cuenta ; $i++)
        {
          if ($inicioSeed->isWeekday())
          {
            $diasHabiles++;
          }
          $inicioSeed->addDays(1);
        }
        // dd($diasHabiles);

        // Solicitudes diarias a registras excluyendo dias de la semana
        $partes = $this->particion($cuentas,$diasHabiles);

        // dd($diasHabiles,$partes);
          // grupos de registros que daremos de alta en desde la fecha de inicio, excluyendo fines de semana
        foreach ($partes as $registros) {
            $laburo = clone $inicio; // variable para hacer variar la fecha
              // grupo de solicitudes a dar de alta por dia
            foreach ($registros as $diario) {
              $laburo->addMinutes(360/count($registros));
              $solicitud = new Solicitud();
              $solicitud->nombre =      $diario[0];
              $solicitud->cuenta =      $diario[1];
              $solicitud->avance =      $diario[2];
              $solicitud->plantel_id =  $diario[3];
              $solicitud->carrera_id =  $diario[4];
              $solicitud->plan_id =     $diario[5];
              // Si no existe, creamos el usuario con el plantel como procedencia.
              $usuarioId =  User::where('procedencia_id',$diario[3])->pluck('id')->toArray();
              if ($usuarioId==null) {
                  // no existe el usuario lo damos de alta
                  $user = new user();
                  $faker = Faker::create();
                  $user->name = $faker->name;
                  $user->username = str_random(6);
                  $user->email = $faker->email;
                  $user->procedencia_id = $diario[3];
                  $user->password = bcrypt('111111');
                  $user->remember_token = str_random(10);
                  $user->is_active = rand(0,1);
                  $user->save();
                  // Consultamos el ID del nuevo usuario y lo asignamos a la solicitud.
                  $solicitud->user_id = User::where('procedencia_id',$diario[3])->pluck('id')[0];
              } else { // Si existe el Usuario, asignamos el ID en la solicitud
                $solicitud->user_id = $usuarioId[0];
              }
              // el resto de los campos
              $solicitud->tipo = (in_array(substr($diario[1],1,2),$generacionX))? 0: 1;
              $solicitud->citatorio = (in_array(substr($diario[1],1,2),$generacionX))? 1: 0;
              $solicitud->pasoACorte = false;

              $cancelada = $pesoCancelada[rand(0,count($pesoCancelada)-1)];
              if ($cancelada) {
                  $table = new CancelacionSolicitud();
                  $table->causa_id = rand(1,2);
                  $table->user_id = $solicitud->user_id;
                  $table->save();
                  $solicitud->cancelada_id = CancelacionSolicitud::all()->last()->id;
              }

              $solicitud->created_at = $laburo;
              $solicitud->updated_at = $laburo;
              $solicitud->save();
            }
            // Si es viernes, saltamos la fecha tres dias para llegar al lunes.
            $brinco = ($inicio->isFriday())? 3: 1;
            $inicio->addDays($brinco);
        }
    }

    public function particion($list,$p)
    {
      // Nos divide las solicitudes $list en $p partes para darlas de alta, una parte por cada dia habil.
      // Se utiliza para devidir las solicitudes en los dias trancurridos desde el inicio del seeder hasta hoy sin fines de semana
      $listlen = count( $list ); $partlen = floor( $listlen / $p );
      $partrem = $listlen % $p;
      $particion = array(); $mark = 0;
      for ($px = 0; $px < $p ; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $particion[$px] = array_slice( $list, $mark, $incr );
        $mark += $incr;
      }
      return $particion;
    }

    public function cuentas()
    {
      $Acuentas = array();
          $Acuentas[0] = ['MIRAMONTES*CORTES*MARIO GERARDO',(string)'066008312','93.13','12','208','185'];
          $Acuentas[1] = ['RODRIGUEZ*BERTHELY*CIRIA DE LOS ANGELES',(string)'070521825','99.77','5','118','229'];
          $Acuentas[2] = ['RAMIREZ*HERNANDEZ*MANUEL',(string)'071220208','100','1','102','458'];
          $Acuentas[3] = ['NAVARRO*FLORES*MARIA ELENA',(string)'074213566','89.37','519','210','440'];
          $Acuentas[4] = ['RAMIREZ*CORTES*VERONICA',(string)'074244043','86.87','519','210','440'];
          $Acuentas[5] = ['RUIZ*MARTINEZ*MARIA ELENA',(string)'077307615','104.63','10','418','313'];
          $Acuentas[6] = ['MURILLO*ESPINOSA*LAURA ELENA',(string)'079128469','90.11','401','102','66'];
          $Acuentas[7] = ['RODEA*OSORIO*FRANCISCO',(string)'079335678','100','2','401','211'];
          $Acuentas[8] = ['MARTINEZ*BECERRIL*JOEL ISAAC',(string)'079392912','100','2','401','211'];
          $Acuentas[9] = ['ORTEGA*SANCHEZ*ROSA MARIA',(string)'080542674','85.8','404','302','70'];
          $Acuentas[10] = ['ALFARO*MUÑOZ*JOSE ANTONIO',(string)'082369080','100.46','2','405','213'];
          $Acuentas[11] = ['SOLIS*RODRIGUEZ*JORGE',(string)'082627889','80.77','411','116','79'];
          $Acuentas[12] = ['SOLIS*RODRIGUEZ*JORGE',(string)'082627889','104.33','411','116','85'];
          $Acuentas[13] = ['RAMIREZ*BOLLAS*JUANA',(string)'084029643','100','407','305','187'];
          $Acuentas[14] = ['RIOS*JUAREZ*ARTURO',(string)'085194924','90.2','1','102','457'];
          $Acuentas[15] = ['RIOS*JUAREZ*ARTURO',(string)'085194924','92.11','1','102','459'];
          $Acuentas[16] = ['VALVERDE*PEREDO*EDGAR',(string)'085260481','100','2','401','211'];
          $Acuentas[17] = ['GONZALEZ*CAMPOS*MONICA',(string)'085548176','101.86','4','302','227'];
          $Acuentas[18] = ['SOTO*HERNANDEZ*ERNESTO',(string)'086083827','100','111','116','698'];
          $Acuentas[19] = ['LOPEZ*SANDOVAL*IGNACIO MARCELINO',(string)'086262165','102','8','306','268'];
          $Acuentas[20] = ['DE JESUS*VICENTE*MARIA DE LOURDES',(string)'088193768','100','519','210','62'];
          $Acuentas[21] = ['SANCHEZ*BARRIOS*MARIA GUADALUPE',(string)'089347005','86.2','1','102','459'];
          $Acuentas[22] = ['SANCHEZ*BARRIOS*MARIA GUADALUPE',(string)'089347005','100','1','102','842'];
          $Acuentas[23] = ['SANCHEZ*GARCIA*LETICIA',(string)'089574430','100','408','306','75'];
          $Acuentas[24] = ['BARRIENTOS*GUEVARA*CESAR',(string)'090022838','100.47','411','110','82'];
          $Acuentas[25] = ['GARCIA*HERNANDEZ*MARIA ADRIANA',(string)'090091258','100','2','401','211'];
          $Acuentas[26] = ['RINCON*PEREA*SANDRA',(string)'090304480','100','411','116','83'];
          $Acuentas[27] = ['ROJAS*GALINDO*OSWALDO',(string)'092165982','100','1','102','842'];
          $Acuentas[28] = ['SANCHEZ*RANGEL*YESSICA',(string)'092190041','100','2','401','211'];
          $Acuentas[29] = ['JUNCO*COTO*JORGE',(string)'092500547','100','1','102','459'];
          $Acuentas[30] = ['JUAREZ*FLORES*GUILLERMINA',(string)'092581603','100','519','210','62'];
          $Acuentas[31] = ['LEDESMA*MEJIA*MARIA GUADALUPE BEATRIZ',(string)'092596209','100','519','210','62'];
          $Acuentas[32] = ['FIESCO*BARRERA*JOSE LUIS',(string)'093120593','100','2','406','212'];
          $Acuentas[33] = ['JACOBO*GARCIA PAVON*GABRIEL',(string)'093190587','90.32','407','305','74'];
          $Acuentas[34] = ['GODINEZ*SERRANO*MARIA GUADALUPE',(string)'093199463','100','519','210','62'];
          $Acuentas[35] = ['DE GANTE*BARRON*MARIA DOLORES',(string)'094168518','100.46','2','405','213'];
          $Acuentas[36] = ['RAMIREZ*NAVARRO*JORGE',(string)'094552906','100','1','102','842'];
          $Acuentas[37] = ['BARRON*VELAZQUEZ*NORMA',(string)'095066565','100','106','301','25'];
          $Acuentas[38] = ['CRUZ*PEREGRINO*AMELIA',(string)'095091552','102.33','2','423','827'];
          $Acuentas[39] = ['SANCHEZ*MARQUEZ*ULISES',(string)'096258226','81.73','12','208','280'];
          $Acuentas[40] = ['DIAZ*AVILA*MARIA GABRIELA',(string)'096501979','100','1','102','842'];
          $Acuentas[41] = ['BAUTISTA*BARTOLO*EMIGDIA LAURA',(string)'096586662','100','1','102','842'];
          $Acuentas[42] = ['ARIAS*ZEPEDA*LETICIA',(string)'097278548','101.18','401','102','186'];
          $Acuentas[43] = ['SANCHEZ*BAUTISTA*JUAN',(string)'097279387','100','519','210','62'];
          $Acuentas[44] = ['BARAJAS*LUNA*LILIANA',(string)'097367961','100','519','210','62'];
          $Acuentas[45] = ['ROMERO*BARRIENTOS*DAVID OMAR',(string)'097589570','91.58','1','102','842'];
          $Acuentas[46] = ['VILLAGOMEZ*MARTINEZ*EDITH MIRIAM',(string)'099001478','100','519','210','62'];
          $Acuentas[47] = ['SANCHEZ*ARIAS*HUGO ENRIQUE',(string)'099002183','100','208','306','1145'];
          $Acuentas[48] = ['BUTRON*BARRERA*PERLA XOCHITL',(string)'099002389','101.29','10','414','837'];
          $Acuentas[49] = ['PEREZ*VILLARREAL*JESUS EDGAR',(string)'099239659','100','11','107','1182'];
          $Acuentas[50] = ['NAVARRO*SALAZAR*JOSE MARTIN',(string)'099243100','101.17','411','107','81'];
          $Acuentas[51] = ['PINEDA*SANCHEZ*MARISOL JANINA',(string)'099252175','100','303','201','51'];
          $Acuentas[52] = ['RODRIGUEZ*RUBIÑOS*ERNESTO JAVIER',(string)'099260387','100','407','305','187'];
          $Acuentas[53] = ['SAAVEDRA*SALAZAR*MARIO PABLO',(string)'099309970','101.86','2','423','827'];
          $Acuentas[54] = ['ARISTA*MENDEZ*MICHELLE STEPHANIA',(string)'103004158','100','14','202','1117'];
          $Acuentas[55] = ['LOPEZ*RIVERA*FERNANDO JOAQUIN',(string)'104002786','100','14','202','1117'];
          $Acuentas[56] = ['MORALES*ROBLES*JESUS GONZALO',(string)'300000999','100','1','102','842'];
          $Acuentas[57] = ['MARTINEZ*ARTEAGA*OSCAR',(string)'300059447','100','404','310','71'];
          $Acuentas[58] = ['BAUTISTA*MENDOZA*MARIA DEL ROSARIO',(string)'300177965','100','519','210','62'];
          $Acuentas[59] = ['CALDERON*MENDOZA*JOSE LUIS',(string)'300276460','106.06','404','310','71'];
          $Acuentas[60] = ['CALVO*VAZQUEZ*DANIEL',(string)'300283747','100','342','209','46'];
          $Acuentas[61] = ['GALVEZ*BARRIENTOS*FANY',(string)'300347836','100','15','312','1107'];
          $Acuentas[62] = ['MANJARREZ*ESPINOSA*LAURA DENISSE',(string)'300669648','90.24','14','202','1117'];
          $Acuentas[63] = ['DE LA TORRE*SOTELO*MAURICIO',(string)'301006011','100','2','401','211'];
          $Acuentas[64] = ['PALMA*CONTRERAS*LESLIE DANIELA',(string)'301186809','100','519','210','62'];
          $Acuentas[65] = ['GONZALEZ*FLORES*CLAUDIA MARGARITA',(string)'301215767','100','9','203','276'];
          $Acuentas[66] = ['HERNANDEZ*JALPA*MARIA ARELI',(string)'301222673','100','519','210','62'];
          $Acuentas[67] = ['ARANA*RANGEL*FLOR ESTELA',(string)'301279660','100','1','102','842'];
          $Acuentas[68] = ['VARGAS*GONZALEZ*ROCIO',(string)'301319078','100','15','312','1107'];
          $Acuentas[69] = ['LUNA*CAMPERO*MARIA TERESA TATIANA',(string)'301593476','82.6','5','212','456'];
          $Acuentas[70] = ['FONSECA*GALLY*XAVIER SANDINO',(string)'301717357','100.64','19','210','301'];
          $Acuentas[71] = ['VALDES*HUERTA*ROBERTO',(string)'302021479','100','6','304','1540'];
          $Acuentas[72] = ['ALDAY*DAVALOS*AXEL',(string)'302022328','100','6','301','179'];
          $Acuentas[73] = ['FLORES*CRUZ*ANGELICA',(string)'302042881','100.64','19','210','301'];
          $Acuentas[74] = ['RAMIREZ*PEREZ*ALAN',(string)'302060230','100','1','102','842'];
          $Acuentas[75] = ['HERNANDEZ*MORENO*JORGE ADRIAN',(string)'302082986','109.09','404','310','71'];
          $Acuentas[76] = ['CRUZ*MENDOZA*ILIANA PATRICIA',(string)'302129874','103.72','2','423','831'];
          $Acuentas[77] = ['FLORES*ORTIZ*LUCERITO',(string)'302180824','100','15','312','1107'];
          $Acuentas[78] = ['GARCIA*CAMACHO*KARLA',(string)'302268591','100','404','302','73'];
          $Acuentas[79] = ['GARCIA*BAIZABAL*JUAN CARLOS',(string)'302276507','100','411','110','82'];
          $Acuentas[80] = ['ROJAS*MORALES*JOSE DE JESUS',(string)'302314818','100','519','210','62'];
          $Acuentas[81] = ['LOPEZ*PEÑA*LAURA ACELA',(string)'303059862','94.67','14','202','1117'];
          $Acuentas[82] = ['CORTES*CORONEL*AGUSTIN',(string)'303078775','100','408','306','358'];
          $Acuentas[83] = ['MALDONADO*MENDOZA*ANA MERCEDES',(string)'303150897','101.12','1','105','1110'];
          $Acuentas[84] = ['RUIZ*ESCOBAR*CHRISTIAN ANDREI',(string)'303200851','100','407','305','187'];
          $Acuentas[85] = ['MONDRAGON*RAMIREZ*VIRIDIANA',(string)'303221744','100','408','306','358'];
          $Acuentas[86] = ['SANCHEZ*RIVERA*JANETT NALLELY',(string)'303257594','100','404','302','73'];
          $Acuentas[87] = ['GONZALEZ*ROJAS*EDITH JAQUELINE',(string)'303268350','100','408','306','358'];
          $Acuentas[88] = ['MEDINA*PEREZ*VICTOR MANUEL',(string)'303283090','100','407','305','187'];
          $Acuentas[89] = ['VILCHIS*GUERRERO*JOSUE JACOBO',(string)'303291910','102.89','411','116','85'];
          $Acuentas[90] = ['ALVAREZ*MORA*JESSICA ANAHI',(string)'303294014','100','102','423','1093'];
          $Acuentas[91] = ['SANCHEZ*ARELLANO*YAZMIN',(string)'303301116','100','6','304','1162'];
          $Acuentas[92] = ['SANCHEZ*ARANDA*LUIS ENRIQUE',(string)'303322810','100','1','102','842'];
          $Acuentas[93] = ['BELTRAN*MARTINEZ*EDER SAID',(string)'303341163','100','411','116','85'];
          $Acuentas[94] = ['BIURQUIZ*SANCHEZ*JUAN MANUEL',(string)'303869469','91.13','14','202','1117'];
          $Acuentas[95] = ['RODRIGUEZ*GARCIA*ERICK ABIMAEL',(string)'304033238','100','6','304','1162'];
          $Acuentas[96] = ['POMPA*ALCALA*CECILIA',(string)'304033616','100','2','401','1437'];
          $Acuentas[97] = ['SOUVERVILLE*RAMIREZ*ARLADY ELIZABETH',(string)'304038367','100.46','2','423','827'];
          $Acuentas[98] = ['VILLAVICENCIO*REYNOSO*OMAR',(string)'304040137','100','14','202','1117'];
          $Acuentas[99] = ['ESCOBAR*PEREZ*EDGAR ALAN',(string)'304066991','100','1','102','842'];
          $Acuentas[100] = ['GARCIA*RAMIREZ*JOSE ANTONIO',(string)'304071456','100','1','102','842'];
          $Acuentas[101] = ['ROMAN*CARMONA*JESSIKA',(string)'304076145','100','14','202','1117'];
          $Acuentas[102] = ['CENTENO*RODRIGUEZ*NANCY JOANA',(string)'304080696','100','2','423','828'];
          $Acuentas[103] = ['LOPEZ*LOPEZ*DIANA GENESIS',(string)'304115563','100','1','102','842'];
          $Acuentas[104] = ['PEREZ*LUNA*GUSTAVO',(string)'304126532','95.53','411','115','1352'];
          $Acuentas[105] = ['MEDINA*CERON*PAULINA',(string)'304142114','76.47','6','301','1538'];
          $Acuentas[106] = ['MANDUJANO*GONZALEZ*ESTHEPANY GRISEL',(string)'304174588','100','407','305','187'];
          $Acuentas[107] = ['GUILLOT*VARGAS*XENIA ERANDI',(string)'304181487','100','509','203','441'];
          $Acuentas[108] = ['GOMEZ*VILCHIS*MARIA TERESA',(string)'304189160','100','106','304','12'];
          $Acuentas[109] = ['RAMIREZ*VERGARA*DAVID AURELIO',(string)'304195811','100','407','305','187'];
          $Acuentas[110] = ['SOLIS*PAZ*FERNANDO JULIAN',(string)'304197554','100','19','210','301'];
          $Acuentas[111] = ['MOLINA*SANCHEZ*MAIRA PATRICIA',(string)'304217478','100','4','302','1246'];
          $Acuentas[112] = ['GONZALEZ*CERVANTES*SARAI BERENICE',(string)'304232015','100','6','304','1162'];
          $Acuentas[113] = ['LEYVA*HERNANDEZ*ROMAN',(string)'304299452','101.33','10','411','836'];
          $Acuentas[114] = ['GARCIA*OSTOS*CLAUDIA DIOSCELIN',(string)'304331307','97.78','14','202','1117'];
          $Acuentas[115] = ['RODRIGUEZ*RABADAN*BETSABE',(string)'304332816','100','106','304','12'];
          $Acuentas[116] = ['FRANCO*NOGUERON*NALLELY',(string)'304342369','100','14','202','1117'];
          $Acuentas[117] = ['ARIZPE*ROJO*ZIANYA',(string)'304536447','90.72','10','417','315'];
          $Acuentas[118] = ['BAUTISTA*PIÑA*BEATRIZ',(string)'304567539','100','1','102','842'];
          $Acuentas[119] = ['RODRIGUEZ*PARRAZAL*MARIA GUADALUPE',(string)'304785683','100','401','105','1082'];
          $Acuentas[120] = ['NIETO*MARTINEZ*MARIA DE LOS ANGELES',(string)'304829099','100.93','2','423','827'];
          $Acuentas[121] = ['SANTIAGO*RUBIO*EDNA PAULINA',(string)'305019718','100','5','213','1172'];
          $Acuentas[122] = ['DEHEZA*HERNANDEZ*DANIELA YARELI',(string)'305028824','92.9','14','202','1117'];
          $Acuentas[123] = ['MARTINEZ*AVIÑA*FRANCISCO NETZAHUALCOYOTL',(string)'305032643','112','10','411','836'];
          $Acuentas[124] = ['PAREJA*RODRIGUEZ*YAZMIN ALEJANDRA',(string)'305117704','100','509','220','1446'];
          $Acuentas[125] = ['GARCIA*LEDEZMA*ALEJANDRO',(string)'305125947','100','503','201','1248'];
          $Acuentas[126] = ['REYES*CRUZ*ERIKA',(string)'305130017','88.91','14','202','1117'];
          $Acuentas[127] = ['AMAYA*DIAZ*MERLE YURIRIA',(string)'305151546','95.56','14','202','1117'];
          $Acuentas[128] = ['OLIVAS*SANTOS*ILSE',(string)'305154499','100','519','210','1495'];
          $Acuentas[129] = ['VEGA*GONZALEZ*LUIS EDUARDO',(string)'305162522','101.86','2','423','830'];
          $Acuentas[130] = ['FLORES*CABALLERO*VIRIDIANA',(string)'305172886','83.59','14','202','1117'];
          $Acuentas[131] = ['SANCHEZ*SANCHEZ*JOSE LORENZO',(string)'305183068','100','2','401','211'];
          $Acuentas[132] = ['FALCON*BALDERAS*EDGAR YAIR',(string)'305245744','100','407','305','1325'];
          $Acuentas[133] = ['CASTAÑEDA*PEREZ*CLAUDIA ALEJANDRINA',(string)'305258339','107.84','10','421','318'];
          $Acuentas[134] = ['LOPEZ*JIMENEZ*BLANCA ESTELA',(string)'305274564','100','14','202','1117'];
          $Acuentas[135] = ['MARTINEZ*HERNANDEZ*SANDRA',(string)'305281274','75.32','10','414','837'];
          $Acuentas[136] = ['CAMACHO*CHI*FELIPE ADZARAEL',(string)'305302418','100','6','301','1161'];
          $Acuentas[137] = ['LOPEZ*SALERO*GLORIA',(string)'305330406','100','14','202','1117'];
          $Acuentas[138] = ['OLASCOAGA*ALBA*DIEGO ANDRES',(string)'305690333','101.86','2','423','830'];
          $Acuentas[139] = ['ANGELES*LUGO*VIRIDIANA',(string)'306000052','82.18','12','208','1497'];
          $Acuentas[140] = ['AGUIRRE*RODRIGUEZ*IVETTE',(string)'306009433','100','14','202','1117'];
          $Acuentas[141] = ['CARBAJAL*VEGA*JONATHAN ISAAC',(string)'306012774','100','319','210','47'];
          $Acuentas[142] = ['HERNANDEZ*DIAZ*ARACELI',(string)'306031450','100','14','202','1117'];
          $Acuentas[143] = ['GONZALEZ*SERVIN*ALVARO SAID',(string)'306033825','100','14','202','1117'];
          $Acuentas[144] = ['PELAEZ*HERNANDEZ*LOURDES ALEJANDRA',(string)'306037658','100','2','423','829'];
          $Acuentas[145] = ['ORDAZ*KUCKS*SOFIA ANGELA',(string)'306042917','100','14','202','1117'];
          $Acuentas[146] = ['PEREZ*ALCALA*JOSE ANGELLO',(string)'306044423','100','14','202','1117'];
          $Acuentas[147] = ['GUERRERO*CRUZ*MARIA ISABEL',(string)'306051621','100','6','301','1161'];
          $Acuentas[148] = ['BADILLO*ROJAS*ANGEL MIGUEL',(string)'306070462','100','14','202','1117'];
          $Acuentas[149] = ['BERUMEN*GARCIA*CINTHIA NOEMI',(string)'306070558','97.78','14','202','1117'];
          $Acuentas[150] = ['DEL VALLE*ROMERO*JAZMIN ALICIA',(string)'306072758','100','6','301','1161'];
          $Acuentas[151] = ['JUAN*MENDEZ*EDUARDO ADRIAN',(string)'306086515','100','2','401','1436'];
          $Acuentas[152] = ['AYALA*SEGOVIANO*KARLA EDITH',(string)'306104734','100','404','310','1275'];
          $Acuentas[153] = ['VIVEROS*CORTES*EDUARDO',(string)'306119141','100','408','306','1383'];
          $Acuentas[154] = ['GUTIERREZ*IGLESIAS*NELLY DANIELA',(string)'306132540','100','14','202','1117'];
          $Acuentas[155] = ['CEDILLO*DEL VILLAR*DAYANA MICHELLE',(string)'306133798','100','14','202','1117'];
          $Acuentas[156] = ['CARREON*NIÑO*NORMA EDITH',(string)'306136847','97.33','14','202','1117'];
          $Acuentas[157] = ['AMAYA*SALCEDO*ANA ERIKA',(string)'306152663','100','14','202','1117'];
          $Acuentas[158] = ['FLORES*PIMENTEL*JORGE ELIAS',(string)'306154667','100','2','423','828'];
          $Acuentas[159] = ['HERRERA*ESQUIVEL*ANNA VICTORIA',(string)'306164024','80.04','14','202','1117'];
          $Acuentas[160] = ['TOPETE*CORDOVA*DANIEL',(string)'306185584','100','14','202','1117'];
          $Acuentas[161] = ['LAGUNA*VILLAR*ARELY GUADALUPE',(string)'306192153','100','14','202','1117'];
          $Acuentas[162] = ['MAYER*SANCHEZ*MARCO ANTONIO',(string)'306192421','80','7','305','1471'];
          $Acuentas[163] = ['ALANIS*MEJIA*DANIEL',(string)'306193057','100','11','114','1368'];
          $Acuentas[164] = ['VAZQUEZ*RODRIGUEZ*TERESA DE JESUS',(string)'306193600','100','14','202','1117'];
          $Acuentas[165] = ['SALAS*HERNANDEZ*BRIANDA ELIZABETH',(string)'306194061','86.69','14','202','1117'];
          $Acuentas[166] = ['CORONA*GONGORA*JOSE ALBERTO',(string)'306201840','100','6','301','1161'];
          $Acuentas[167] = ['ROJAS*SEVERIANO*IRAIS',(string)'306244771','100','6','308','1163'];
          $Acuentas[168] = ['CORTES*GONZALEZ*NEFTALI GUILLERMO',(string)'306257713','102.23','411','115','1351'];
          $Acuentas[169] = ['RAMIREZ*GALVAN*ANGEL ALEJANDRO',(string)'306291593','100','1','102','842'];
          $Acuentas[170] = ['SOLIS*LUVIANOS*ALEJANDRA MAYANIN',(string)'306297076','100','4','311','1281'];
          $Acuentas[171] = ['SANCHEZ*PEREZ*RICARDO GABRIEL',(string)'306312160','100','1','102','842'];
          $Acuentas[172] = ['VILLEGAS*AYALA*JENNIFER MARAHI',(string)'306322493','100','14','202','1117'];
          $Acuentas[173] = ['VARGAS*ROJAS*DANIEL ARMANDO',(string)'306329870','100','14','202','1117'];
          $Acuentas[174] = ['ZUÑIGA*PEREZ*GONZALO GABRIEL',(string)'306332111','100','14','202','1117'];
          $Acuentas[175] = ['VALDOVINOS*PICHARDO*RAFAEL RASHID',(string)'306707809','100','14','202','1117'];
          $Acuentas[176] = ['MARTINEZ*PERALTA*ELIZABETH ABIGAIL',(string)'306741335','100','14','202','1117'];
          $Acuentas[177] = ['ALVAREZ*ESTRADA*KARIME SOFIA',(string)'307009735','100','2','423','831'];
          $Acuentas[178] = ['CABALLERO*RAMIREZ*ILIANA ELIZABETH',(string)'307011000','100','14','202','1117'];
          $Acuentas[179] = ['BELMONT*HERNANDEZ*ESTRELLA',(string)'307016270','100','14','202','1117'];
          $Acuentas[180] = ['ARRONTE*GONZALEZ*ALEJANDRA',(string)'307018920','100','14','202','1117'];
          $Acuentas[181] = ['ESTRADA*RIVERO*DONAJI METZLI',(string)'307026345','100','14','202','1117'];
          $Acuentas[182] = ['MEDERO*LEDESMA*MONTSERRAT',(string)'307033158','100','14','202','1117'];
          $Acuentas[183] = ['ACOSTA*BAUTISTA*LAURA REBECA',(string)'307038335','100','14','202','1117'];
          $Acuentas[184] = ['GOMEZ*JUAREZ*DULCE XIMENA',(string)'307039576','100','14','202','1117'];
          $Acuentas[185] = ['CORTES*MUÑOZ*DENISSE FERNANDA',(string)'307048280','100','6','301','1161'];
          $Acuentas[186] = ['BERNAL*MORENO*BEATRIZ',(string)'307061490','92.9','14','202','1117'];
          $Acuentas[187] = ['BAUTISTA*PEREZ*CITLALLI',(string)'307061713','100','14','202','1117'];
          $Acuentas[188] = ['GRANADOS*MELGAR*BEATRIZ ISADORA',(string)'307067715','100','2','423','827'];
          $Acuentas[189] = ['CHAVEZ*MIRELES*GABRIELA',(string)'307078447','100','14','202','1117'];
          $Acuentas[190] = ['GONZALEZ*REYES*ALEJANDRO',(string)'307080011','100','14','202','1117'];
          $Acuentas[191] = ['GARDUÑO*VEGA*CESAR ANTONIO',(string)'307080530','100','14','202','1117'];
          $Acuentas[192] = ['GALLARDO*MARTINEZ*DANIELA FERNANDA',(string)'307080688','100','14','202','1117'];
          $Acuentas[193] = ['GARIBAY*PEREZ*JACZINT AYAMAIN',(string)'307084002','100','14','202','1117'];
          $Acuentas[194] = ['ECHEVERRIA*NAVA*GABRIEL ANTONIO',(string)'307088103','100','319','210','47'];
          $Acuentas[195] = ['HERNANDEZ*GONZALEZ*HECTOR',(string)'307093352','100','14','202','1117'];
          $Acuentas[196] = ['HERNANDEZ*GAYTAN*BERTHA ARISBETH',(string)'307107123','100','2','423','828'];
          $Acuentas[197] = ['ARAGON*TORREBLANCA*YEYETZI ESPERANZA',(string)'307110608','100','14','202','1117'];
          $Acuentas[198] = ['ORDOÑEZ*CARRILLO*CECILIA',(string)'307118453','100','14','202','1117'];
          $Acuentas[199] = ['MENDOZA*MORALES*DAVID EDUARDO',(string)'307119395','100','14','202','1117'];
          $Acuentas[200] = ['PLASCENCIA*MONTERO*YASMIN',(string)'307129068','100','14','202','1117'];
          $Acuentas[201] = ['VEGA*NOGUEZ*CARLA MARIANA',(string)'307131261','100','14','202','1117'];
          $Acuentas[202] = ['MARTINEZ*MARTINEZ*RAUL',(string)'307136053','100','14','202','1117'];
          $Acuentas[203] = ['PERLA*GARDUÑO*MONICA',(string)'307142546','100','2','423','827'];
          $Acuentas[204] = ['SANCHEZ*ACOSTA*ELIZABETH',(string)'307161600','100','1','102','842'];
          $Acuentas[205] = ['RAMOS*TIERRAFRIA*ULISES',(string)'307164371','100','14','202','1117'];
          $Acuentas[206] = ['MONTIEL*CERVANTES*MONICA ROXANA',(string)'307170503','100','14','202','1117'];
          $Acuentas[207] = ['JIMENEZ*JUAREZ*JESSICA',(string)'307170833','100','14','202','1117'];
          $Acuentas[208] = ['GARCIA*FUENTES*MIRIAM',(string)'307175539','100','14','202','1117'];
          $Acuentas[209] = ['DOMINGUEZ*FIGUEROA*AKETZALI',(string)'307179771','96.45','14','202','1117'];
          $Acuentas[210] = ['MIRANDA*ORDOÑEZ*LAURA ELENA',(string)'307191393','100','7','305','1475'];
          $Acuentas[211] = ['PEREZ*AVILA*BELEN',(string)'307198086','100','14','202','1117'];
          $Acuentas[212] = ['SIXTO*ORTIZ*OSCAR',(string)'307200712','100','14','202','1117'];
          $Acuentas[213] = ['MENDOZA*SANCHEZ*MARIA ITZURI',(string)'307209375','100','1','102','842'];
          $Acuentas[214] = ['TAPIA*SILVA*JESSICA',(string)'307213448','100','2','423','831'];
          $Acuentas[215] = ['MARIN*HERRERA*RICARDO RAUL',(string)'307223214','100','14','202','1117'];
          $Acuentas[216] = ['MARTINEZ*IBARRA*IVAN ULISES',(string)'307225342','100','14','202','1117'];
          $Acuentas[217] = ['DOMINGUEZ*GARCIA*MAURICIO EDUARDO',(string)'307228989','100','14','202','1117'];
          $Acuentas[218] = ['MORENO*LARA*ALEJANDRA',(string)'307236579','100','14','202','1117'];
          $Acuentas[219] = ['MUÑIZ*NARVAEZ*DIANA ANABEL',(string)'307240147','100','14','202','1117'];
          $Acuentas[220] = ['MEDEL*DIAZ*ARTURO JAVIER',(string)'307240769','100','14','202','1117'];
          $Acuentas[221] = ['PEREZ*URBINA*ISAIRA PATRICIA',(string)'307244262','100','14','202','1117'];
          $Acuentas[222] = ['OSNAYA*LABASTIDA*LAURA',(string)'307246802','100','14','202','1117'];
          $Acuentas[223] = ['SANCHEZ*VEGA*JESSICA IVETTE',(string)'307271741','100','319','210','47'];
          $Acuentas[224] = ['OCAMPO*MENDOZA*ELIDE ARMIDA',(string)'307279486','96.45','14','202','1117'];
          $Acuentas[225] = ['MEZA*TRUJILLO*SAMANTHA',(string)'307305037','100','14','202','1117'];
          $Acuentas[226] = ['SILVA*SANTILLAN*DAVID',(string)'307308478','100','14','202','1117'];
          $Acuentas[227] = ['TONIX*MONDRAGON*VERONICA MONSERRATH',(string)'307310798','100','14','202','1117'];
          $Acuentas[228] = ['SAENZ*GONZALEZ*MONSERRATH',(string)'307312084','100','14','202','1117'];
          $Acuentas[229] = ['PAEZ*VARGAS ESTRADA*DANIEL',(string)'307511634','100','14','202','1117'];
          $Acuentas[230] = ['MEDRANO*BARRIGA*CARLOS EZEQUIEL',(string)'307525305','100','7','305','1471'];
          $Acuentas[231] = ['POMPA*RANGEL*FERNANDO',(string)'307526649','83.33','97','216','1177'];
          $Acuentas[232] = ['TORRES*GALVAN*YAMIL ALLFADIR',(string)'307598211','86.69','14','202','1117'];
          $Acuentas[233] = ['GALICIA*MARTINEZ*JESSICA CONSUELO',(string)'307612047','100','14','202','1117'];
          $Acuentas[234] = ['POLIS*ROSAS*ZURIZADAI',(string)'308282971','83.33','97','216','1177'];
          $Acuentas[235] = ['AGUILAR*CASTILLO*NAHELIA',(string)'309734947','80','97','216','1177'];
          $Acuentas[236] = ['ABAD*FONSECA*NAYELI',(string)'310071176','100','7','305','1447'];
          $Acuentas[237] = ['HERNANDEZ*CASTILLO*ARIATNA',(string)'311004698','100.96','19','210','1361'];
          $Acuentas[238] = ['VACA*FILIO*MARIANA DE JESUS',(string)'311015825','101.29','19','210','1361'];
          $Acuentas[239] = ['AVILA*ROJAS*ARELY YANIN',(string)'311016523','100','6','301','1538'];
          $Acuentas[240] = ['PIÑA*TORRES*JAVIER',(string)'311018242','106.25','703','216','1574'];
          $Acuentas[241] = ['BUCIO*MARQUEZ*JONATHAN ALEXIS',(string)'311027846','100','319','210','47'];
          $Acuentas[242] = ['CONTRERAS*DELGADILLO*CRISTOFER ULISES',(string)'311028513','100','303','201','51'];
          $Acuentas[243] = ['ESPINOSA*HERRERA*JAQUELINE',(string)'311030125','100','411','114','1347'];
          $Acuentas[244] = ['VAZQUEZ*HERRERA*NAYELI VALERIA',(string)'311044456','100','19','210','1361'];
          $Acuentas[245] = ['HERNANDEZ*MONTALVO*LIZET SARAI',(string)'311047048','100.32','19','210','1361'];
          $Acuentas[246] = ['ILLESCAS*MALAGON*CARLOS EDUARDO',(string)'311050592','106.25','703','216','1574'];
          $Acuentas[247] = ['DELGADO*VILLEGAS*YDALIA',(string)'311059722','100.32','19','210','1361'];
          $Acuentas[248] = ['ESPINOSA*MENDOZA*ERIC ISAY',(string)'311059966','100','66','215','1362'];
          $Acuentas[249] = ['AMOR*ROJAS*DULCE SUSANA',(string)'311063462','100','519','210','1495'];
          $Acuentas[250] = ['GRANADOS*LECHUGA*ANDREA LIZBET',(string)'311064270','98.7','19','210','1361'];
          $Acuentas[251] = ['ANGUIANO*RIOS*ELI YAIR',(string)'311067350','100','6','301','1538'];
          $Acuentas[252] = ['CASTILLO*NUÑEZ*BRENDA MISHEL',(string)'311073551','100.96','19','210','1361'];
          $Acuentas[253] = ['OJEDA*YAÑEZ*JESSICA ANDREA',(string)'311087356','99.03','19','210','1361'];
          $Acuentas[254] = ['RAMIREZ*OMAÑA*DIANA ELIZABETH',(string)'311088023','100.32','19','210','1361'];
          $Acuentas[255] = ['MAZARIEGOS*LEDESMA*DIEGO ARMANDO',(string)'311097160','100','319','210','47'];
          $Acuentas[256] = ['RAMOS*GALICIA*ENRIQUE MANUEL',(string)'311099573','100.96','19','210','1361'];
          $Acuentas[257] = ['GARCIA*GASCA*RODRIGO DAVID',(string)'311108916','101.46','710','432','1584'];
          $Acuentas[258] = ['VILLAFAN*CACERES*STEPHANIE MICHELLE',(string)'311112845','106.28','703','216','1573'];
          $Acuentas[259] = ['REYNA*FLORES*ANGELICA DE JESUS',(string)'311117620','100','6','301','1538'];
          $Acuentas[260] = ['RODRIGUEZ*CRUZ*WENDITSEL',(string)'311121504','100','411','114','1348'];
          $Acuentas[261] = ['MARQUEZ*PEREZ*LUIS',(string)'311126729','100','411','114','1347'];
          $Acuentas[262] = ['TELLO*PALENCIA*MARCO ANTONIO',(string)'311128833','100','66','215','1362'];
          $Acuentas[263] = ['AGUIRRE*VIDAL*MAURICIO ALEJANDRO',(string)'311129610','100','3','101','1176'];
          $Acuentas[264] = ['CHAVEZ*DELGADO*ANDRES',(string)'311137217','100','203','101','1642'];
          $Acuentas[265] = ['HERNANDEZ*GUZMAN*KARLA BEATRIZ',(string)'311143803','100','19','210','1361'];
          $Acuentas[266] = ['OJEDA*GUEVARA*ROXANA MONTSERRAT',(string)'311146512','100.32','19','210','1361'];
          $Acuentas[267] = ['MENDEZ*HINOJOSA*JESSICA ONIRICA',(string)'311150403','100','519','210','1495'];
          $Acuentas[268] = ['AGUILAR*DOMINGUEZ*MARTHA LORENA',(string)'311150434','100','19','210','1361'];
          $Acuentas[269] = ['CRIVELLARO*FIERRO*ALEXANDRA',(string)'311151792','100','2','401','1436'];
          $Acuentas[270] = ['VILLAFAN*FLORES*MARIO DANIEL',(string)'311168495','100','6','301','1538'];
          $Acuentas[271] = ['BADILLO*SOTO*DANIEL',(string)'311169801','100','6','301','1538'];
          $Acuentas[272] = ['DE LA FUENTE*RODRIGUEZ*ROSA MARIA',(string)'311171949','100','19','210','1361'];
          $Acuentas[273] = ['ALMAGUER*AZPEITIA*MARIEL',(string)'311180756','100','19','210','1361'];
          $Acuentas[274] = ['GUTIERREZ*AGUILAR*ZYANYA FERNANDA',(string)'311182671','100','6','301','1538'];
          $Acuentas[275] = ['GARCIA*SOLIS*EVELIN',(string)'311182932','105.11','703','216','1574'];
          $Acuentas[276] = ['GUERRERO*TEXNA*MAYRA',(string)'311186789','100','6','301','1538'];
          $Acuentas[277] = ['GARCIA*COLIN*MARIA FERNANDA',(string)'311187164','100','6','304','1540'];
          $Acuentas[278] = ['PEÑA*PEDRAZA*DANIELA GUADALUPE',(string)'311192777','100.32','19','210','1361'];
          $Acuentas[279] = ['BALLEZA*CORRALES*ROBERTO ISAAC',(string)'311195345','100.32','19','210','1361'];
          $Acuentas[280] = ['RAMIREZ*SANLUIS*IRAIS',(string)'311198212','100','519','210','1495'];
          $Acuentas[281] = ['DIAZ*DIAZ*ERIKA DANIELA',(string)'311215630','100','6','301','1538'];
          $Acuentas[282] = ['ROJAS*DIAZ*VIANEY',(string)'311219803','100','19','210','1361'];
          $Acuentas[283] = ['RAMIREZ*LOPEZ*CLAUDIA YARELI',(string)'311219999','100','19','210','1361'];
          $Acuentas[284] = ['VELASCO*ARVIZU*JEANETTE GUADALUPE',(string)'311222144','100.32','19','210','1361'];
          $Acuentas[285] = ['GONZALEZ*GARDUÑO*JOSHUA',(string)'311224186','100','319','210','47'];
          $Acuentas[286] = ['HERNANDEZ*ROCHA*MONTSERRAT CECILIA',(string)'311224557','100','319','210','47'];
          $Acuentas[287] = ['FLORES*FUENTES*NAYELY',(string)'311225901','101.61','19','210','1361'];
          $Acuentas[288] = ['GONZALEZ*MANRIQUEZ*JOSE GUADALUPE',(string)'311229136','100.32','19','210','1361'];
          $Acuentas[289] = ['GONZALEZ*FRANCISCO*IVONNE',(string)'311229246','100','19','210','1361'];
          $Acuentas[290] = ['HERNANDEZ*MARTINEZ*JORGE',(string)'311229954','100','6','301','1538'];
          $Acuentas[291] = ['HEREDIA*ALARCON*MARIA FERNANDA',(string)'311234907','101.61','19','210','1361'];
          $Acuentas[292] = ['ARENAS*ROSALES*DANIEL',(string)'311237692','104.49','90','128','1521'];
          $Acuentas[293] = ['PEREA*SANTIAGO*CARLOS DAVID',(string)'311241947','100','90','128','1521'];
          $Acuentas[294] = ['MORA*MEDINA*DIANA IZCHEL',(string)'311250974','100','519','210','1495'];
          $Acuentas[295] = ['DE AVILA*HERNANDEZ*HUGO',(string)'311258217','100.32','19','210','1361'];
          $Acuentas[296] = ['LIRA*HERRERA*FRIDA MONTSERRAT',(string)'311262641','100.96','19','210','1361'];
          $Acuentas[297] = ['LEDESMA*MARTIN*JOSE OMAR',(string)'311263260','101.12','91','129','1527'];
          $Acuentas[298] = ['CANCINO*ALVAREZ*KARLA ABIGAIL',(string)'311269334','100.64','19','210','1361'];
          $Acuentas[299] = ['GOMEZ*RAMIREZ*BRENDA MARIANA',(string)'311277254','100','666','223','1624'];
          $Acuentas[300] = ['HERNANDEZ*MEJIA*ALEJANDRA',(string)'311282616','101.29','19','210','1361'];
          $Acuentas[301] = ['IBARRA*GALLARDO*EDGAR OSVALDO',(string)'311282726','100','6','301','1538'];
          $Acuentas[302] = ['HERNANDEZ*CRUZ*ROCIO IVONNE',(string)'311282898','100','19','210','1361'];
          $Acuentas[303] = ['TREJO*CARRILLO*ARTURO ULISES',(string)'311284373','103.42','612','221','1531'];
          $Acuentas[304] = ['VERA*ARROYO*FERNANDO JULIAN',(string)'311284809','100','404','310','1275'];
          $Acuentas[305] = ['CHIU*VALDERRAMA*JORGE ISAAC',(string)'311286449','100','303','201','51'];
          $Acuentas[306] = ['CHAPARRO*ZAVALA*SANDRA PAULINA',(string)'311290299','101.61','19','210','1361'];
          $Acuentas[307] = ['HERNANDEZ*MACIAS*BRENDA NATALIA',(string)'311291588','100.32','19','210','1361'];
          $Acuentas[308] = ['MARTINEZ*HUERTA*MARICELA IREL',(string)'311298910','100.64','19','210','1361'];
          $Acuentas[309] = ['MARTINEZ*MARGARITO*ARACELI',(string)'311305445','100','19','210','1361'];
          $Acuentas[310] = ['SANCHEZ*JIMENEZ*CARLOS ANTONIO',(string)'311312612','100','319','210','47'];
          $Acuentas[311] = ['SOTO*MONTOYA*ALMA CECILIA',(string)'311313303','100','710','433','1597'];
          $Acuentas[312] = ['CHAVEZ*GUZMAN*ROGELIO',(string)'311319752','100','6','301','1538'];
          $Acuentas[313] = ['VILLAVERDE*VIAYRA*ALEJANDRO',(string)'311323533','100','19','210','1361'];
          $Acuentas[314] = ['ANINCER*ANGEL*MARIANNE',(string)'311324183','100','19','210','1361'];
          $Acuentas[315] = ['CASTAÑEDA*GARCES*ANA LUISA',(string)'311343371','100.28','91','129','1527'];
          $Acuentas[316] = ['MONTIEL*MONROY*LUIS RAUL',(string)'311522891','100.32','19','210','1361'];
          $Acuentas[317] = ['ROMERO*ESPITIA*MARIA FERNANDA',(string)'311555657','100','6','301','1538'];
          $Acuentas[318] = ['RUIZ*GOMEZ*DANIELA',(string)'311559813','100','12','208','1438'];
          $Acuentas[319] = ['GALLOSA*LOPEZ*TADEUS',(string)'311560961','100','90','128','1521'];
          $Acuentas[320] = ['MARTINEZ*GAYOSSO*ADRIAN',(string)'311561487','100','12','208','1438'];
          $Acuentas[321] = ['DURAN*FERNANDEZ*CARLOS',(string)'311621042','100','6','301','1538'];
          $Acuentas[322] = ['BUSTAMANTE*NADER*PATRICK ALBERTO',(string)'311650147','100','314','202','55'];
          $Acuentas[323] = ['BAÑUELOS*RUIZ*LEONARDO FABIAN',(string)'311656149','100','90','128','1521'];
          $Acuentas[324] = ['VEGA*CASTRO*DIEGO ENRIQUE',(string)'311672123','100','210','411','1180'];
          $Acuentas[325] = ['MANZANILLA*LOPEZ*RAFAEL JESUS',(string)'311723184','100','12','208','1438'];
          $Acuentas[326] = ['REYES*AVILA*SILVIA',(string)'311728725','100','6','304','1540'];
          $Acuentas[327] = ['SALAS*CASAS*DIANA',(string)'312018805','100','309','220','1445'];
          $Acuentas[328] = ['JUAREZ*PEREDO*OMAR',(string)'312062578','85.96','1','102','842'];
          $Acuentas[329] = ['MENDEZ*BARRADAS*GALO RAFAEL',(string)'314536262','106.28','703','216','1573'];
          $Acuentas[330] = ['ROSAS*MARTINEZ*ALEJANDRO',(string)'401005457','100','1','102','842'];
          $Acuentas[331] = ['ARANDA*CORTES*LAURA OLIVIA',(string)'401017746','104.44','4','303','586'];
          $Acuentas[332] = ['MENDOZA*SANCHEZ*AMADO',(string)'401024841','100','407','305','187'];
          $Acuentas[333] = ['TELLO*RODRIGUEZ*MARIANA ISABELLA',(string)'401048106','100','1','102','842'];
          $Acuentas[334] = ['FLORES*RODRIGUEZ*FRANCISCO',(string)'401070439','101.32','1','123','1137'];
          $Acuentas[335] = ['FLORES*GALICIA*NORMA',(string)'401082151','95.08','8','306','271'];
          $Acuentas[336] = ['GOMEZ*QUINTO*JOSE ANTONIO',(string)'402026350','100','10','411','303'];
          $Acuentas[337] = ['CRUZ*ESPINOSA*MARIA DEL MAR',(string)'402071848','100.96','116','207','41'];
          $Acuentas[338] = ['GOMEZ*SANTIAGO*JANET',(string)'402077682','100','106','304','18'];
          $Acuentas[339] = ['LUNA*REDIN*JAIME',(string)'403004683','100.48','411','116','85'];
          $Acuentas[340] = ['ORTEGA*TREJO*IVONNE',(string)'403018622','100','519','210','62'];
          $Acuentas[341] = ['RUIZ*GARCIA*FROYLAN',(string)'403077898','100','519','210','62'];
          $Acuentas[342] = ['GONZALEZ*GUTIERREZ*JESSICA',(string)'405013465','100','4','310','1238'];
          $Acuentas[343] = ['SALAZAR*ALCOCER*JOSE ANTONIO',(string)'405096697','80.35','6','304','1112'];
          $Acuentas[344] = ['CRUZ*REYES*FERNANDO',(string)'406017538','100','6','301','1173'];
          $Acuentas[345] = ['GRAJALES*VEERKAMP*CARINA',(string)'406019958','83.33','97','216','1177'];
          $Acuentas[346] = ['ROSAS*ZAVALA*LIZETH LUCERO',(string)'406025434','100','407','305','187'];
          $Acuentas[347] = ['HUESCA*JUAREZ*VERONICA',(string)'407019865','100','15','312','1107'];
          $Acuentas[348] = ['BERNAL*ASCENCIO*LIDI MARLENE',(string)'407021099','88.02','14','202','1117'];
          $Acuentas[349] = ['GARCIA*MARTINEZ*JORGE',(string)'407038352','100','407','305','1108'];
          $Acuentas[350] = ['SALDIVAR*BRINGAS*JOSE EFRAIN',(string)'407038596','100.7','411','107','81'];
          $Acuentas[351] = ['DIAZ*MARTINEZ*MONICA IVETTE',(string)'407043336','100','309','203','1105'];
          $Acuentas[352] = ['DELGADO*BARAJAS*MONTSERRAT PENELOPE',(string)'407047516','92.01','14','202','1117'];
          $Acuentas[353] = ['VELAZQUEZ*VALDEZ*MARCOS',(string)'407086889','100.49','411','116','84'];
          $Acuentas[354] = ['CORONA*DURAN*JOSE GUADALUPE',(string)'407088034','100','111','116','693'];
          $Acuentas[355] = ['GARCIA*JAIMES*ELIZABETH',(string)'408014533','100','15','312','1107'];
          $Acuentas[356] = ['LARA*MERINO*AFRICA KENNIA',(string)'408022123','100','8','306','271'];
          $Acuentas[357] = ['GONZALEZ*JIMENEZ*VICTOR ANTONIO',(string)'408033185','100','14','202','1117'];
          $Acuentas[358] = ['GONZALEZ*JUAREZ*OSCAR ISIDRO',(string)'408066697','100','411','107','1280'];
          $Acuentas[359] = ['CORONA*MIRANDA*CLARA PATRICIA',(string)'408068093','100','420','309','1101'];
          $Acuentas[360] = ['PEDROZA*GUZMAN*TUANNI IVONNE',(string)'408094427','100','6','304','1162'];
          $Acuentas[361] = ['VALERIO*MENDOZA*SELENE ISIS',(string)'408096892','75.16','14','202','1117'];
          $Acuentas[362] = ['MEJIA*MONTERO*ADOLFO',(string)'408098865','100.71','3','106','1081'];
          $Acuentas[363] = ['MOLINA*HERNANDEZ*ALMA JESSICA',(string)'408111704','100','408','306','1292'];
          $Acuentas[364] = ['MENDEZ*ROSAS*ROBERTO',(string)'409008342','100','3','101','1176'];
          $Acuentas[365] = ['HERNANDEZ*NUÑEZ*PERLA MARINA',(string)'409015454','89.32','210','412','1158'];
          $Acuentas[366] = ['LOPEZ*PEREZ*TERESA',(string)'409019421','100','9','203','276'];
          $Acuentas[367] = ['HURTADO*ESCOBAR*TERESITA DE JESUS',(string)'409025567','100','14','202','1117'];
          $Acuentas[368] = ['MIRANDA*RUIZ*ADRIAN',(string)'409027365','85.36','14','202','1117'];
          $Acuentas[369] = ['LOPEZ*FABILA*SHANTAL ABIGAIL',(string)'409038310','100','15','312','1107'];
          $Acuentas[370] = ['BUREOS*SANCHEZ*DANIEL',(string)'409039393','100','106','304','1320'];
          $Acuentas[371] = ['GONZALEZ*SOSA Y AVILA*PEDRO SANTIAGO',(string)'409052912','101.32','10','417','315'];
          $Acuentas[372] = ['BERNABE*ROSAS*MARIA ALEJANDRA',(string)'409068089','100','407','305','1325'];
          $Acuentas[373] = ['ZULOAGA*VIVAS*JOEL ENRIQUE',(string)'409072918','100','106','304','1319'];
          $Acuentas[374] = ['LOPEZ*ENRIQUEZ*OMAR',(string)'409082090','100','404','302','1278'];
          $Acuentas[375] = ['RAMIREZ*PICHARDO*YASMIN',(string)'409098882','101.58','10','307','1355'];
          $Acuentas[376] = ['TORRES*SANCHEZ*GABRIELA ALEJANDRA',(string)'409099346','100','106','304','1319'];
          $Acuentas[377] = ['ARANO*VARELA*MIRIAM LUCERITO',(string)'409528556','104.66','2','423','830'];
          $Acuentas[378] = ['JIMENEZ*MARTINEZ*GISSELLE ARACELI',(string)'410000195','100','404','310','1290'];
          $Acuentas[379] = ['TENORIO*PEREZ*SALVADOR',(string)'410002508','83.33','97','216','1177'];
          $Acuentas[380] = ['TENORIO*PEREZ*SALVADOR',(string)'410002508','100','703','216','1623'];
          $Acuentas[381] = ['SOTO*LOPEZ*RODRIGO JUAN',(string)'410002986','100','10','412','833'];
          $Acuentas[382] = ['BAROCIO*HERNANDEZ*CECILIA',(string)'410005468','83.33','97','216','1177'];
          $Acuentas[383] = ['BAROCIO*HERNANDEZ*CECILIA',(string)'410005468','100','703','216','1623'];
          $Acuentas[384] = ['JIMENEZ*VICTORIA*JULIAN',(string)'410005640','100','5','213','1172'];
          $Acuentas[385] = ['MIRANDA*RUIZ*MANUEL',(string)'410020579','79.15','14','202','1117'];
          $Acuentas[386] = ['PARRA*ARAMBURO*ABRAHAM',(string)'410094358','101.44','13','413','1666'];
          $Acuentas[387] = ['MEJIA*VALENZUELA*MARIANO',(string)'411005636','83.33','97','216','1177'];
          $Acuentas[388] = ['MEJIA*VALENZUELA*MARIANO',(string)'411005636','100','703','216','1623'];
          $Acuentas[389] = ['GOMEZ*SANDOVAL*LEOPOLDO',(string)'411010988','83.33','97','216','1177'];
          $Acuentas[390] = ['GOMEZ*SANDOVAL*LEOPOLDO',(string)'411010988','100','703','216','1623'];
          $Acuentas[391] = ['DE LA ROSA*AGUILAR*ITZEL',(string)'411025539','83.33','97','216','1177'];
          $Acuentas[392] = ['MORENO*VAZQUEZ*CASANDRA',(string)'411043892','83.33','97','216','1177'];
          $Acuentas[393] = ['MORENO*VAZQUEZ*CASANDRA',(string)'411043892','100','703','216','1623'];
          $Acuentas[394] = ['AGUILERA*LARA*JAHZEEL',(string)'411051217','83.33','97','216','1177'];
          $Acuentas[395] = ['AGUILERA*LARA*JAHZEEL',(string)'411051217','100','703','216','1623'];
          $Acuentas[396] = ['MEDRANO*LUCAS*SARA LAURENT',(string)'411052221','80','97','216','1177'];
          $Acuentas[397] = ['MEDRANO*LUCAS*SARA LAURENT',(string)'411052221','100','703','216','1623'];
          $Acuentas[398] = ['BAUTISTA*REYES*ANDREA GUADALUPE',(string)'411068082','76.66','97','216','1177'];
          $Acuentas[399] = ['BAUTISTA*REYES*ANDREA GUADALUPE',(string)'411068082','100','703','216','1623'];
          $Acuentas[400] = ['BARRIGA*GUIJARRO*DANIELLE ESTEFANIA',(string)'411070364','83.33','97','216','1177'];
          $Acuentas[401] = ['BARRIGA*GUIJARRO*DANIELLE ESTEFANIA',(string)'411070364','100','703','216','1623'];
          $Acuentas[402] = ['SAENZ*CEJA*JESUS EDUARDO',(string)'411073066','83.33','97','216','1177'];
          $Acuentas[403] = ['SAENZ*CEJA*JESUS EDUARDO',(string)'411073066','100','703','216','1623'];
          $Acuentas[404] = ['DIAZ*ROCHA*PATRICIA',(string)'411101752','83.33','97','216','1177'];
          $Acuentas[405] = ['DIAZ*ROCHA*PATRICIA',(string)'411101752','100','703','216','1623'];
      return $Acuentas;
    }
}
