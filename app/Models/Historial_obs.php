<?php


namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Http\Request;


class Historial_obs extends Model
{
    use SoftDeletes;


   
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *  Schema::create('sesiones', function (Blueprint $table) {
     


     */
    protected $fillable = [ 'id_tarea','id_usuario', 'observaciones', 'fecha'];


    protected $table = 'historial_observaciones';


   
 
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }

    public function Tarea()
    {
        return $this->belongsTo('App\Models\Tarea', 'id_tarea');
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
        $value = $value !== null ? $value->format('d-m-Y') : null;
     
        return $value;
    }
 
   
   


}
