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
use PDF;
use JeroenNoten\LaravelAdminLte\View\Components\Widget\Card;

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

    public function create_fecha($id_cabania, $fecha)
    {
        $clientes = Cliente::orderBy('nombre')->pluck('nombre', 'id')->all();
        $clientes = array('' => trans('message.select')) + $clientes;

        $cabanias = Cabania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $cabanias = array('' => trans('message.select')) + $cabanias;

        $formas_pago = Forma_pago::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $formas_pago = array('' => trans('message.select')) + $formas_pago;

        $estado_reservas = Estado_reserva::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estado_reservas = array('' => trans('message.select')) + $estado_reservas;

        return view('admin.reservas.edit', compact(
            'clientes',
            'cabanias',
            'formas_pago',
            'estado_reservas',
            'id_cabania',
            'fecha'
        ));
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

            return redirect()->route('admin.reservas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            return redirect()->route('admin.reservas.index')->with('error', $ex->getMessage());
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
            if ($reserva->moneda == 'Pesos') {
                $reserva->importe_reserva =  $precio_entrada->valor * $cant_dias;
            } else {
                $reserva->importe_reserva =  $precio_entrada->valor_dolar * $cant_dias;
            }


            $reserva->descuento_porce = (100 * $reserva->descuento) / $reserva->importe_reserva;
            $reserva->total = $reserva->importe_reserva - $reserva->descuento;
            if ($reserva->total > 0) {
                $reserva->recargo_porce = (100 * $reserva->recargo) / $reserva->total;
            } else {
                $reserva->recargo_porce = 0;
            }
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
            $reserva->motivos_recargos = $request->motivos_recargos;
            $reserva->valor = $request->recargo +  $request->total;
            $reserva->observaciones = $request->observaciones;
            $reserva->moneda = $request->moneda;

            $reserva->save();

            return redirect()->route('admin.reservas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {

            return redirect()->route('admin.reservas.index')->with('error', $ex->getMessage());
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

            return redirect()->route('admin.reservas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            return redirect()->route('admin.reservas.index')->with('error', $ex->getMessage());
        }
    }

    public function get(Request $request)
    {
        $id_cabania = $request->id_cabania;
        $moneda = $request->moneda;
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

                if ($moneda == 'Pesos') {
                    $precio =  $precio_entrada->valor * $cant_dias;
                } else {
                    $precio =  $precio_entrada->valor_dolar * $cant_dias;
                }
            }
        }

        return response()->json(['data' => $precio]);
    }

    public function calendario_old(Request $request)
    {
        $reservas = Reserva::all();
        $cabanias = Cabania::all();

        $fecha_desde = new Carbon();
        $fecha_desde->addDays(-1);
        // $fecha_desde->firstOfMonth();
        $hoy = new Carbon();
        $hoy->addDays(-1);
        $fecha_hasta = new Carbon();
        //$fecha_hasta->firstOfMonth();
        $fecha_hasta->addMonths(1);
        // $fecha_hasta->lastOfMonth();
        //$fecha_hasta->addDays(1);

        $dias = [];
        $months = [];
        $months_bandera = [];
        $k = 0;
        $num_mes = 0;

        while ($fecha_desde <= $fecha_hasta) {
            $mes = $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
            if (in_array($mes, $months_bandera) == false) {
                $months_bandera[] = $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
                $months[$num_mes]['mes'] =  $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
                $ultimo_dia_mes = new Carbon($fecha_desde);
                if ($fecha_hasta < $ultimo_dia_mes->lastOfMonth()) {
                    $months[$num_mes]['dias'] = (int)$fecha_hasta->format('d');
                } else {
                    $months[$num_mes]['dias'] = (int)(($fecha_desde->daysInMonth - $fecha_desde->format('d')) + 1);
                }
                $num_mes++;
            }

            $dias[] = new Carbon($fecha_desde);
            $fech_hast = new Carbon($fecha_desde);
            $fech_hast->addDays(1);
            $dia_compartido = 0;
            foreach ($cabanias as $cabania) {
                $reserva = Reserva::where('id_cabania', $cabania->id)
                    ->where('fecha_desde', '<=', $fecha_desde->format('Y-m-d'))
                    ->where('fecha_hasta', '>=', $fech_hast->format('Y-m-d')) //->first();
                    ->first();

                if (isset($reserva)) { //si hay reserva entro aca
                    $comienzo = new Carbon($reserva->fecha_desde);
                    $fin = new Carbon($reserva->fecha_hasta);
                    if ($comienzo < $hoy) {
                        $comienzo = new Carbon();
                        $comienzo->addDays(-2);
                    }
                    if ($fecha_hasta < $fin) {
                        $fin = new Carbon($fecha_hasta);
                        $fin->addDays(1);
                    }


                    $reserva->span = $comienzo->diffInDays($fin);
                } else {
                    $reserva = new Reserva();
                    $reserva->span = 1;
                }
                $cab[$cabania->id][$k] = $reserva;
            }
            $fecha_desde->addDays(1);
            $k++;
        }

        $t = 0;
        return view('admin.reservas.calendario_old', compact(
            'cab',

            't',
            'months',
            'dias',
            'cabanias',
            'reservas',
            'fecha_desde',
            'fecha_hasta'
        ));
    }

    public function calendario(Request $request)
    {

        $cab = [];
        if (isset($request->fec_desde)) {
            $fecha_desde = new Carbon($request->fec_desde);
            $fecha_desde_filtro = new Carbon($request->fec_desde);
        } else {
            $fecha_desde = new Carbon();
            $fecha_desde->addDays(-1);

            $fecha_desde_filtro = new Carbon();
            $fecha_desde_filtro->addDays(-1);
        }

        if (isset($request->fec_hasta)) {
            $fecha_hasta = new Carbon($request->fec_hasta);
            $fecha_hasta_filtro = new Carbon($request->fec_hasta);
        } else {
            $fecha_hasta = new Carbon();
            $fecha_hasta->addMonths(1);

            $fecha_hasta_filtro = new Carbon();
            $fecha_hasta_filtro->addMonths(1);
        }

        $cabanias = Cabania::all();
        $dias = [];
        $months = [];
        $months_bandera = [];
        $num_mes = 0;
        $array = [];

        while ($fecha_desde <= $fecha_hasta) {
            $mes = $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
            if (in_array($mes, $months_bandera) == false) {
                $months_bandera[] = $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
                $months[$num_mes]['mes'] =  $fecha_desde->locale('es_Ar')->isoFormat('MMMM');
                $ultimo_dia_mes = new Carbon($fecha_desde);
                if ($fecha_hasta < $ultimo_dia_mes->lastOfMonth()) {
                    $months[$num_mes]['dias'] = (int)$fecha_hasta->format('d');
                } else {
                    $months[$num_mes]['dias'] = (int)(($fecha_desde->daysInMonth - $fecha_desde->format('d')) + 1);
                }
                $num_mes++;
            }

            $dias[] = new Carbon($fecha_desde);
            $fech_hast = new Carbon($fecha_desde);
            $fech_hast->addDays(1);

            $dia_compartido = 0;
            foreach ($cabanias as $cabania) {
                $reserva = Reserva::where('id_cabania', $cabania->id)
                ->where('estado','!=', 'Cancelada')
                    ->where('fecha_desde', '<=', $fecha_desde->format('Y-m-d'))
                    ->where('fecha_hasta', '>=', $fech_hast->format('Y-m-d'))
                    ->first();

                if (isset($reserva)) { //si hay reserva entro aca
                    $comienzo = new Carbon($reserva->fecha_desde);
                    $fin = new Carbon($reserva->fecha_hasta);
                    if ($comienzo->format('Y-m-d') < $fecha_desde_filtro->format('Y-m-d')) {
                        $comienzo->addDays($comienzo->diffInDays($fecha_desde_filtro));
                    }
                    if ($fin->format('Y-m-d')  > $fecha_hasta_filtro->format('Y-m-d')) {
                        $fin->addDays(- ($fin->diffInDays($fecha_hasta_filtro) - 1));
                    }

                    if ($comienzo->format('Y-m-d') ==  $fecha_desde->format('Y-m-d') && !in_array($reserva->id, $array)) {

                        $reserva->span = $comienzo->diffInDays($fin);
                        $array[] = $reserva->id;
                    } else {
                        if (!in_array($reserva->id, $array)) {

                            $reserva->span = $comienzo->diffInDays($fin);
                            $array[] = $reserva->id;
                        } else {
                            $reserva->span = 0;
                        }
                    }
                } else {
                    $reserva = new Reserva();
                    $reserva->span = 1;
                }

                $cab[$cabania->id][$fecha_desde->format('md')] = $reserva;
            }
            $fecha_desde->addDays(1);
        }

        $t = 0;
        return view('admin.reservas.calendario', compact(
            'cab',
            't',
            'months',
            'dias',
            'cabanias',
            'fecha_desde_filtro',
            'fecha_hasta_filtro',
            'fecha_desde',
            'fecha_hasta'
        ));
    }

    public function export($id, $mode)
    {
        $reserva = Reserva::find($id);
        $cant = new Carbon($reserva->fecha_hasta);

        $reserva->cant_dias = $cant->diffInDays(new Carbon($reserva->fecha_desde));
        $data = ['reserva' => $reserva];

        $pdf = PDF::loadView('pdf/reserva', $data);

        return $pdf->download('Reserva  ' . (isset($reserva->Cliente) ? $reserva->Cliente->nombre : '') . '.pdf');
    }
}
