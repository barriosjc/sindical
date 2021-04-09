<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class motivo_egreso_sind extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'motivos_egresos_sind';

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
            'descripcion'
    ];

    protected $appends = ['tooltips'];
    public function getTooltipsAttribute()
    {
        $resu = empty($this->tooltip) ? " " : $this->tooltip;

        return $resu;
    }

    public function afiliado_empresa()
    {
        return $this->hasMany('App\Models\afiliado_empresa', 'motivo_egreso_id', 'id');
    }
    
}
