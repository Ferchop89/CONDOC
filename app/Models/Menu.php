<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  public function getChildren($data, $line)
  {
      $children = [];
      foreach ($data as $line1) {
          if ($line['id'] == $line1['parent']) {
              $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
          }
      }
      return $children;
  }

  public function optionsMenu()
  {
    // devuelve los 12 registros de la tabla  menu
      return $this->where('enabled', 1)
          ->orderby('parent')
          ->orderby('order')
          ->orderby('name')
          ->get()
          ->toArray();
  }

  public static function menus()
  {
      // devuelve opciones con subopciones de menu
      $menus = new Menu();
      $data = $menus->optionsMenu();
      $menuAll = [];
      foreach ($data as $line) {
          $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
          $menuAll = array_merge($menuAll, $item);
      }
      return $menus->menuAll = $menuAll;
  }

}
