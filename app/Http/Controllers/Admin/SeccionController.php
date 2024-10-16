<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class SeccionController extends Controller
{
    public function index()
    {
        //$this->insert_servicios();
        $secciones = Seccion::all();

        return view('admin.secciones.index', compact('secciones'));
    }

    public function create()
    {
            return view('admin.secciones.edit');
    }

    public function store(Request $request)
    {

        try {
            $seccion = new Seccion($request->all());


            $seccion->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.secciones.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.secciones.index');
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
        $seccion = Seccion::findOrFail($id);
        
        return view('admin.secciones.edit', compact('seccion'));
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
            $seccion = Seccion::findOrFail($id);


            $seccion->denominacion = $request->denominacion;
            

            $seccion->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.secciones.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.secciones.index');
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
           
            Seccion::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.secciones.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.secciones.index');
        }
    }
   
}
