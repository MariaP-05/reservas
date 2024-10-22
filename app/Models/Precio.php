<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
 
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Precio extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'id_cabania', 'fecha_desde', 'valor'  ];

    protected $table = 'precios';


    public function Cabania()
    {
        return $this->belongsTo('App\Models\Cabania', 'id_cabania');
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

}
