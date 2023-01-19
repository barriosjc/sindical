<?php

namespace App\models;

use DateTime;
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
        'path',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_last_name'
    ];
    protected $appends = array('entregado','edad');
    public function getEntregadoAttribute($value)
    {
        $resu = (gf_escolaridad::where('grupo_familiar_id', $this->id)->where('ciclo_lectivo',  now()->year)->count() > 0);

        return $resu;
    }    
    
    public function getEdadCAttribute($value)
    {
        // fecha = $(this).val();
        $fecha = $this->fecha_nac;
        $fecha = substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2);
        $hoy = new DateTime();
        $cumpleanos = new DateTime($fecha);
        $edad = $hoy->format("Y") - $cumpleanos->format("Y");
        $m = $hoy->format("m") - $cumpleanos->format("m");

        if ($m < 0 || ($m === 0 && $hoy->format("d") < $cumpleanos->format("d") )) {
            $edad = $edad - 1;
        }
        return $edad;
    }

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
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getDocumEntregadayAttribute()
    {
        $resu = $this->docum_entregada;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaNacyAttribute()
    {
        $resu = $this->fecha_nac;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaIngresoSindyAttribute()
    {
        $resu = $this->fecha_ingreso_sind;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaEgresoSindyAttribute()
    {
        $resu = $this->fecha_egreso_sind;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    public function getFechaVencDiscayAttribute()
    {
        $resu = $this->fecha_venc_disca;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
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

    public function gf_escolaridad()
    {
        return $this->belongsTo('App\Models\gf_escolaridad', 'grupo_familiar_id', 'id');
    }
}
