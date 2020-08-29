<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class gf_documento extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gf_documentos';

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
            'tipo_documento_id',
            'path',
            'obs',
            'fecha_vencimiento'
    ];

    public function grupo_familiar()
    {
        return $this->hasMany('App\Models\grupo_familiar', 'grupo_familiar_id', 'id');
    }
    
    public function tipos_documentos()
    {
        return $this->belongsTo('App\Models\tipo_documento', 'tipo_documento_id', 'id');
    }  
    
}
