<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Tarea extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'denominacion', 'fecha', 'descripcion','prioridad', 'id_estado_tarea',
    'id_usuario' , 'observaciones'];
      
    protected $table = 'tareas';

    public function Estado_tarea()
    {
        return $this->belongsTo('App\Models\Estado_tarea', 'id_estado_tarea');
    }
    public function Historial_obs()
    {
        return $this->hasMany('App\Models\Historial_obs', 'id_tarea');
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
        $query = Tarea::query();

        if (isset($request->fec_desde)) {
            $fecha_d = new Carbon($request->fec_desde);
            $query = $query->where('fecha', '>=', $fecha_d->format('Y-m-d'));
        }

        if (isset($request->fec_hasta)) {
            $fecha_h = new Carbon($request->fec_hasta);
            $query = $query->where('fecha', '<=', $fecha_h->format('Y-m-d'));
        }
 

        if (isset($request->estado)) {
            $query = $query->where('id_estado_tarea', '=', $request->estado);
        }
        if (isset($request->id_usuario)) {
            $query = $query->where('id_usuario', '=', $request->id_usuario);
        }


        return  $query = $query->orderby('id', 'desc');
    }
}
