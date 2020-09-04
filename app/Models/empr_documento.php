<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class empr_documento extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'empr_documentos';

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
            'empresa_id',
            'tipo_documento_id',
            'path',
            'obs',
            'fecha_vencimiento'
    ];

    public function empresas()
    {
        return $this->hasMany('App\Models\empresas', 'empresa_id', 'id');
    }
    
}
