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

    // este foramto para mostrarlo en la grilla --------------------------------------
    public function getFechaEgresoAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }

    //este formato para mostrarlo en un form -------------------------------------------
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
    public function getFechaIngresoyAttribute()
    {
        $resu = $this->fecha_ingreso;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaIngresoOsyAttribute()
    {
        $resu = $this->fecha_ingreso_os;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaEgresoOsyAttribute()
    {
        $resu = $this->fecha_egreso_os;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
        public function getFechaEgresoyAttribute()
    {
        $resu = $this->fecha_egreso;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaJubilacionyAttribute()
    {
        $resu = $this->fecha_jubilacion;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaIngEmpryAttribute()
    {
        $resu = $this->fecha_ing_empr;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getFechaEgrEmpryAttribute()
    {
        $resu = $this->fecha_egr_empr;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getDelegadoDesdeyAttribute()
    {
        $resu = $this->delegado_desde;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }
    public function getDelegadoHastayAttribute()
    {
        $resu = $this->delegado_hasta;
        if (!empty($resu)) {
            $resu = date('Y-m-d', strtotime($resu));
        }

        return $resu;
    }


    public function afil_estado_fichas()
    {
        return $this->HasMany('App\Models\afil_estado_ficha');
    }

    public function grupo_familiar()
    {
        return $this->HasMany('App\Models\grupo_familiar');
    }

    public function seccionales()
    {
        return $this->belongsTo('App\Models\seccional', 'seccional_id', 'id');
    }
    
    public function documentos()
    {
        return $this->hasMany('App\Models\afil_documentos', 'afiliado_id', 'id');
    }
}
