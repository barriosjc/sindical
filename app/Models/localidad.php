<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class localidad extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'localidades';

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
            'nombre',
            'cod_postal',
            'provincia_id'
    ];

    public function afiliados()
    {
        return $this->belongsTo('App\Models\afiliado');
    }
    
    public function provincias()
    {
        return $this->belongsTo('App\Models\provincia');
    }
    
}
