<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Poliza extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'id_compania', 'id_cliente', 'id_seccion' , 'numero_poliza',
    'id_estado_polizas','vigencia_desde' , 'vigencia_hasta' , 'dominio', 
      'vehiculo' , 'marca' , 'id_forma_pago'  , 'cantidad_cuotas',
       'id_productor',  'cobertura'
    
    ];
    protected $table = 'polizas';

    
    public function Seccion()
    {
        return $this->belongsTo('App\Models\Seccion', 'id_seccion');
    }

    public function Forma_pago()
    {
        return $this->belongsTo('App\Models\Forma_pago', 'id_forma_pago');
    }

    public function Productor()
    {
        return $this->belongsTo('App\Models\Productor', 'id_productor');
    }

    public function Cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'id_cliente');
    }
    
    public function Compania()
    {
        return $this->belongsTo('App\Models\Compania', 'id_compania');
    }

    public function Estado_poliza()
    {
        return $this->belongsTo('App\Models\Estado_poliza', 'id_estado_polizas');
    }

    public function setVigenciaDesdeAttribute($value)
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
        $this->attributes['vigencia_desde']=$p;
    }
    public function getVigenciaDesdeAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d-m-Y') : null;
      
        return $value;
    }

    public function setVigenciaHastaAttribute($value)
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
        $this->attributes['vigencia_hasta']=$p;
    }

    public function getVigenciaHastaAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d-m-Y') : null;
      
        return $value;
    }

    
    public static function search(Request $request) 
    {
        $query = Poliza::query(); 


        if (isset($request->id_cliente)){
            $query= $query->where('id_cliente', '=' , $request->id_cliente); 
        }

        if (isset($request->numero_poliza)){
            $query= $query->where('numero_poliza', 'like' , '%'.$request->numero_poliza.'%'); 
        }

        if (isset($request->id_estado_polizas)){
            $query= $query->where('id_estado_polizas', '=' , $request->id_estado_polizas); 
        } 

        if (isset($request->dominio)){
            $query= $query->where('dominio', 'like' , '%'.$request->dominio.'%'); 
        }
        return  $query = $query->orderby('id', 'desc') ;
    }
}
