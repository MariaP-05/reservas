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


        return view('admin.reservas.edit', compact('clientes', 'cabanias', 'formas_pago', 'estado_reservas'));
    }

    public function store(Request $request)
    {

        try {
            $reserva = new Reserva($request->all());
            if ($request->nombre_cliente !== '' && $request->nombre_cliente !== null) {
                $cliente = new Cliente();
                $cliente->nombre = $request->nombre_cliente;
                $cliente->telefono = $request->telefono_cliente;

                $cliente->save();

                $reserva->id_cliente = $cliente->id;
            }
            if ($reserva->id_estado_reserva == '') {
                $reserva->id_estado_reserva = 1;
            }


            $reserva->valor = $request->recargo +  $request->total;
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
    public function show($id) {}

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

        //lo que viene abajo es para establecer los valores que se recargan luego por js

        $fecha_desde = new Carbon($reserva->fecha_desde);
        $fecha_hasta =  new Carbon($reserva->fecha_hasta);

        $precio_entrada = Precio::where('id_cabania', $reserva->id_cabania)->where('fecha_desde', '<=', $fecha_desde)
            ->orderby('fecha_desde', 'desc')->first();
        $cant_dias = $fecha_desde->diffInDays($fecha_hasta);

        if (isset($precio_entrada)) {
            $reserva->importe_reserva =  $precio_entrada->valor * $cant_dias;

            $reserva->descuento_porce = (100 * $reserva->descuento) / $reserva->importe_reserva;
            $reserva->total = $reserva->importe_reserva - $reserva->descuento;
            $reserva->recargo_porce = (100 * $reserva->recargo) / $reserva->total;
            $reserva->total_deuda = $reserva->total + $reserva->recargo - $reserva->senia;
        }


        return view('admin.reservas.edit', compact('reserva', 'clientes', 'cabanias', 'formas_pago',  'estado_reservas'));
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

            if ($request->nombre_cliente !== '' && $request->nombre_cliente !== null) {
                $cliente = new Cliente();
                $cliente->nombre = $request->nombre_cliente;
                $cliente->telefono = $request->telefono_cliente;
                $cliente->save();
                $reserva->id_cliente = $cliente->id;
            }
            $reserva->id_forma_pago = $request->id_forma_pago;
            $reserva->ctabancaria = $request->ctabancaria;
            $reserva->id_estado_reserva = $request->id_estado_reserva;
            $reserva->fecha_desde = $request->fecha_desde;
            $reserva->fecha_hasta = $request->fecha_hasta;
            $reserva->hora_ingreso = $request->hora_ingreso;
            $reserva->hora_egreso = $request->hora_egreso;
            $reserva->cantidad_personas = $request->cantidad_personas;
            $reserva->senia = $request->senia;
            $reserva->descuento = $request->descuento;
            $reserva->recargo = $request->recargo;
            $reserva->valor = $request->recargo +  $request->total;
            $reserva->observaciones = $request->observaciones;

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

        if ($id_cabania >= 1 && isset($request->fecha_desde)  && isset($request->fecha_hasta)) {
            $fecha_desde = new Carbon($request->fecha_desde);
            $fecha_hasta =  new Carbon($request->fecha_hasta);

            if ($fecha_hasta > $fecha_desde) {
                $precio_entrada = Precio::where('id_cabania', $id_cabania)->where('fecha_desde', '<=', $fecha_desde)
                    ->orderby('fecha_desde', 'desc')->first();

                /*$precio_salida = Precio::where('id_cabania',$id_cabania)->where('fecha', '<=',$fecha_hasta )
                ->oderby('fecha', 'desc')->first();
                 ver como es cuando se tomauna fehca de entrada y una de salida con distintos valores*/
                $cant_dias = $fecha_desde->diffInDays($fecha_hasta);

                $precio =  $precio_entrada->valor * $cant_dias;
            }
        }

        return response()->json(['data' => $precio]);
    }

    public function calendario(Request $request)
    {
        $reservas = Reserva::all();
        $cabanias = Cabania::all();

        $fecha_desde = new Carbon();
        $fecha_desde->firstOfMonth();

        $fecha_hasta = new Carbon();
        $fecha_hasta->firstOfMonth();
        // $fecha_hasta->addMonths(1);
        $fecha_hasta->lastOfMonth();


        $dias = [];
        $months = [];
        $span = [];
        $i = 0;
        $k = 0;
        while ($fecha_desde <= $fecha_hasta) {
            $mes = $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
            if (in_array($mes, $months) == false) {
                $span[] = $i * 2;
                $months[] =  $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
                $i = 1;
            } else {
                $i++;
            }

            $dias[] = new Carbon($fecha_desde);
            $fech_hast = new Carbon($fecha_desde);
            $fech_hast->addDays(1);
            $dia_compartido = 0;
            foreach ($cabanias as $cabania) {
                $reserva = Reserva::where('id_cabania', $cabania->id)
                    //->where('fecha_desde','>=',$fecha_desde->format('Y-m-d'))
                    ->where('fecha_desde', '<=', $fecha_desde->format('Y-m-d'))
                    ->where('fecha_hasta', '>=', $fech_hast->format('Y-m-d')) //->first();
                    ->first();
                //  $cabania->reserva[$k] = $reserva;
                if (isset($reserva)) {
                    $comienzo = new Carbon($reserva->fecha_desde);
                    $fin = new Carbon($reserva->fecha_hasta);
                    $reserva->span = $comienzo->diffInDays($fin) * 2;

                    //dd($reserva->fecha_hasta , $fech_hast->format('Y-m-d'));

                    if ($reserva->fecha_hasta == $fech_hast->format('d-m-Y')) {

                        $reserva->span = $reserva->span + 1;
                        $dia_compartido = 1;
                    }
                    if ($reserva->fecha_desde == $fecha_desde->format('d-m-Y')) {

                        if($k == 0)
                        {
                            $reserva_2 = new Reserva();
                            $reserva_2->span = 1;
                            $cab[$cabania->id][$k] = $reserva_2;
                            $k++;
                            // dd($reserva->fecha_desde,  $cab);
                        }
                        $reserva->span = $reserva->span - 1;
                        $dia_compartido = 2;
                    }
                } else {
                    $reserva = new Reserva();
                    if ($dia_compartido == 1) {
                        $reserva->span = 1;
                        $dia_compartido = 0;
                    } else {
                        if ($dia_compartido == 2) {
                            $reserva->span = 3;
                            $dia_compartido = 0;
                        } else {
                            $reserva->span = 2;
                        }
                    }
                }


                $cab[$cabania->id][$k] = $reserva;
                // dd($reserva,$cabania->id, $fecha_desde->format('Y-m-d'), $fech_hast->format('Y-m-d'));
            }
            $fecha_desde->addDays(1);
            $k++;
        }
//dd($cab, $span);
        $span[] = $i * 2;
        array_shift($span);
        //dd($span );
        $t = 0;
        return view('admin.reservas.calendario', compact(
            'cab',
            'span',
            't',
            'months',
            'dias',
            'cabanias',
            'reservas',
            'fecha_desde',
            'fecha_hasta'
        ));
    }
}
