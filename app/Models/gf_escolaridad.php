<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class gf_escolaridad extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gf_escolaridad';

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
            'grupo_familiar_id',
            'ciclo_lectivo',
            'nivel',
            'tipo_educacion',
            'kit_escolar',
            'delantal',
            'talle',
            'obs',
            'periodo'
    ];
    
    public function tipos_material()
    {
        return $this->belongsTo('App\Models\tipo_material', 'tipo_material_id', 'id');
    }  
    
}
