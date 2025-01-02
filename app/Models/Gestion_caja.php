<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Gestion_caja extends Model
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
        'observaciones'
        
    ];
    protected $table = 'gestiones_caja';

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

    
}
