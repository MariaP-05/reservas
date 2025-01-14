<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caracteristica;
use App\Models\Caracteristica_cab;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class CaracteristicaController extends Controller
{
    public function index()
    {        
        $caracteristicas = Caracteristica::all();

        return view('admin.caracteristicas.index', compact('caracteristicas'));
    }

    public function create()
    {
            return view('admin.caracteristicas.edit');
    }

    public function store(Request $request)
    {

        try {
            $caracteristica = new Caracteristica($request->all());


            $caracteristica->save();

           ;
            return redirect()->route('admin.caracteristicas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            
            return redirect()->route('admin.caracteristicas.index')->with('error', $ex->getMessage());
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
        $caracteristica = Caracteristica::findOrFail($id);

        $caracteristicas = Caracteristica::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $caracteristicas = array('' => trans('message.select')) + $caracteristicas;

        
        return view('admin.caracteristicas.edit', compact('caracteristica','caracteristicas'));
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
            $caracteristica = Caracteristica::findOrFail($id);


            $caracteristica->denominacion = $request->denominacion;
            
            

            $caracteristica->save();

           
            return redirect()->route('admin.caracteristicas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {

           
            return redirect()->route('admin.caracteristicas.index')->with('error', $ex->getMessage());
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
            $caracteristicas = Caracteristica_cab::where('id_caracteristica', $id)->count();
            
            if ($caracteristicas == 0) {
            Caracteristica::destroy($id);

            return redirect()->route('admin.caracteristicas.index')->with('success', trans('message.successaction'));
        } else {
            return redirect()->route('admin.caracteristicas.index')->with('error', '¡Error! La Característica es parte de una Cabaña, no se puede eliminar.');
        }
        
        } catch (QueryException  $ex) {
            
            return redirect()->route('admin.caracteristicas.index')->with('error', $ex->getMessage());
        }
    }
   
}
