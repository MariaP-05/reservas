<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Localidad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PDF;
use File;
use Response;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        $localidades = Localidad::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $localidades = array('' => trans('message.select')) + $localidades;

        return view('admin.clientes.edit', compact('localidades'));
    }

    public function store(Request $request) //guardar nuevo
    {

        try {
            $cliente = new Cliente($request->all());

            $cliente->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.clientes.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.clientes.index');
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
        $cliente = Cliente::findOrFail($id);
        

        $localidades = Localidad::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $localidades = array('' => trans('message.select')) + $localidades;

       
        return view('admin.clientes.edit', compact('cliente',  'localidades'));
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
           
            $cliente = Cliente::findOrFail($id);
           
            $cliente->denominacion = $request->denominacion;
            $cliente->id_localidad = $request->id_localidad;
            $cliente->mail = $request->mail;
            $cliente->mail_2 = $request->mail_2;
            $cliente->cuit = $request->cuit;
            $cliente->direccion = $request->direccion;
            $cliente->telefono = $request->telefono;
            $cliente->celular = $request->celular;
            $cliente->fecha_nacimiento =$request->fecha_nacimiento;
           
           
            $cliente->save();
            //;
          //  dd($cliente->save());
            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.clientes.index');
        } catch (QueryException  $ex) {

            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.clientes.index');
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
           
            Cliente::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.clientes.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.clientes.index');
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
