<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Estado_poliza;
use App\Models\Compania;
use App\Models\Productor;
use App\Models\Seccion;
use App\Models\Forma_pago;
use App\Models\Poliza;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PDF;
use File;
use Response;

class PolizaController extends Controller
{
    public function index(Request $request)
    {
        $polizas = Poliza::search($request)->get();
        //$this->insert_servicios();
       // $polizas = Poliza::all();

       $vigencia_desde = null;

       if (isset($request->vig_desde)) {
           $vigencia_desde = $request->vig_desde;
       }
       $vigencia_hasta = null;

       if (isset($request->vig_hasta)) {
           $vigencia_hasta = $request->vig_hasta;
       }


        $dominio = null;

        if (isset($request->dominio)) {
            $dominio = $request->dominio;
        }

        $numero_poliza = null;

        if (isset($request->numero_poliza)) {
            $numero_poliza = $request->numero_poliza;
        }


        $clientes = Cliente::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $clientes = array('' => trans('message.select')) + $clientes;

        if (isset($request->id_cliente)) {
            $id_cliente = $request->id_cliente;
        } else {
            $id_cliente = null;
        }


        $estado_polizas = Estado_poliza::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estado_polizas = array('' => trans('message.select')) + $estado_polizas;

        if (isset($request->id_estado_polizas)) {
            $id_estado_polizas = $request->id_estado_polizas;
        } else {
            $id_estado_polizas = null;
        }

        return view('admin.polizas.index', compact('polizas', 'id_cliente', 'clientes',
         'numero_poliza', 'dominio', 'estado_polizas','id_estado_polizas',
          'vigencia_desde', 'vigencia_hasta'));
    }

    public function create()
    {
        $secciones = Seccion::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $secciones = array('' => trans('message.select')) + $secciones;

        $clientes = Cliente::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $clientes = array('' => trans('message.select')) + $clientes;

        $productores = Productor::orderBy('nombre')->pluck('nombre', 'id')->all();
        $productores = array('' => trans('message.select')) + $productores;

        $companias = Compania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $companias = array('' => trans('message.select')) + $companias;

        $formas_pago = Forma_pago::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $formas_pago = array('' => trans('message.select')) + $formas_pago;


          
        return view('admin.polizas.edit', compact('secciones','clientes','productores','companias','formas_pago'));
    }

