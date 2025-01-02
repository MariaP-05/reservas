<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caracteristica;
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

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.caracteristicas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.caracteristicas.index');
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

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.caracteristicas.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.caracteristicas.index');
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
           
            Caracteristica::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.caracteristicas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.caracteristicas.index');
        }
    }
   
}
