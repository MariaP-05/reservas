<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabania;
use App\Models\Precio;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class PrecioController extends Controller
{
    public function index()
    {        
      //  $this->fix_precios();
        $precios = Precio::all();

        return view('admin.precios.index', compact('precios'));
    }

    public function create()
    {        
        $cabanias = Cabania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $cabanias = array('' => trans('message.select')) + $cabanias;

        return view('admin.precios.edit', compact('cabanias'));
    }

    public function store(Request $request)
    {
        try {
            $precio = new Precio($request->all());
            $precio->save();
           
            return redirect()->route('admin.precios.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {          
            return redirect()->route('admin.precios.index')->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $precio = Precio::findOrFail($id);

        $cabanias = Cabania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $cabanias = array('' => trans('message.select')) + $cabanias;
        
        return view('admin.precios.edit', compact('precio','cabanias'));
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
            $precio = Precio::findOrFail($id);

            $precio->id_cabania = $request->id_cabania;
            $precio->fecha_desde = $request->fecha_desde;
            $precio->valor = $request->valor;  
            $precio->valor_dolar = $request->valor_dolar;            

            $precio->save();
              
            return redirect()->route('admin.precios.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {          
            return redirect()->route('admin.precios.index')->with('error', $ex->getMessage());
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
            Precio::destroy($id);
                   
            return redirect()->route('admin.precios.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {          
            return redirect()->route('admin.precios.index')->with('error', $ex->getMessage());
        }
    }


    public function fix_precios( )
    {
        $precios = Precio::whereNull('valor_dolar')->get();
        foreach ($precios as $precio) {
            $valor = ($precio->valor * 1.18 ) / 1400;
            $precio->valor_dolar =$valor;
            $precio->save();   
        }
              $precios2 = Precio::where('valor_dolar',0)->get();
        foreach ($precios2 as $precio) {
            $valor = ($precio->valor * 1.18 ) / 1400;
            $precio->valor_dolar =$valor;
            $precio->save();   
        } 
                   
           
    }
    
   
}
