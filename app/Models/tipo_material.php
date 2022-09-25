<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipo_material extends Model
{
    use SoftDeletes;
    
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipos_material';

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

    public function gf_documentos()
    {
        return $this->hasMany('App\Models\gf_escolaridad', 'tipo_material_id', 'id');
    } 
 
}
