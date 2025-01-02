<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gestion_caja;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class Gestion_cajaController extends Controller
{
    public function index(Request $request)
    {
        $gestiones_caja = Gestion_caja::all();

        return view('admin.gestiones_caja.index', compact('gestiones_caja'));
    }

    public function create()
    {
    
        $usuarios = User::orderBy('nombre')->pluck('nombre', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        $categorias = Categoria::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $categorias = array('' => trans('message.select')) + $categorias;


        return view('admin.gestiones_caja.edit', compact('usuarios','categorias'));
    }

    public function store(Request $request)
    {

        try {

            $gestiones_caja = new Gestion_caja($request->all());

            $gestiones_caja->save();
 
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.gestiones_caja.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.gestiones_caja.index');
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
        $gestiones_caja = Gestion_caja::findOrFail($id);


        $usuarios = User::orderBy('nombre')->pluck('nombre', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        $categorias = Categoria::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $categorias = array('' => trans('message.select')) + $categorias;

        return view('admin.gestiones_caja.edit', compact('gestiones_caja', 'usuarios', 'categorias' ));
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
            $gestion_caja = Gestion_caja::findOrFail($id);
        
            $gestion_caja->fecha = $request->fecha;
            $gestion_caja->denominacion = $request->denominacion;
            $gestion_caja->importe = $request->importe;
            $gestion_caja->tipo_movimiento = $request->tipo_movimiento;
            $gestion_caja->id_usuario = $request->id_usuario;
            $gestion_caja->id_categoria = $request->id_categoria;
            $gestion_caja->forma_pago = $request->forma_pago;
            $gestion_caja->oberservaciones = $request->oberservaciones;
         
            $gestion_caja->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.gestiones_caja.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.gestiones_caja.index');
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
           
            Gestion_caja::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.gestiones_caja.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.gestiones_caja|.index');
        }


    }

   
}
