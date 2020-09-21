<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class den_documento_cab extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'den_documentos_cab';

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
        'denuncia_id',
        'tipo_documento_id'
    ];

    public function denuncias()
    {
        return $this->belongsTo('App\Models\denuncias', 'denuncia_id', 'id');
    }

    public function documentos_det()
    {
        return $this->hasMany('App\Models\den_documento_det', 'documento_cab_id', 'id');
    }

    public function tipos_documentos()
    {
        return $this->belongsTo('App\Models\tipo_documento', 'tipo_documento_id', 'id');
    }
}
