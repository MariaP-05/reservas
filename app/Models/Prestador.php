<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestador extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'nombre' , 'cuit', 'cert', 'key', 'token', 'iva' , 'razon_social', 'domicilio', 
    'iva_denominacion','fecha_inicio_actividad'];

    protected $table = 'prestadores';

     
  
    public function Comprobantes()
    {
        return $this->hasMany('App\Models\Comprobante', 'id_prestador');
    }
     public function Reservas()
    {
        return $this->hasMany('App\Models\Reserva', 'id_prestador');
    }

}
