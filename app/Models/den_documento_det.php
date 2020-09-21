<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class den_documento_det extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'den_documentos_det';

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
            'documento_cab_id',
            'path',
            'obs',
            'fecha_vencimiento',
            'hoja'
    ];

    public function documentos_cab()
    {
        return $this->belongsTo('App\Models\den_documento_cab', 'documentos_cab_id', 'id');
    }
    
}
