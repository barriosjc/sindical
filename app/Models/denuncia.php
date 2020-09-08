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

    public function getFechaNacAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getFechaIngresoSindAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getFechaEgresoSindAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    //----------------------------------------------------------------------------------
    public function getDocumPendienteyAttribute()
    {
        $resu = $this->docum_pendiente;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getDocumEntregadayAttribute()
    {
        $resu = $this->docum_entregada;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaNacyAttribute()
    {
        $resu = $this->fecha_nac;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaIngresoSindyAttribute()
    {
        $resu = $this->fecha_ingreso_sind;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaEgresoSindyAttribute()
    {
        $resu = $this->fecha_egreso_sind;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaVencDiscayAttribute()
    {
        $resu = $this->fecha_venc_disca;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    //--------------------------------------------------------------------
    public function afiliados()
    {
        return $this->belongsTo('App\Models\afiliado');
    }

    public function tipos_parentescos()
    {
        return $this->belongsTo('App\Models\tipo_parentesco', 'tipo_parentesco_id', 'id');
    }

    public function documentos()
    {
        return $this->belongsTo('App\Models\gf_documento', 'grupo_familiar_id', 'id');
    }
}
