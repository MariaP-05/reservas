<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabania;
use App\Models\Caracteristica;
use App\Models\Caracteristica_cab;
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
        $caracteristicas = Caracteristica::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $caracteristicas = array('' => trans('message.select')) + $caracteristicas;

        return view('admin.cabanias.edit', compact('caracteristicas'));
    }

    public function store(Request $request)
    {

        try {
            $cabania = new Cabania($request->all());

            $cabania->denominacion = ucwords(strtolower($request->denominacion));

            $cabania->save();

            if (count($request->id_caracteristica) > 0) {
                $cantidad =  0;
                foreach ($request->id_caracteristica  as $caracteristica_nueva) {
                    if ($caracteristica_nueva >= 1) {
                        $caracteristica = new Caracteristica_cab();
                        $caracteristica->id_caracteristica = $caracteristica_nueva;
                        $caracteristica->cantidad = $request->cantidad[$cantidad];
                        $caracteristica->id_cabania = $cabania->id;
                        $caracteristica->save();
                    }

                    $cantidad++;
                }
            }


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
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cabania = Cabania::findOrFail($id);

        $caracteristicas = Caracteristica::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $caracteristicas = array('' => trans('message.select')) + $caracteristicas;

        return view('admin.cabanias.edit', compact('cabania', 'caracteristicas'));
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

            $cabania->denominacion = ucwords(strtolower($request->denominacion));
            $cabania->capacidad = $request->capacidad;
            $cabania->observaciones = $request->observaciones;

            $cabania->save();


            if (count($request->id_caracteristica) > 0) {
                $cantidad =  0;
                foreach ($request->id_caracteristica  as $caracteristica_nueva) {
                    if ($caracteristica_nueva >= 1) {
                        $caracteristica = new Caracteristica_cab();
                        $caracteristica->id_caracteristica = $caracteristica_nueva;
                        $caracteristica->cantidad = $request->cantidad[$cantidad];
                        $caracteristica->id_cabania = $cabania->id;
                        $caracteristica->save();
                    }

                    $cantidad++;
                }
            }

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


    public function delete_caract($id)

    {
        try {
            Caracteristica_cab::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->back();
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->back();
        }
    }
}
