<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class padronuom extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'padronuom';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cuit_empr',
        'cuil_titu',
        'parentesco_id',
        'cuil_fam',
        'tipo_doc',
        'nro_doc',
        'nombre',
        'sexo',
        'est_civil',
        'fecha_nac',
        'nacionalidad_id',
        'direccion',
        'direccion_nro',
        'direccion_piso',
        'direccion_depto',
        'localidad',
        'cod_postal',
        'provincia_id',
        'telefono',
        'discapacitado',
        'tipo_afiliado_id',
        'fecha_alta_os',
        'seccional_id',
        'seccional',
        'ult_pago',
        'estado'   
    ];

    // public function afiliados()
    // {
    //     return $this->belongsTo('App\Models\afiliado');
    // }
    
    // public function provincias()
    // {
    //     return $this->belongsTo('App\Models\provincia');
    // }

    public static function difAfiliadoPadron()
    {
        $resu = afiliado::query()
        ->leftjoin('padron_uom as p', 'p.')
        ->paginate(15);

        return $resu;
    }
    
}
