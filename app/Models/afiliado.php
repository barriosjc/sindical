<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class afiliado extends Model
{
    use SoftDeletes;
    
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'afiliados';

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
            'apellido_nombres',
            'calle',
            'calle_nro',
            'calle_piso',
            'calle_obs',
            'localidad_id',
            'provincia_id',
            'tipo_documento_id',
            'nro_doc',
            'fecha_nac',
            'telefono1',
            'email',
            'sexo',
            'nacionalidad_id',
            'estado_civil_id',
            'nro_afil_sindical',
            'fecha_vigencia',
            'fecha_ingreso',
            'fecha_egreso',
            'motivo_egreso_id',
            'empresa_id',
            'cuil',
            'seccional_id',
            'obra_social_id',
            'nro_legajo',
            'nro_ben_anses',
            'SOC_USUARIO',
            'fecha_vigencia_os',
            'fecha_ingreso_os',
            'fecha_egreso_os',
            'motivo_egreso_os_id',
            'discapacitado',
            'afil_estado_ficha_id',
            'obs_gral',
            'docum_pendiente',
            'docum_entregada',
            'fecha_jubilacion',
            'categoria_id',
            'especialidad_id',
            'fecha_ing_empr',
            'fecha_egr_empr',
            'SOC_CONT_ID',
            'delegado_desde',
            'delegado_hasta',
            'user_last_name'
    ];

    public function afil_estado_fichas()
    {
        return $this->HasMany('App\Models\afil_estado_ficha');
    }
    
}