    public function store(Request $request)
    {

        try {
            $poliza = new poliza($request->all());
           $poliza->id_estado_polizas = 1;

            $poliza->save();
 
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.polizas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.polizas.index');
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
        $poliza = poliza::findOrFail($id);


        $clientes = Cliente::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $clientes = array('' => trans('message.select')) + $clientes;

        $secciones = Seccion::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $secciones = array('' => trans('message.select')) + $secciones;

        $companias = Compania::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $companias = array('' => trans('message.select')) + $companias;

        $formas_pago = Forma_pago::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $formas_pago = array('' => trans('message.select')) + $formas_pago;

        $productores = Productor::orderBy('nombre')->pluck('nombre', 'id')->all();
        $productores = array('' => trans('message.select')) + $productores;
        
        $estado_polizas = Estado_poliza::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estado_polizas = array('' => trans('message.select')) + $estado_polizas;

        return view('admin.polizas.edit', compact('poliza', 'clientes', 'secciones', 'companias', 'formas_pago', 'productores', 'estado_polizas' ));
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
            $poliza = Poliza::findOrFail($id);
        
            $poliza->id_compania = $request->id_compania;
            $poliza->id_cliente = $request->id_cliente;
            $poliza->id_seccion = $request->id_seccion;
            $poliza->id_forma_pago = $request->id_forma_pago;
            $poliza->id_productor = $request->id_productor;
            $poliza->numero_poliza = $request->numero_poliza;
            $poliza->vigencia_desde = $request->vigencia_desde;
            $poliza->vigencia_hasta = $request->vigencia_hasta;
            $poliza->vehiculo = $request->vehiculo;
            $poliza->marca =$request->marca;
            $poliza->dominio =$request->dominio;
            $poliza->dominio =$request->dominio;
            $poliza->cantidad_cuotas = $request->cantidad_cuotas;
            $poliza->cobertura = $request->cobertura;
            $poliza->id_estado_polizas = $request->id_estado_polizas;
            
            $poliza->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.polizas.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.polizas.index');
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
           
            Poliza::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.polizas.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.polizas.index');
        }


    }

/*    // Generate TXT
    public function createTXT()
    {
      //  $clientes = Cliente::get();
        $clientes = ClienteServicios::select('id_cliente')->groupby('id_cliente')->get();

       // dd( $clientes , $clientes_2);
        $fecha_cobro = new Carbon();
        $fecha_cobro->firstOfMonth();
        $fecha_cobro->addDays(9);

        $fecha_presentacion = new Carbon();

        if ($fecha_cobro->format('l') == 'Sunday' || $fecha_cobro->format('l') == 'Saturday') {
            $searchDay = 'Monday';
            $fecha_cobro = Carbon::createFromTimeStamp(strtotime("next $searchDay", $fecha_cobro->timestamp));
        }

        $cantidad_clientes = count($clientes);
        $cantidad_clientes = str_pad($cantidad_clientes, 6, "0", STR_PAD_LEFT);


        $importe_total = 0;
        foreach ($clientes as $cliente) {
          //  dd($cliente->id_cliente);
            $cliente = Cliente::find($cliente->id_cliente);
            $importe_cobrar = 0;
            $t =0;
            $valores = [];
            foreach ($cliente->ClienteServicios as $servicio) { 
               $fecha_hasta = new Carbon($servicio->fecha_hasta);
                if ($fecha_hasta  >= $fecha_presentacion || is_null($servicio->fecha_hasta)) {
                    $valor = ServicioValor::where('id_servicio', $servicio->id_servicio)
                        ->where('fecha', '<=', $fecha_cobro)
                        ->OrderBy('fecha', 'desc')->first();
                    $importe_cobrar += $valor->valor;
                    $t++;
                    $valores[]=$valor->valor;
                }
                 
            }
           
            if($cliente->descuento > 0)
            {
                $importe_cobrar = $importe_cobrar - ($importe_cobrar  * 10 /100 );
            }
  
            $whole = (int)floor($importe_cobrar);      // 1
            $fraction = ($importe_cobrar - $whole) * 1000; // .25
            $fraction = (int)$fraction;
            //formatear a 14 digitos ultimos 3 digitos son decimales
            $whole = str_pad($whole, 11, "0", STR_PAD_LEFT);
            $fraction = str_pad($fraction, 3, "0", STR_PAD_LEFT);
            $importe_total += $importe_cobrar;

            //cbu formatear a 22 caracteres con 00 delante 
            $cliente->cbu = substr($cliente->cbu, 0, 22);
            $cliente->cbu = str_pad($cliente->cbu, 22, "0", STR_PAD_LEFT);


            //id cliente formatear a 12 caracteres con 0 delante 
            $numero_cliente = substr($cliente->id, 0, 10);
            $numero_cliente = str_pad($numero_cliente, 10, "0", STR_PAD_LEFT);
            //cuit formatear a 11 caracteres con 0 delante 
            $cliente->cuit = substr($cliente->cuit, 0, 11);
            $cliente->cuit = str_pad($cliente->cuit, 11, "0", STR_PAD_LEFT);
            //denominacion formatear a 16 caracteres completar con espacios al final
            $cliente->denominacion = str_replace('Ñ','N', strtoupper($cliente->denominacion));
            $cliente->denominacion = substr($cliente->denominacion, 0, 16);
            $cliente->denominacion = str_pad($cliente->denominacion, 16, ' ', STR_PAD_RIGHT);

            $linea[] =   $cliente->TipoCliente->codigo . '0000' . $cliente->cbu . '01' . $whole . $fraction .
                $fecha_cobro->format('Ymd') . $numero_cliente . $cliente->cuit . $cliente->denominacion . 'GEOSECURITY' 
               ;
        }

        $whole = (int)floor($importe_total);      // 1
        $fraction = ($importe_total - $whole) * 1000; // .25
        $fraction = (int)$fraction;
        //formatear a 14 digitos ultimos 3 digitos son decimales
        $whole = str_pad($whole, 11, "0", STR_PAD_LEFT);
        $fraction = str_pad($fraction, 3, "0", STR_PAD_LEFT); 
       
        $cabecera[] = '999604520101' . $fecha_presentacion->format('Ymd') . '000001' . $whole . $fraction
            . $cantidad_clientes . 'SERVICIO            ' . $fecha_presentacion->format('Ymd')
            .'                                                                                                                                                       ' . PHP_EOL;

        foreach ($linea as $lin) {
            $cabecera[] = $lin.            '                                                                                                                             ' . PHP_EOL;
        }
        // $cabecera[] = $linea;
        //   $data = json_encode( $linea);        
        $data =  $cabecera;
        File::put(public_path('/archivo.txt'), $data);
        return Response::download(public_path('/archivo.txt'), 'TXT_'.$fecha_cobro->format('m-Y').'.txt');
    }

  

    public function createPDF()
    {
        $clientes = Cliente::get();
        $fecha_presentacion = new Carbon();
                $data = [
            'clientes' => $clientes ,
            'fecha_presentacion' =>  $fecha_presentacion
        ]; 
        $pdf = PDF::loadView('admin.clientes.createPDF', $data);
         
       
        return $pdf->download('Listado_Servicios_Activos.pdf') ;
    }
     */
    /*
    $clientes = Cliente::get();
        //$linea = '';
        foreach($clientes as $cliente)
        {
            $linea[] =   $cliente->id.'00000'.$cliente->denominacion.'00012300 1500.23';
        }
       // $data =$dat;
      /*    $data = [
            'lineas' => $linea,
            'date' => date('m/d/Y') 
        ]; 
            
        $pdf = PDF::loadView('admin.clientes.createPDF', $data);
     
        return $pdf->download('probando.pdf') ;*/
   
}
