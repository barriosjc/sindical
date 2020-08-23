<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class afil_pregunta extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'afil_preguntas';

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
            'pregunta_id',
            'respuesta',
            'obs'
    ];

    public function preguntas()
    {
        return $this->hasMany('App\Models\pregunta', 'pregunta_id', 'id');
    }
    
}
