<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Estado_reserva;
use App\Models\Cabania;
use App\Models\Forma_pago;
use App\Models\Precio;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $reservas = Reserva::all();

        return view('admin.reservas.index', compact('reservas'));
    }

    public function create()
    {
    
        $clientes = Cliente::orderBy('nombre')->pluck('nombre', 'id')->all();
        $clientes = array('' => trans('message.select')) + $clientes;

        $cabanias = Cabania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $cabanias = array('' => trans('message.select')) + $cabanias;

        $formas_pago = Forma_pago::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $formas_pago = array('' => trans('message.select')) + $formas_pago;

        $estado_reservas = Estado_reserva::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estado_reservas = array('' => trans('message.select')) + $estado_reservas;


        return view('admin.reservas.edit', compact('clientes','cabanias','formas_pago', 'estado_reservas'));
    }

    public function store(Request $request)
    {

        try {
            $reserva = new Reserva($request->all());
            $reserva->id_estado_reserva = 1;

            $reserva->save();
 
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.reservas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.reservas.index');
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
        $reserva = Reserva::findOrFail($id);


        $clientes = Cliente::orderBy('nombre')->pluck('nombre', 'id')->all();
        $clientes = array('' => trans('message.select')) + $clientes;


        $cabanias = Cabania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $cabanias = array('' => trans('message.select')) + $cabanias;

        $formas_pago = Forma_pago::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $formas_pago = array('' => trans('message.select')) + $formas_pago;

        
        $estado_reservas = Estado_reserva::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estado_reservas = array('' => trans('message.select')) + $estado_reservas;

        return view('admin.reservas.edit', compact('reserva', 'clientes', 'cabanias', 'formas_pago',  'estado_reservas' ));
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
            $reserva = Reserva::findOrFail($id);
        
            $reserva->id_cabania = $request->id_cabania;
            $reserva->id_cliente = $request->id_cliente;
            $reserva->id_forma_pago = $request->id_forma_pago;
            $reserva->id_estado_reserva = $request->id_estado_reserva;
            $reserva->fecha_desde = $request->fecha_desde;
            $reserva->fecha_hasta = $request->fecha_hasta;
            $reserva->hora_ingreso = $request->hora_ingreso;
            $reserva->hora_egreso =$request->hora_egreso;
            $reserva->cantidad_personas =$request->cantidad_personas;
            $reserva->senia =$request->senia;
            $reserva->descuento = $request->descuento;
            $reserva->oberservaciones = $request->oberservaciones;
         
            $reserva->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.reservas.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.reservas.index');
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
           
            Reserva::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.reservas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.reservas|.index');
        }


    }

    public function get(Request $request)
    {
       
        $id_cabania = $request->id_cabania;
        $precio = 0;
        
        if($id_cabania >= 1 && isset($request->fecha_desde)  && isset($request->fecha_hasta) )
        {
            $fecha_desde = new Carbon($request->fecha_desde);
            $fecha_hasta =  new Carbon($request->fecha_hasta);

            if($fecha_hasta > $fecha_desde )
            {
                $precio_entrada = Precio::where('id_cabania',$id_cabania)->where('fecha_desde', '<=',$fecha_desde )
                ->orderby('fecha_desde', 'desc')->first();
    
                /*$precio_salida = Precio::where('id_cabania',$id_cabania)->where('fecha', '<=',$fecha_hasta )
                ->oderby('fecha', 'desc')->first();
                 ver como es cuando se tomauna fehca de entrada y una de salida con distintos valores*/
                $cant_dias = $fecha_desde->diffInDays($fecha_hasta);
    
                $precio =  $precio_entrada->valor * $cant_dias ;
            }
           
        }
          
        return response()->json(['data' => $precio]);
    }
   
}
