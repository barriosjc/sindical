<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class empresa extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'empresas';

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
        'seccional_id',
        'razon_social',
        'calle',
        'calle_nro',
        'calle_piso',
        'calle_obs',
        'provincia_id',
        'localidad_id',
        'cuit',
        'telefono1',
        'telefono2',
        'tipo_rama_empr_id',
        'tipo_actividad_empr_id',
        'fecha_inicio_actividad',
        'fecha_alta',
        'fecha_baja',
        'tipo_baja_empr_id',
        'novedades',
        'email2',
        'email',
        'ing_brutos',
        'fecha_ult_inspeccion',
        'obs',
        'cant_empleados',
        'cod_empresa',
        'tiene_delegado',
        'calle_adm',
        'calle_nro_adm',
        'calle_obs_adm',
        'provincia_adm_id',
        'localidad_adm_id',
        'calle_piso_adm',
        'EMPR_FECHAALTA_SIND',
        'cant_afil_sin_confirmar',
        'empresa_estado_id',
        'user_last_name'
    ];

    //este formato para mostrarlo en un form -------------------------------------------
    public function getFechaInicioActividadyAttribute()
    {
        $resu = $this->fecha_inicio_actividad;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaAltayAttribute()
    {
        $resu = $this->fecha_alta;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaBajayAttribute()
    {
        $resu = $this->fecha_baja;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaUltInspeccionyAttribute()
    {
        $resu = $this->fecha_ult_inspeccion;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    
    //-----------------------------------------------------------------------------------
    public function afiliado_empresa()
    {
        return $this->hasMany('App\Models\afiliado_empresa', 'empresa_id', 'id');
    }

    public function seccionales()
    {
        return $this->belongsTo('App\Models\seccional');
    }    

    public function tipos_actividad_empr()
    {
        return $this->belongsTo('App\Models\tipo_actividad_empr', 'tipo_actividad_empr_id', 'id');
    } 

    public function tipos_baja_empr()
    {
        return $this->belongsTo('App\Models\tipo_baja_empr', 'tipo_baja_empr_id', 'id');
    } 

    public function estados()
    {
        return $this->belongsTo('App\Models\empresa_estado', 'empresa_estado_id', 'id');
    } 

}
