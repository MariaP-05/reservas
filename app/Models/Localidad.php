<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Localidad extends Model
{
    use SoftDeletes;

    
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable. fff
     *
     * @var array<int, string>
     */
    protected $fillable = ['denominacion','cod_postal','provincia_id'
        
    ];
    protected $table = 'localidades';

    public function Provincia()
    {
        return $this->belongsTo('App\Provincia', 'provincia_id');
    }
}
