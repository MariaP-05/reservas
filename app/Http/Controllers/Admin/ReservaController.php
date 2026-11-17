<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Estado_reserva;
use App\Models\Cabania;
use App\Models\Forma_pago;
use App\Models\Precio;
use App\Models\Reserva;
use App\Models\Prestador;
use Afip;
use App\Models\Comprobante;
use App\Models\CotizacionMoneda;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use PDF;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $reservas = Reserva::all();

           $prestador = Prestador::find(2);
         $afip = new Afip([
                'production' => true,
                'CUIT' => $prestador->cuit,
                'cert' => file_get_contents(storage_path('app/public/afip/certprdrodri' )),
                'key' => file_get_contents(storage_path('app/public/afip/keyprd' )),
                'access_token' => $prestador->token
            ]);

             $last_voucher = $afip->ElectronicBilling->GetLastVoucher(3, 11);
             dd($last_voucher); 
        //   $this->export_comprobante(23);
        /*  $this->storeFile(  'https://afip-sdk-pdf-storage.s3.amazonaws.com/01a1da75-8939-72db-a06b-9495a0342a1f.pdf',
      111 , 'Comprobante Seña Reserva 111');*/
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

    public function create_fecha($id_cabania, $fecha, $fecha_hasta)
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
            'fecha',
            'fecha_hasta'
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
                $cliente->dni = $request->dni_cliente;
                $cliente->cuit = $request->cuit_cliente;
                $cliente->razon_social = $request->razon_social_cliente;
                $cliente->direccion = $request->direccion_cliente;

                $cliente->save();
                $reserva->id_cliente = $cliente->id;
            }
            if ($reserva->id_estado_reserva == '') {
                $reserva->id_estado_reserva = 1;
            }

            $reserva->valor = $request->recargo +  $request->total;

            $fecha_desde = new Carbon($reserva->fecha_desde);
            $fecha_hasta = new Carbon($reserva->fecha_hasta);
            $hora_ingreso =  ($reserva->hora_ingreso == null  ||  $reserva->hora_ingreso == '') ? '12:00:00'  :  $reserva->hora_ingreso;
            $hora_egreso =  ($reserva->hora_egreso == null  ||  $reserva->hora_egreso == '') ? '10:00:00'  :  $reserva->hora_egreso;

            $reserva->start = $fecha_desde->format('Y-m-d') . 'T' . $hora_ingreso;
            //se cambia la fehca end para que el calendario muestre noches ocupadas
            // $reserva->end = $fecha_hasta->format('Y-m-d') . 'T' . $hora_egreso;

            $reserva->end = new Carbon($fecha_hasta);
            $reserva->end->addDay(-1);
            $reserva->end = $reserva->end->format('Y-m-d') . 'T23:59:59';

            $reserva->title = isset($reserva->Cabania) ? $reserva->Cabania->denominacion : 'Reserva ' . $reserva->id;

            $reserva->title = isset($reserva->Cliente) ? $reserva->title . ' - ' . $reserva->Cliente->nombre : 'Reserva ' . $reserva->title;
            $reserva->backgroundColor = '#ffffff';
            $reserva->borderColor =  isset($reserva->Cabania) ? $reserva->Cabania->color : '#5589cdff';
            $reserva->textColor = isset($reserva->Cabania) ? $reserva->Cabania->color : '#5589cdff';

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
        $fecha_reserva =  new Carbon($reserva->fecha_reserva);

        $precio_entrada = Precio::where('id_cabania', $reserva->id_cabania)->where('fecha_desde', '<=', $fecha_desde)
            ->orderby('fecha_desde', 'desc')->first();
        $cant_dias = $fecha_desde->diffInDays($fecha_hasta);


        if (isset($precio_entrada)) {
            if ($reserva->moneda == 'Pesos') {
                $reserva->importe_reserva =  $precio_entrada->valor * $cant_dias;
            } else {

                $reserva->importe_reserva = (isset($precio_entrada->valor_dolar) ? $precio_entrada->valor_dolar : 0) * $cant_dias;
            }

            if ($reserva->importe_reserva == 0) {
                $reserva->descuento_porce = (100 * $reserva->descuento) / 1;
            } else {
                $reserva->descuento_porce = (100 * $reserva->descuento) / $reserva->importe_reserva;
            }

            $reserva->total = $reserva->importe_reserva - $reserva->descuento;
            if ($reserva->total > 0) {
                $reserva->recargo_porce = (100 * $reserva->recargo) / $reserva->total;
            } else {
                $reserva->recargo_porce = 0;
                $reserva->total =  ($reserva->total != null && $reserva->total != '') ? $reserva->total : 0;
            }
            $caracter_a_buscar = ',';
            $caracter_de_reemplazo = '.';

            $reserva->recargo = str_replace($caracter_a_buscar, $caracter_de_reemplazo, $reserva->recargo);
            $reserva->senia = str_replace($caracter_a_buscar, $caracter_de_reemplazo, $reserva->senia);


            $reserva->total_deuda = floatval($reserva->total) + floatval($reserva->recargo)  - floatval($reserva->senia);
        }

        return view('admin.reservas.edit', compact(
            'reserva',
            'clientes',
            'cabanias',
            'formas_pago',
            'estado_reservas'
        ));
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

            if ($request->nombre_cliente !== '' && $request->nombre_cliente !== null) {
                $cliente = new Cliente();
                $cliente->nombre = $request->nombre_cliente;
                $cliente->telefono = $request->telefono_cliente;
                $cliente->dni = $request->dni_cliente;
                $cliente->cuit = $request->cuit_cliente;
                $cliente->razon_social = $request->razon_social_cliente;
                $cliente->direccion = $request->direccion_cliente;

                $cliente->save();
                $reserva->id_cliente = $cliente->id;
            } else {
                $reserva->id_cliente = $request->id_cliente;
            }
            $reserva->id_forma_pago = $request->id_forma_pago;
            $reserva->ctabancaria = $request->ctabancaria;
            $reserva->id_estado_reserva = $request->id_estado_reserva;
            $reserva->fecha_desde = $request->fecha_desde;
            $reserva->fecha_hasta = $request->fecha_hasta;
            $reserva->fecha_reserva = $request->fecha_reserva;
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


            $fecha_desde = new Carbon($reserva->fecha_desde);
            $fecha_hasta = new Carbon($reserva->fecha_hasta);
            $hora_ingreso =  ($reserva->hora_ingreso == null  ||  $reserva->hora_ingreso == '') ? '12:00:00'  :  $reserva->hora_ingreso;
            $hora_egreso =  ($reserva->hora_egreso == null  ||  $reserva->hora_egreso == '') ? '10:00:00'  :  $reserva->hora_egreso;

            $reserva->start = $fecha_desde->format('Y-m-d') . 'T' . $hora_ingreso;
            //se cambia la fehca end para que el calendario muestre noches ocupadas
            // $reserva->end = $fecha_hasta->format('Y-m-d') . 'T' . $hora_egreso;

            $reserva->end = new Carbon($fecha_hasta);
            $reserva->end->addDay(-1);
            $reserva->end = $reserva->end->format('Y-m-d') . 'T23:59:59';

            $reserva->title = isset($reserva->Cabania) ? $reserva->Cabania->denominacion : 'Reserva ' . $reserva->id;

            $reserva->title = isset($reserva->Cliente) ? $reserva->title . ' - ' . $reserva->Cliente->nombre : 'Reserva ' . $reserva->title;
            $reserva->backgroundColor = '#ffffff';
            $reserva->borderColor =  isset($reserva->Cabania) ? $reserva->Cabania->color : '#5589cdff';
            $reserva->textColor = isset($reserva->Cabania) ? $reserva->Cabania->color : '#5589cdff';

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

        if (isset($request->mes)) {
            switch ($request->mes) {
                case 'proximo':
                    $fecha_desde->addMonth(1);
                    $fecha_hasta->addMonth(1);
                    $fecha_hasta_filtro->addMonths(1);
                    $fecha_desde_filtro->addMonths(1);
                    break;

                case 'previo':
                    $fecha_desde->addMonth(-1);
                    $fecha_hasta->addMonth(-1);

                    $fecha_hasta_filtro->addMonths(-1);
                    $fecha_desde_filtro->addMonths(-1);
                    break;
            }
        }
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
                    ->where('id_estado_reserva', '!=', '4')
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

        return $pdf->download((isset($reserva->Cliente) ? $reserva->Cliente->nombre : 'Reserva  ' . $reserva->id) . '.pdf');
    }

    public function export_comprobante($id, $prestador)
    {
        $afip = new Afip([
            'production' => true, //true para produccion, false para testing
            'CUIT' => $prestador->cuit,
            'cert' => file_get_contents(storage_path('app/public/afip/' . $prestador->cert)),
            'key' => file_get_contents(storage_path('app/public/afip/' . $prestador->key)),
            'access_token' => $prestador->token
        ]);
        
        //$reserva = Reserva::find($id);
        // Aqui deben cambiar los datos por los que correspondan. 
        $comprobante = Comprobante::find($id);

        $fecha_desde = new Carbon($comprobante->reserva->fecha_desde);
        $fecha_hasta = new Carbon($comprobante->reserva->fecha_hasta);
        if (isset($comprobante->reserva->Cliente)) {
            if ($comprobante->Reserva->Cliente->nombre == '') {
                $comprobante->Reserva->Cliente->nombre = 'Consumidor Final';
            }
            if ($comprobante->Reserva->Cliente->direccion == '') {
                $comprobante->Reserva->Cliente->direccion = '.';
            }
            if ($comprobante->Reserva->Cliente->dni == '') {
                $comprobante->Reserva->Cliente->dni = '00000000';
            }
        }
        $fecha_inicio_actividad = new Carbon($prestador->fecha_inicio_actividad);
        if (isset($comprobante->Reserva->Cliente)) {
            if ($comprobante->Reserva->Cliente->razon_social != null && $comprobante->Reserva->Cliente->razon_social != '') {
                $fact_nombre = $comprobante->Reserva->Cliente->razon_social;
            } else {
                $fact_nombre = $comprobante->Reserva->Cliente->nombre;
            }
            if ($comprobante->Reserva->Cliente->cuit != null && $comprobante->Reserva->Cliente->cuit != '') {
                $fact_numero = $comprobante->Reserva->Cliente->cuit;
            } else {
                $fact_numero = $comprobante->Reserva->Cliente->dni;
            }
        } else {
            $fact_numero = '00000000';
            $fact_nombre = 'Consumidor Final';
        }


        $data = [
            "file_name" => $comprobante->id . " - " . $comprobante->id_reserva . ".pdf",
            //   "send_to" => "cliente@empresa.com",
            "template" => [
                "name" => "invoice-c",
                "params" => [
                    "voucher_number" =>  $comprobante->numero,
                    "sales_point" => $comprobante->punto_venta,
                    "issue_date" => $comprobante->fecha,
                    "cae_due_date" => $comprobante->fecha_vencimiento_cae,
                    "issuer_cuit" => $prestador->cuit,
                    "cae" => $comprobante->numero_cae,
                    "issuer_business_name" => "Alto de las Pampas",
                    "issuer_address" => $prestador->domicilio,
                    "issuer_iva_condition" => $prestador->iva_denominacion,
                    "issuer_gross_income" => "CUIT " . substr($prestador->cuit, 0, 2) . "-" . substr($prestador->cuit, 2, 8) . "-" . substr($prestador->cuit, 10, 1), //"CUIT 27-38292342-7",
                    "issuer_activity_start_date" => $fecha_inicio_actividad->format('d/m/Y'), //"01/02/2026",
                    "receiver_name" => $fact_nombre,
                    "receiver_address" => isset($comprobante->Reserva->Cliente->direccion) ? $comprobante->Reserva->Cliente->direccion : '.',
                    "receiver_document_type" => 99,
                    "receiver_document_number" => $fact_numero,
                    "receiver_iva_condition" => "Consumidor Final",
                    "sale_condition" => "Contado",
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => 2,
                    "items" => [
                        [
                            "code" => "001",
                            "description" => "Alquiler Temporario",
                            "quantity" => 1,
                            "unit_price" => number_format($comprobante->valor, 2, '.', ''),
                            "subtotal" => number_format($comprobante->valor, 2, '.', '')
                        ]
                    ],
                    "vat_amount" => 0, //number_format($comprobante->valor - ($comprobante->valor / 1.21), 2, '.', ''),// 21,//
                    "tributes_amount" => 0,
                    "total_amount" => number_format($comprobante->valor, 2, '.', ''),
                    "billing_from" =>  $fecha_desde->format('d/m/Y'), // "01/02/2026",
                    "billing_to" => $fecha_hasta->format('d/m/Y'), // "28/02/2026",
                    "payment_due_date" => $comprobante->fecha_vencimiento_cae,
                    "net_amount_taxed" => 0,
                    "net_amount_untaxed" => 0,
                    "exempt_amount" => 0
                ]
            ]
        ];
        //dd($data);
        try {
            // Realizamos la llamada
            $response = $afip->ElectronicBilling->CreatePDF($data);
            $comprobante->archivo_pdf = $response['file'];

            $comprobante->save();
            return $comprobante->archivo_pdf;
            //echo file_get_contents($comprobante->archivo_pdf); 
            // Mostramos la respuesta por pantalla
            // var_dump($response);
        } catch (\Throwable $error) {
            // En caso de error lo mostramos por pantalla
            var_dump($error);
        }
    }

    public function calendario_io()
    {

        $cabanias = Cabania::orderBy('denominacion')->get();
        return view('admin.reservas.calendario_io', compact('cabanias'));
    }

    public function fullcalendar(Request $request)
    {
        $evento = Reserva::all();


        return  response()->json($evento);
    }

    public function migrarDatos()
    {
        $evento = Reserva::all();
        foreach ($evento as $turno) {
            //  $turno->fecha_reserva = $turno->created_at;
            $fecha_desde = new Carbon($turno->fecha_desde);
            $fecha_hasta = new Carbon($turno->fecha_hasta);
            $hora_ingreso =  ($turno->hora_ingreso == null  ||  $turno->hora_ingreso == '') ? '12:00:00'  :  $turno->hora_ingreso;
            $hora_egreso =  ($turno->hora_egreso == null  ||  $turno->hora_egreso == '') ? '10:00:00'  :  $turno->hora_egreso;
            //  $turno->start = $fecha_desde->format('Y-m-d') .'T12:00:00';
            ///  $turno->end = $fecha_hasta->format('Y-m-d') .'T16:00:00' ;
            $turno->start = $fecha_desde->format('Y-m-d') . 'T' . $hora_ingreso;
            //se cambia la fehca end para que el calendario muestre noches ocupadas
            // $reserva->end = $fecha_hasta->format('Y-m-d') . 'T' . $hora_egreso;

            $turno->end = new Carbon($fecha_hasta);
            $turno->end->addDay(-1);
            $turno->end = $turno->end->format('Y-m-d') . 'T23:59:59';
            // $turno->allDay  = 'false' ;
            $turno->title = isset($turno->Cabania) ? $turno->Cabania->denominacion : 'Reserva ' . $turno->id;

            $turno->title = isset($turno->Cliente) ? $turno->title . ' - ' . $turno->Cliente->nombre : 'Reserva ' . $turno->title;
            $turno->backgroundColor = '#ffffff';
            $turno->borderColor =  isset($turno->Cabania) ? $turno->Cabania->color : '#5589cdff';
            $turno->textColor = isset($turno->Cabania) ? $turno->Cabania->color : '#5589cdff';
            $turno->save();
        }
        return redirect()->back();
    }
    public function fullcalendarAjax(Request $request)
    {
        if ($request->id >= 1) {
            return $this->edit($request->id);
        } else {
            $fecha = new Carbon($request->start);
            $fecha_hasta = new Carbon($request->end);

            return $this->create_fecha(1, $fecha->format('d-m-Y'), $fecha_hasta->format('d-m-Y'));
        }
    }

    public function CambiarEstado($id, $estado)
    {
        try {
            $reserva = Reserva::findOrFail($id);

            $reserva->id_estado_reserva = $estado;

            $reserva->save();

            return redirect()->route('admin.reservas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            return redirect()->route('admin.reservas.index')->with('error', $ex->getMessage());
        }
    }

    public function create_factura($id)
    {
        try {
            $reserva = Reserva::findOrFail($id);

            $prestador = Prestador::first();
            $afip = new Afip([
                'production' => true, //true para produccion, false para testing
                'CUIT' => $prestador->cuit,
                'cert' => file_get_contents(storage_path('app/public/afip/' . $prestador->cert)),
                'key' => file_get_contents(storage_path('app/public/afip/' . $prestador->key)),
                'access_token' => $prestador->token
            ]);

            $last_voucher = $afip->ElectronicBilling->GetLastVoucher(3, 11);

            $numero_comprobante = $last_voucher + 1;

            $fecha_desde = new Carbon($reserva->fecha_desde);
            $fecha_hasta = new Carbon($reserva->fecha_hasta);

            $valor_reserva = $reserva->valor;
            $valor_seña = $reserva->senia;

            if ($reserva->moneda == 'Dolares') {
                if (count($reserva->Comprobante) > 0) {
                    if (isset($reserva->Comprobante[0]->id_cotizacion_moneda)) {
                        $cotizacion = CotizacionMoneda::find($reserva->Comprobante[0]->id_cotizacion_moneda);
                    } else {
                        $hoy = new Carbon();
                        $cotizacion = CotizacionMoneda::where('fecha', '<=', $hoy->format('Y-m-d'))->orderby('fecha', 'desc')->first();
                    }
                } else {
                    $hoy = new Carbon();
                    $cotizacion = CotizacionMoneda::where('fecha', '<=', $hoy->format('Y-m-d'))->orderby('fecha', 'desc')->first();
                }

                $valor_reserva = $reserva->valor * $cotizacion->usd;
                $valor_seña = $reserva->senia * $cotizacion->usd;
            }
            $total_facturado = 0;
            $total_facturar = $valor_reserva;
            if (count($reserva->Comprobante) > 0) {
                foreach ($reserva->Comprobante as $comprobante_existente) {
                    $total_facturado += $comprobante_existente->valor;
                }
                if ($reserva->id_estado_reserva == 5) {
                    $movimientoController = new MovimientoController();
                    $movimientoController->impactar_pago($reserva->id);
                }
                $reserva->id_estado_reserva = 6;
                $nombre = 'Factura Reserva ' . $reserva->id;
            } else {
                if ($reserva->id_estado_reserva == 5) {
                    $total_facturar = $valor_seña;
                    $nombre = 'Factura Seña Reserva ' . $reserva->id;
                } else {
                    $nombre = 'Factura Total Reserva ' . $reserva->id;
                    $reserva->id_estado_reserva = 6;
                }
            }


            // Info del comprobante
            $data = array(
                'CantReg'     => 1,  // Cantidad de comprobantes a registrar
                'PtoVta'     => 3,  // Punto de venta
                'CbteTipo'     => 11,  // Tipo de comprobante (ver tipos disponibles) factura c
                'Concepto'     => 2,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo'     => 99, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles) casi siempre 99 sino es 
                'DocNro'     => 0,  // Número de documento del comprador (0 consumidor final)
                'CbteDesde'     => $numero_comprobante,  // Número de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta'     => $numero_comprobante,  // Número de comprobante o numero del último comprobante en caso de ser mas de uno
                'CbteFch'     => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal'     => number_format($total_facturar - $total_facturado, 2, '.', ''), // Importe total del comprobante
                'ImpTotConc'     => 0,   // Importe neto no gravado
                'ImpNeto'     => number_format($total_facturar - $total_facturado, 2, '.', ''), //number_format($reserva->valor / 1.21, 2, '.', ''), // Importe neto gravado
                'ImpOpEx'     => 0,   // Importe exento de IVA
                'FchServDesde' =>  intval($fecha_desde->format('Ymd')), //'20080725', // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'FchServHasta' =>  intval($fecha_hasta->format('Ymd')), //'30080725', // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'FchVtoPago'     =>  30080725, //intval($fecha_hasta->format('Ymd')), //'30080725', // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'ImpIVA'     => 0, //number_format($reserva->valor - ($reserva->valor / 1.21), 2, '.', ''),  //Importe total de IVA
                'ImpTrib'     => 0,   //Importe total de tributos
                'MonId'     => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz'     => 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
                'CondicionIVAReceptorId' => $prestador->iva, // Condición frente al IVA del receptor  
                /*'Iva'         => array( // (Opcional) Alícuotas asociadas al comprobante
                    array(
                        'Id'         => 5, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                        'BaseImp'     => number_format($reserva->valor / 1.21, 2, '.', ''), // Base imponible
                        'Importe'     => number_format($reserva->valor - ($reserva->valor / 1.21), 2, '.', ''), // Importe 
                    )
                ),*/
            );

            $res = $afip->ElectronicBilling->CreateNextVoucher($data);


            $comprobante = new Comprobante();
            $comprobante->id_reserva = $reserva->id;
            $comprobante->id_prestador = $prestador->id;
            $comprobante->id_cotizacion_moneda = isset($cotizacion) ? $cotizacion->id : null;
            $comprobante->id_tipo_comprobante = 11;
            $comprobante->id_estado_comprobante = 2;
            $comprobante->valor = $total_facturar - $total_facturado;
            $comprobante->fecha = Carbon::now();
            $comprobante->numero = $res['voucher_number'];
            $comprobante->numero_cae = $res['CAE'];
            $comprobante->fecha_vencimiento_cae = $res['CAEFchVto'];
            $comprobante->punto_venta = '00003';
            $comprobante->observaciones = 'Comprobante generado por' . ' ' . Auth::user()->name;
            $comprobante->save();


            $comprobante->archivo_pdf =  $this->export_comprobante($comprobante->id, $prestador);

            // $comprobante2 = Comprobante::find(  $comprobante->id); 
            $this->storeFile($comprobante->archivo_pdf, $reserva->id, $nombre);
            $reserva->id_prestador = $prestador->id;
            $reserva->save();

            return redirect()->route('admin.reservas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
            return redirect()->route('admin.reservas.index')->with('error', $ex->getMessage());
        }
    }

    //probando
    public function storeFile(string $url, $id, string $nombre): string
    {
        // Limita el origen si la URL viene de datos externos.
        if (parse_url($url, PHP_URL_HOST) !== 'afip-sdk-pdf-storage.s3.amazonaws.com') {
            throw new RuntimeException('Dominio no permitido.');
        }

        $response = Http::timeout(60)->get($url);
        $response->throw();

        $content = $response->body();

        // Comprueba que el contenido descargado sea un PDF.
        if (! str_starts_with($content, '%PDF-')) {
            throw new RuntimeException('La respuesta no parece ser un PDF válido.');
        }

        $path = 'reservas/' . $id . '/' . $nombre . '.pdf';

        Storage::disk('local')->put($path, $content);

        return $path;
    }

    public function factura_afip_prueba_archivos($id)
    {
        $certPath = storage_path('app/public/afip/certtest');
        $keyPath  = storage_path('app/public/afip/keytest');

        $cert = file_get_contents($certPath);
        $key  = file_get_contents($keyPath);

        $certRes = openssl_x509_read($cert);
        $keyRes  = openssl_pkey_get_private($key); // si tiene passphrase, agrégala aquí

        if (!$certRes) {
            dd('No pude leer el certificado');
        }

        if (!$keyRes) {
            dd('No pude leer la clave privada');
        }

        $certData = openssl_x509_parse($certRes);
        $keyData   = openssl_pkey_get_details($keyRes);

        $certModulus = $certData['subject']['serialNumber'] ?? null; // solo referencia
        $keyModulus   = $keyData['rsa']['n'] ?? null;

        /*  dd([
            'pair_match' => openssl_x509_check_private_key($certRes, $keyRes),
            'cert_subject' => $certData['subject'] ?? null,
            'key_type' => $keyData['type'] ?? null,
            'cert_modulus_sha256' => $certModulus ? hash('sha256', $certModulus) : null,
            'key_modulus_sha256'  => $keyModulus ? hash('sha256', $keyModulus) : null,
        ]);*/


        $certInfo = openssl_x509_read($cert);
        $keyInfo  = openssl_pkey_get_private($key); // si tiene passphrase, aquí fallará

        dd([
            'cert_ok' => (bool) $certInfo,
            'key_ok'  => (bool) $keyInfo,
            'cert_error' => openssl_error_string(),
            'key_error'  => openssl_error_string(),
        ]);
        try {
            $afip = new Afip([
                'production' => true,
                'CUIT' => 30666810364,
                'res_folder' => storage_path('app/public/afip/'),
                'ta_folder'  => storage_path('app/public/afip/'),
                'cert'       => 'cert',
                'key'        => 'key',
            ]);
            try {
                $voucher_info = $afip->ElectronicBilling->GetVoucherInfo($id, 3, 211);
                dd($voucher_info);
            } catch (Throwable $e) {
                dd([
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                    'trace'   => $e->getTraceAsString(),
                ]);
            }
            echo "AFIP cargado OK\n";
        } catch (Throwable $e) {
            dd([
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);
        }
    }

    public function archivos($id)
    {
        $i = 1;
        $eva = $this->cantidad_archivos($id, 's', 15);

        $reserva = Reserva::find($id);
        $puede_eliminar = true;
        $puede_modificar = false;


        return view('admin.reservas.archivos', compact(
            'reserva',
            'eva',
            'i',
            'puede_eliminar',
            'id',
            'puede_modificar'
        ));
    }

    public function mostrarArchivo($id, string $filename)
    {
        $reserva = Reserva::findOrFail($id);

        if ($filename !== basename($filename)) {
            abort(404);
        }

        $path = 'reservas/' . $reserva->id . '/' . $filename;
        $disk = Storage::disk('local');

        if (! $disk->exists($path)) {
            abort(404);
        }

        return response()->file($disk->path($path), [
            'Content-Type' => $disk->mimeType($path) ?: 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function cantidad_archivos($id, $nombre, $largo)
    {
        $path = storage_path('app/reservas/' . $id . '/'); //Declaramos un  variable con la ruta donde guardaremos los archivos

        $archivos = array();
        $i = 1;

        if (file_exists($path)) {
            $files = File::allFiles($path);

            foreach ($files as $file) {
                $var = explode(".", $file->getFilename());
                $tipo =  substr($var[0], -$largo);
                //  if ($tipo == $nombre) {
                $archivos[$i]['nombre'] = $file->getFilename();
                $archivos[$i]['tamaño'] = $file->getSize();
                $archivos[$i]['extension'] = $file->getExtension();
                $i++;
                // }
            }
        }
        return $archivos;
    }
}
