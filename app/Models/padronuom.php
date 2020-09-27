<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class padronuom extends Model
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'padronuom';

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
            'cuit_empr',
            'cuil_titu',
            'cuil_fam',
            'tipo_doc',
            'nro_doc',
            'nombre',
            'sexo'
    ];

    // public function afiliados()
    // {
    //     return $this->belongsTo('App\Models\afiliado');
    // }
    
    // public function provincias()
    // {
    //     return $this->belongsTo('App\Models\provincia');
    // }
    
}
