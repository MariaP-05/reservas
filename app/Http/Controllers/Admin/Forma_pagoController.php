<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forma_pago;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class Forma_pagoController extends Controller
{
    public function index()
    {
        //$this->insert_servicios();
        $formas_pago = Forma_pago::all();

        return view('admin.formas_pago.index', compact('formas_pago'));
    }

    public function create()
    {
            return view('admin.formas_pago.edit');
    }

    public function store(Request $request)
    {

        try {
            $forma_pago = new Forma_pago($request->all());


            $forma_pago->save();

           
            return redirect()->route('admin.formas_pago.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            
            return redirect()->route('admin.formas_pago.index')->with('error', $ex->getMessage());
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
        $forma_pago = Forma_pago::findOrFail($id);
        
        return view('admin.formas_pago.edit', compact('forma_pago'));
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
            $forma_pago = Forma_pago::findOrFail($id);


            $forma_pago->denominacion = $request->denominacion;
            

            $forma_pago->save();

            
        return redirect()->route('admin.formas_pago.index')->with('success', trans('message.successaction'));
            } catch (QueryException  $ex) {

            return redirect()->route('admin.formas_pago.index')->with('error', $ex->getMessage());
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
            $reservas = Reserva::where('id_forma_pago', $id)->count();
            
            if ($reservas == 0) {
                Forma_pago::destroy($id);
                return redirect()->route('admin.formas_pago.index')->with('success', trans('message.successaction'));
            } else {
                return redirect()->route('admin.formas_pago.index')->with('error', '¡Error! La forma de pago tiene asignado una reserva, no se puede eliminar.');
            }
        } catch (QueryException  $ex) {
            //session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.formas_pago.index')->with('error', $ex->getMessage());
        }
    }
}
   

