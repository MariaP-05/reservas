<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Productor extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo', 'nombre','matricula'];

    protected $table = 'productores';

    public function Polizas()
    {
        return $this->hasMany('App\Models\Poliza', 'id_productor');
    }
}
