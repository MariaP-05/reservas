<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compania;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class CompaniaController extends Controller
{
    public function index()
    {
        $companias = Compania::all();

        return view('admin.companias.index', compact('companias'));
    }

    public function create()
    {
        return view('admin.companias.edit');
    }

    public function store(Request $request)
    {
       
        try {
            $compania = new Compania($request->all());
           

            $compania->save();
 
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.companias.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.companias.index');
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
        $compania = Compania::findOrFail($id);
        
        return view('admin.companias.edit', compact('compania' ));
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
            
            $compania = Compania::findOrFail($id);
            
                $compania->denominacion = $request->denominacion;
                $compania->codigo = $request->codigo;
                
                $compania->save();
                session()->flash('alert-success', trans('message.successaction'));
                return redirect()->route('admin.companias.index');
        } catch (QueryException  $ex) {
            
                 session()->flash('alert-danger', $ex->getMessage());
                return redirect()->route('admin.companias.index');
           
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
           
            compania::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.companias.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.companias.index');
        }
    }
}