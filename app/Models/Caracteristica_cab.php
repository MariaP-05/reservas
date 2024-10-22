<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Caracteristica_cab extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_cabania', 'id_caracteristica','cantidad'];

    protected $table = 'caracteristicas_cab';

    public function Cabania()
    {
        return $this->belongsTo('App\Models\Cabania', 'id_cabania');
    }


    public function Caracteristica()
    {
        return $this->belongsTo('App\Models\Caracteristica', 'id_caracteristica');
    }
}
