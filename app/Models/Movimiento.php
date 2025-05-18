<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Movimiento extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'denominacion',
        'fecha',
        'importe',
        'tipo_movimiento',
        'id_usuario',
        'id_categoria',
        'forma_pago',
        'estado',
        'observaciones'

    ];
    protected $table = 'movimientos';

    public function Categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'id_categoria');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }

    public function setFechaAttribute($value)
    {
        if (trim($value) !== '') {
            $p = new Carbon($value);
            $p = $p->format('Y-m-d');
        } else {
            $p = null;
        }
        $this->attributes['fecha'] = $p;
    }

    public function getFechaAttribute($value)
    {
        $value = $value !== null ? new Carbon($value) : null;
        $value = $value !== null ? $value->format('d-m-Y') : null;

        return $value;
    }

    public static function search(Request $request)
    {
        $query = Movimiento::query();

        if (isset($request->fec_desde)) {
            $fecha_d = new Carbon($request->fec_desde);
            $query = $query->where('fecha', '>=', $fecha_d->format('Y-m-d'));
        }

        if (isset($request->fec_hasta)) {
            $fecha_h = new Carbon($request->fec_hasta);
            $query = $query->where('fecha', '<=', $fecha_h->format('Y-m-d'));
        }


        if (isset($request->id_categoria)) {
            $query = $query->where('id_categoria', '=', $request->id_categoria);
        }

        if (isset($request->estado)) {
            $query = $query->where('estado', '=', $request->estado);
        }
        if (isset($request->id_usuario)) {
            $query = $query->where('id_usuario', '=', $request->id_usuario);
        }


        return  $query = $query->orderby('id', 'desc');
    }
}
