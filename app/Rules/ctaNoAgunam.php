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
      // si no tienen un listado y corte, no pasa la validación

      $cortes = DB::table('cortes')
            ->Join('agunam', function ($j) {
                    $j->on('cortes.listado_corte', '=', 'agunam.listado_corte')
                    ->on('cortes.listado_id', '=', 'agunam.listado_id');
                    })
            ->join('solicitudes','cortes.solicitud_id','solicitudes.id')
            ->select('agunam.listado_corte','agunam.listado_id') // example, select what you need
            ->where('solicitudes.cuenta',$value)
            ->get()->toArray();;

      return ($cortes!=[])? true: false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El expediente no fue solicitado a  AGUNAM';
    }
}
