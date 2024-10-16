<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Compania extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo', 'denominacion' ];

    protected $table = 'companias';

    public function Polizas()
    {
        return $this->hasMany('App\Models\Poliza', 'id_compania');
    }
  
}
