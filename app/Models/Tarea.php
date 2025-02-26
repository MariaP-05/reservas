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
}
