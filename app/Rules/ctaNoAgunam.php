<?php

namespace App\Rules;
use App\Models\Solicitud;
use DB;

use Illuminate\Contracts\Validation\Rule;

class ctaNoAgunam implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
      // si no tienen un listado y corte, no pasa la validación u no fue solicituado en Agunam.

      $cortes = DB::table('cortes')
            ->Join('agunam', function ($j) {
                    $j->on('cortes.listado_corte', '=', 'agunam.listado_corte')
                    ->on('cortes.listado_id', '=', 'agunam.listado_id');
                    })
            ->join('solicitudes','cortes.solicitud_id','solicitudes.id')
            ->select('agunam.listado_corte','agunam.listado_id',
                     'agunam.Solicitado_at', 'agunam.Recibido_at') // example, select what you need
            ->where('solicitudes.cuenta',$value)
            ->get()->first();

      if ($cortes) { // preguntamos si existe la lista
        // Si existe el listado,  debe tener las dos fechas de recepcion y envio a AGUNAM
        return ($cortes->Solicitado_at==null || $cortes->Recibido_at==null)? false: true;
      } else {
        // No existe la lista de envio
        return false;
      }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El expediente no ha sido solicitado o recibido por parte de AGUNAM';
    }
}
