<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CotizacionMoneda;
use App\Models\Comprobante;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CotizacionMonedaController extends Controller
{
    public function index()
    {
        $cotizaciones_monedas = CotizacionMoneda::all();

        return view('admin.cotizaciones_monedas.index', compact('cotizaciones_monedas'));
    }

    public function create()
    {
        return view('admin.cotizaciones_monedas.edit');
    }

    public function store(Request $request)
    {
        try {
            $cotizacion = new CotizacionMoneda($request->all());
 
            $cotizacion->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.cotizaciones_monedas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.cotizaciones_monedas.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cotizaciones_monedas = CotizacionMoneda::findOrFail($id);     

        return view('admin.cotizaciones_monedas.edit', compact('cotizaciones_monedas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $cotizacion = CotizacionMoneda::findOrFail($id);


            $cotizacion->fecha = $request->fecha;
            $cotizacion->usd = $request->usd; 

            $cotizacion->save();

        
            return redirect()->route('admin.cotizaciones_monedas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            
            return redirect()->route('admin.cotizaciones_monedas.index')->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            //se creo una variable nueva solo para eliminar categorias que no esten en uso
            $comprobante = Comprobante::where('id_cotizacion_moneda', $id)->count();
            if ($comprobante == 0) {
                CotizacionMoneda::destroy($id);
                return redirect()->route('admin.cotizaciones_monedas.index')->with('success', trans('message.successaction'));
            } else {
                return redirect()->route('admin.cotizaciones_monedas.index')->with('error', '¡Error! La cotización está siendo utilizada, no se puede eliminar');
            }
        } catch (QueryException  $ex) {
            //session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.cotizaciones_monedas.index')->with('error', $ex->getMessage());
        }
    }
}
