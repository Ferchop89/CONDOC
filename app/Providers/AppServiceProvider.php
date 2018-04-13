<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
      // Data de estructura del menu + items de rutas por role del usuarios autenticado
      view()->composer('layouts.app', function($view) {
        $view ->with([
          'menus' => Menu::menus() ,
          'items_role' => Menu::items()
        ]);
        // $view->with('menus', Menu::menus());
      });    
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
