<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class denuncia extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'denuncias';

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
        'tipo_denuncia_id',
        'afiliado_id',
        'fecha_ingreso',
        'nombre',
        'nro_carnet',
        'direccion',
        'empresa',
        'cuit',
        'direccion_empr',
        'descripcion',
        'numero',
        'user_last_name',
        'ministerio_id',
        'numero_expediente',
        'tomo_denuncia'
    ];

    public function getFechaIngresoAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }

    //----------------------------------------------------------------------------------
    public function getFechaIngresoyAttribute()
    {
        $resu = $this->fecha_ingreso;
        if (!empty($resu)) {
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    //--------------------------------------------------------------------
    public function tipos_denuncias()
    {
        return $this->belongsTo('App\Models\den_tipo_denuncia', 'tipo_denuncia_id', 'id');
    }

    public function denuncias_det()
    {
        return $this->hasMany('App\Models\denuncias_det', 'denuncia_id', 'id');
    }

    public function den_ministerios()
    {
        return $this->belongsTo('App\Models\den_ministerio', 'ministerio_id', 'id');
    }

}
