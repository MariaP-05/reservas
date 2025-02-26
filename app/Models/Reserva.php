<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Reserva extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'id_cabania', 'id_cliente', 'id_forma_pago','ctabancaria', 'id_estado_reserva',
    'fecha_desde' , 'fecha_hasta' , 'hora_ingreso', 'hora_egreso' ,
      'cantidad_personas', 'senia',  'descuento', 'observaciones' , 'valor','recargo', 'motivos_recargos' ];
      
    protected $table = 'reservas';


    public function Forma_pago()
    {
        return $this->belongsTo('App\Models\Forma_pago', 'id_forma_pago');
    }

    public function Cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'id_cliente');
    }
    
    public function Cabania()
    {
        return $this->belongsTo('App\Models\Cabania', 'id_cabania');
    }

    public function Estado_reserva()
    {
        return $this->belongsTo('App\Models\Estado_reserva', 'id_estado_reserva');
    }

    public function setFechaDesdeAttribute($value)
    {
        if(trim($value) !== '')
        {
            $p = new Carbon($value);
            $p = $p->format('Y-m-d');
        }
        else
        {
            $p = null;
        }
        $this->attributes['fecha_desde']=$p;
    }
    public function getFechaDesdeAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d-m-Y') : null;
      
        return $value;
    }

    public function setFechaHastaAttribute($value)
    {
        if(trim($value) !== '')
        {
            $p = new Carbon($value);
            $p = $p->format('Y-m-d');
        }
        else
        {
            $p = null;
        }
        $this->attributes['fecha_hasta']=$p;
    }

    public function getFechaHastaAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d-m-Y') : null;
      
        return $value;
    }

    
    public static function search(Request $request) 
    {
        $query = Reserva::query(); 


        if (isset($request->id_cliente)){
            $query= $query->where('id_cliente', '=' , $request->id_cliente); 
        }


        if (isset($request->id_estado_reserva)){
            $query= $query->where('id_estado_reserva', '=' , $request->id_estado_reserva); 
        } 

        return $query;
    }
}
