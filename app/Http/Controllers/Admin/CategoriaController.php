<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class CategoriaController extends Controller
{
    public function index()
    {        
        $categorias = Categoria::all();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
            return view('admin.categorias.edit');
    }

    public function store(Request $request)
    {

        try {
            $categoria = new Categoria($request->all());


            $categoria->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.categorias.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.categorias.index');
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
        $categoria = Categoria::findOrFail($id);

        $categorias = Categoria::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $categorias = array('' => trans('message.select')) + $categorias;

        
        return view('admin.categorias.edit', compact('categoria','categorias'));
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
            $categoria = Categoria::findOrFail($id);


            $categoria->denominacion = $request->denominacion;
            
            

            $categoria->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.categorias.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.categorias.index');
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
           
            Categoria::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.categorias.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.categorias.index');
        }
    }
   
}
