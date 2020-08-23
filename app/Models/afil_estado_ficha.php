<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class afil_estado_ficha extends Model
{
    use SoftDeletes;
    
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'afil_estado_ficha';

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

    public function afiliados()
    {
        return $this->HasMany('App\Models\afiliado');
    }
    
}
