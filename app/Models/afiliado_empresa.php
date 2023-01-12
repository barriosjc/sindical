<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class afiliado_empresa extends Model
{
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'afiliados_empresas';

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
        'empresa_id',
        'fecha_ingreso',
        'fecha_egreso',
        'motivo_egreso_id',
        'seccional_id',
        'categoria_id',
        'especialidad_id',
        'fecha_ing_empr',
        'fecha_egr_empr',
        'delegado_desde',
        'delegado_hasta',
        'user_last_name'
    ];

    public function getFechaEgresoAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getFechaIngresoAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getFechaIngEmprAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getFechaEgrEmprAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getDelegadoDesdeAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    public function getDelegadoHastaAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }
    //este formato para mostrarlo en un form -------------------------------------------
    public function getFechaIngresoyAttribute()
    {
        $resu = $this->fecha_ingreso;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    
    public function getFechaEgresoyAttribute()
    {
        $resu = $this->fecha_egreso;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }

    public function getFechaIngEmpryAttribute()
    {
        $resu = $this->fecha_ing_empr;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }

    public function getFechaEgrEmpryAttribute()
    {
        $resu = $this->fecha_egr_empr;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }

    public function getDelegadoDesdeyAttribute()
    {
        $resu = $this->delegado_desde;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    
    public function getDelegadoHastayAttribute()
    {
        $resu = $this->delegado_hasta;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }

    // -----------------------------------------------------------------------------------
    public function empresas()
    {
        return $this->belongsTo('App\Models\empresa', 'empresa_id', 'id');
    }    
    public function seccionales()
    {
        return $this->belongsTo('App\Models\seccional', 'seccional_id', 'id');
    }
    public function motivo_egreso_sind()
    {
        return $this->belongsTo('App\Models\motivo_egreso_sind', 'motivo_egreso_id', 'id');
    }

    
}
