<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poliza;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $fecha_mes = new Carbon();
        $fecha_mes -> addDays(-30);

        $cantidad_vigentes = Poliza::where('id_estado_polizas', 1)
        -> where('vigencia_desde','>=', $fecha_mes->format('Y-m-d'))
        ->count();

        $cantidad_canceladas = Poliza::where('id_estado_polizas', 2)
        -> where('vigencia_desde','>=', $fecha_mes->format('Y-m-d'))
        ->count();

        $cantidad_renovadas = Poliza::where('id_estado_polizas', 3)
        -> where('vigencia_desde','>=', $fecha_mes->format('Y-m-d'))
        ->count();

        $cantidad_vencidas = Poliza::where('id_estado_polizas', 4)
        -> where('vigencia_desde','>=', $fecha_mes->format('Y-m-d'))
        ->count();

        $fecha_quince = new Carbon();
        $fecha_quince -> addDays(15);

        $cantidad_xvencer = Poliza::where('id_estado_polizas', 4)
        -> where('vigencia_hasta','<=', $fecha_quince->format('Y-m-d'))
        ->count();

        return view('admin.dashboard', compact('cantidad_vigentes','fecha_mes' , 'cantidad_canceladas', 
        'cantidad_renovadas', 'cantidad_vencidas', 'cantidad_xvencer', 'fecha_quince'));
    }
}