<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class provincia extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'provincias';

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
            'nombre'
    ];

    public function afiliados()
    {
        return $this->belongsTo('App\Models\afiliado');
    }

    public function localidades()
    {
        return $this->belongsTo('App\Models\localidad');
    }
    
}
