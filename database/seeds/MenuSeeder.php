<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
       {
         // seed del menú. genera opciones de ruta falsas de middleware.
           $m1 = factory(Menu::class)->create([
               'name' => 'Licenciatura',
               'slug' => 'opcion1',
               // 'ruta' => 'o1',
               'ruta' => '#',
               'parent' => 0,
               'order' => 0,
               'is_structure' => 1
           ]);
           $m2 = factory(Menu::class)->create([
               'name' => 'Posgrado',
               'slug' => 'opcion2',
               // 'ruta' => 'o2',
               'ruta' => '#',
               'parent' => 0,
               'order' => 1,
               'is_structure' => 1
           ]);
           $m3 = factory(Menu::class)->create([
               'name' => 'Usuarios',
               'slug' => 'opcion3',
               // 'ruta' => 'o3',
               'ruta' => '#',
               'parent' => 0,
               'order' => 2,
               'is_structure' => 1
           ]);
           $m4 = factory(Menu::class)->create([
               'name' => 'Tablero de Control',
               'slug' => 'opcion4',
               // 'ruta' => 'o4',
               'ruta' => '#',
               'parent' => 0,
               'order' => 3,
               'is_structure' => 1
           ]);
           // Opciones de Submenú...
           $m100 = factory(Menu::class)->create([
               'name' => 'Revisión de Estudios Profesionales',
               'slug' => 'opcion-1.1',
               'ruta' => '',
               'parent' => $m1->id,
               'order' => 0,
               'is_structure' => 1
           ]);
           factory(Menu::class)->create([
               'name' => 'Bandeja de Solicitudes',
               'slug' => 'opcion-1.1.1',
               'parent' => $m100->id,
               'ruta' => 'cortes',
               'order' => 0,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Listados',
               'slug' => 'opcion-1.1.2',
               'ruta' => 'listas',
               'parent' => $m100->id,
               'order' => 1,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Certificado Global',
               'slug' => 'opcion-1.1.3',
               'ruta' => 'datos-personales',
               'parent' => $m100->id,
               'order' => 2,
               'is_structure' => 0
           ]);
           $m200 = factory(Menu::class)->create([
               'name' => 'AGUNAM',
               'slug' => 'opcion-1.2',
               'ruta' => '',
               'parent' => $m1->id,
               'order' => 1,
               'is_structure' => 1
           ]);
           factory(Menu::class)->create([
               'name' => 'Solicitud y Recepción de Expedientes',
               'slug' => 'opcion-1.2.1',
               'parent' => $m200->id,
               'ruta' => 'AGUNAM',
               'order' => 0,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Expedientes no encontrados en AGUNAM',
               'slug' => 'opcion-1.2.2',
               'parent' => $m200->id,
               'ruta' => 'agunam/expedientes_noagunam',
               'order' => 1,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Recepción de Expedientes por Alumno',
               'slug' => 'opcion-1.3',
               'parent' => $m1->id,
               'ruta' => 'recepcion',
               'order' => 2,
               'is_structure' => 0
           ]);
           // factory(Menu::class)->create([
           //     'name' => 'm2',
           //     'slug' => 'opcion-2.1',
           //     'parent' => $m2->id,
           //     'ruta' => 'm2',
           //     'order' => 0,
           //     'is_structure' => 0
           // ]);
           // factory(Menu::class)->create([
           //     'name' => 'm6',
           //     'slug' => 'opcion-2.2',
           //     'parent' => $m2->id,
           //     'ruta' => 'm6',
           //     'order' => 1,
           //     'is_structure' => 0
           // ]);
           factory(Menu::class)->create([
               'name' => 'm9',
               'slug' => 'opcion-2.3',
               'parent' => $m2->id,
               'ruta' => 'm9',
               'order' => 2,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'm7',
               'slug' => 'opcion-3.1',
               'ruta' => 'm7',
               'parent' => $m3->id,
               'order' => 0,
               'is_structure' => 0
           ]);
           $m32 = factory(Menu::class)->create([
               'name' => 'Opción 3.2',
               'slug' => 'opcion-3.2',
               'ruta' => '',
               'parent' => $m3->id,
               'order' => 1,
               'is_structure' => 1
           ]);
           factory(Menu::class)->create([
               'name' => 'Solicitudes de Revisión de Estudio',
               'slug' => 'opcion-4.1',
               'ruta' => 'graficas',
               'parent' => $m4->id,
               'order' => 0,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'm8',
               'slug' => 'opcion-4.2',
               'ruta' => 'm8',
               'parent' => $m4->id,
               'order' => 1,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Ver usuarios',
               'slug' => 'opcion-3.2.3',
               'ruta' => 'admin/usuarios',
               'parent' => $m32->id,
               'order' => 0,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Crear usuario',
               'slug' => 'opcion-3.2.1',
               'ruta' => 'admin/usuarios/nuevo',
               'parent' => $m32->id,
               'order' => 1,
               'is_structure' => 0
           ]);
           factory(Menu::class)->create([
               'name' => 'Editar usuarios',
               'slug' => 'opcion-3.2.2',
               'ruta' => 'admin/otra',
               'parent' => $m32->id,
               'order' => 2,
               'is_structure' => 0
           ]);
       }
}
