<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipo_documento extends Model
{
    use SoftDeletes;
    
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipos_documentos';

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
            'descripcion',
            'tipo',
            'obliga'
    ];

    public function afil_documentos()
    {
        return $this->hasMany('App\Models\afil_documento', 'tipo_documento_id', 'id');
    }

    public function gf_documentos()
    {
        return $this->hasMany('App\Models\gf_documento', 'tipo_documento_id', 'id');
    } 

    public function empr_documentos()
    {
        return $this->hasMany('App\Models\empr_documento', 'tipo_documento_id', 'id');
    }    
}
