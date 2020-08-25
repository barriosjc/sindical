<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class grupo_familiar extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grupo_familiar';

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
        'afiliado_id',
        'nro_grupo_fam',
        'apellido_nombres',
        'tipo_documento_id',
        'nro_doc',
        'fecha_nac',
        'sexo',
        'edad',
        'tipo_parentesco_id',
        'cuil',
        'calle',
        'calle_nro',
        'calle_piso',
        'calle_obs',
        'cod_postal',
        'localidad_id',
        'provincia_id',
        'telefonos',
        'fecha_ingreso_sind',
        'fecha_egreso_sind',
        'motivo_egreso_sind_id',
        'discapacitado',
        'fecha_venc_disca',
        'estado_civil_id',
        'nacionalidad_id',
        'docum_pendiente',
        'docum_entregada',
        'obs',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_last_name'
    ];

    public function afiliados()
    {
        return $this->belongsTo('App\Models\afiliado');
    }

    public function tipos_parentescos() {

        return $this->belongsTo('App\Models\tipo_parentesco', 'tipo_parentesco_id', 'id');

        }

}
