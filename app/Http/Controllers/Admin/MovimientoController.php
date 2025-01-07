<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $movimientos = Movimiento::search($request)->get();

       // $movimientos = Movimiento::all();

       $fecha_desde = null;

        if (isset($request->fec_desde)) {
            $fecha_desde = $request->fec_desde;
        }
        $fecha_hasta = null;

        if (isset($request->fec_hasta)) {
            $fecha_hasta = $request->fec_hasta;
        }


        $categorias = Categoria::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $categorias = array('' => trans('message.select')) + $categorias;

        if (isset($request->id_categoria)) {
            $id_categoria = $request->id_categoria;
        } else {
            $id_categoria = null;
        }


        return view('admin.movimientos.index', compact('movimientos','fecha_desde','fecha_hasta','categorias','id_categoria'));
    }

    public function create()
    {
    
        $usuarios = User::orderBy('name')->pluck('name', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        $categorias = Categoria::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $categorias = array('' => trans('message.select')) + $categorias;


        return view('admin.movimientos.edit', compact('usuarios','categorias'));
    }

    public function store(Request $request)
    {

        try {

            $movimientos = new Movimiento($request->all());

            $movimientos->save();
 
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.movimientos.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.movimientos.index');
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
        $movimiento = Movimiento::findOrFail($id);


        $usuarios = User::orderBy('name')->pluck('name', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        $categorias = Categoria::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $categorias = array('' => trans('message.select')) + $categorias;

        return view('admin.movimientos.edit', compact('movimiento', 'usuarios', 'categorias' ));
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
            $movimiento = Movimiento::findOrFail($id);
        
            $movimiento->denominacion =ucwords(strtolower($request->denominacion));
            $movimiento->fecha = $request->fecha;
            $movimiento->importe = $request->importe;
            $movimiento->tipo_movimiento =ucwords(strtolower($request->tipo_movimiento));
            $movimiento->id_usuario = $request->id_usuario;
            $movimiento->id_categoria = $request->id_categoria;
            
            $movimiento->forma_pago =ucwords(strtolower($request->forma_pago));
            $movimiento->observaciones = $request->observaciones;
         


            $movimiento->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.movimientos.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.movimientos.index');
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
           
            Movimiento::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.movimientos.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.movimientos.index');
        }


    }

   
}
