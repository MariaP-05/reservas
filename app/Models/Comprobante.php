<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Comprobante extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero',
        'fecha',
        'numero_cae',
        'fecha_vencimiento_cae',
        'punto_venta',
        'observaciones',
        'id_reserva'     ,
        'id_tipo_comprobante',
        'id_estado_comprobante',
        'valor',
         'archivo_pdf'
    ];
    protected $table = 'comprobantes';

    
    public function Reserva()
    {
        return $this->belongsTo('App\Models\Reserva', 'id_reserva');
    }

     public function TipoComprobante()
    {
        return $this->belongsTo('App\Models\Tipo_comprobante', 'id_tipo_comprobante');
    }

     public function EstadoComprobante()
    {
        return $this->belongsTo('App\Models\Estado_comprobante', 'id_estado_comprobante');
    }

     public function setFechaAttribute($value)
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
        $this->attributes['fecha']=$p;
    }

    public function getFechaAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d/m/Y') : null;
      
        return $value;
    }

      public function setFechaVencimientoCaeAttribute($value)
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
        $this->attributes['fecha_vencimiento_cae']=$p;
    }

    public function getFechaVencimientoCaeAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d/m/Y') : null;
      
        return $value;
    }
}