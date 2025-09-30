<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabania extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'denominacion' , 'capacidad', 'color' ];

    protected $table = 'cabanias';

    public function Precios()
    {
        return $this->hasMany('App\Models\Precio', 'id_cabania');
    }
  
    public function Caracteristicas()
    {
        return $this->hasMany('App\Models\Caracteristica_cab', 'id_cabania');
    }
  
    public function Reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'id_cabania');
    }

}
