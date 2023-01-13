<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class denuncia_det extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'denuncias_det';

     /* The database primary key value.
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
        'denuncia_id',
        'fecha',
        'tipo_movimiento_id',
        'obs',
        'user_last_name'
    ];

    public function getFechaAttribute($value)
    {
        $resu = '';
        if (!empty($value)) {
            $resu = date('d/m/Y', strtotime($value));
        }

        return $resu;
    }

    //----------------------------------------------------------------------------------
    public function getFechayAttribute()
    {
        $resu = $this->fecha;
        if (!empty($resu)) {
            $resu = substr($resu,6,4)."-".substr($resu,3,2)."-".substr($resu,0,2);
            $resu = date(env('DATE_FORM', 'Y-m-d'), strtotime($resu));
        }

        return $resu;
    }
    //--------------------------------------------------------------------
    public function tipos_movimientos()
    {
        return $this->belongsTo('App\Models\den_tipo_movimiento', 'tipo_movimiento_id', 'id');
    }

    public function denuncias()
    {
        return $this->belongsTo('App\Models\denuncia', 'denuncia_id', 'id');
    }

}
