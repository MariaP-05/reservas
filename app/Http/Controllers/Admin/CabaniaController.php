<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabania;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class CabaniaController extends Controller
{
    public function index()
    {
        $cabanias = Cabania::all();

        return view('admin.cabanias.index', compact('cabanias'));
    }

    public function create()
    {
        return view('admin.cabanias.edit');
    }

    public function store(Request $request)
    {
       
        try {
            $cabania = new Cabania($request->all());

            $cabania->denominacion = ucwords (strtolower( $request->denominacion));

            $cabania->save();
 
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.cabanias.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.cabanias.index');
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
        $cabania = Cabania::findOrFail($id);
        
        return view('admin.cabanias.edit', compact('cabania' ));
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
            
                $cabania = Cabania::findOrFail($id);
            
                $cabania->denominacion = ucwords (strtolower( $request->denominacion));
                $cabania->capacidad = $request->capacidad;
                $cabania->observaciones = $request->observaciones;
                
                $cabania->save();
                session()->flash('alert-success', trans('message.successaction'));
                return redirect()->route('admin.cabanias.index');
                 } catch (QueryException  $ex) {
            
                 session()->flash('alert-danger', $ex->getMessage());
                return redirect()->route('admin.cabanias.index');
           
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
           
            Cabania::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.cabanias.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.cabanias.index');
        }
    }
}