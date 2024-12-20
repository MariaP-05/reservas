<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Localidad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


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

            $cliente->nombre = ucwords (strtolower( $request->nombre));
            
            $cliente->direccion =  (ucfirst($request->direccion));
            
            $cliente->mail = (strtolower ($request->mail));

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

        $eva = $this->cantidad_archivos($id, 'Archivo_Adjunto', 15);


       
        return view('admin.clientes.edit', compact('cliente','eva',  'localidades'));
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
           
            $cliente->nombre = ucwords (strtolower( $request->nombre));
            $cliente->dni = $request->dni;
            $cliente->fecha_nacimiento =$request->fecha_nacimiento;
            $cliente->direccion =  (ucfirst($request->direccion));
            $cliente->id_localidad = $request->id_localidad;
            $cliente->telefono = $request->telefono;
            $cliente->telefono_aux = $request->telefono_aux;
            $cliente->mail = (strtolower ($request->mail));
            $cadenas =  explode(". ", $request->observaciones);
            $cliente->observaciones = null; //pongo la observacion en null para evitar repeticiones
            foreach ($cadenas as $cadena) {
                if ($cliente->observaciones != null) //si ya tiene algun valor agrrego . espacio nueva oracion
                {
                    $cliente->observaciones = $cliente->observaciones . '. ' . ucfirst($cadena);

                } else { //si no tiene ningun valor solo nueva oracion (es la primer oracion)
                    $cliente->observaciones = ucfirst($cadena);
                }
            }
            //     dd($cadena, $request->observaciones, $cliente->observaciones );
           
           
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


    public function store_files_contenedor_files(Request $request, $id)
{
   
    $eva = count($this->cantidad_archivos($id, 'Archivo_Adjunto', 15)) + 1;      
    $this->store_files($request, $id, $eva, 'Archivo_Adjunto', 'Archivo_Adjunto');       

    return redirect()->back();
}

public function store_files_contenedor(Request $request, $id)
{
    $archivos = count($this->cantidad_archivos($id, 'Archivo_Adjunto', 15)) + 1;     
    $this->store_files($request, $id, $archivos, 'Archivo_Adjunto', 'Archivo_Adjunto');

    return redirect()->back();
}
public function cantidad_archivos($id, $nombre, $largo)
{
    $path = public_path() . '/storage/clientes/' . $id . '/archivos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

    $archivos = array();
    $i = 1;

    if (file_exists($path)) {
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $var = explode(".", $file->getFilename());
            $tipo =  substr($var[0], -$largo);
            if ($tipo == $nombre) {
                $archivos[$i]['nombre'] = $file->getFilename();
                $archivos[$i]['tamaño'] = $file->getSize();
                $archivos[$i]['extension'] = $file->getExtension();
                $i++;
            }
        }
    }
    return $archivos;
}

public function delete_file(Request $request, $id, $file_name)
{
    $directorio = public_path() . '/storage/clientes/' . $id . '/archivos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
    File::delete($directorio . $file_name);

    return redirect()->back();
}

public function store_files(Request $request, $id, $i, $nombre_archivo, $nuevo)
{
    foreach ($_FILES[$nombre_archivo]['tmp_name'] as $key => $tmp_name) {

        if ($_FILES[$nombre_archivo]["name"][$key]) {
            $var = explode(".", $_FILES[$nombre_archivo]['name'][$key]);
            $cant = count($var);
            $esten = $cant - 1;

            $filename = $nuevo . '.' . $var[$esten]; //Obtenemos el nombre original del archivo

            $source = $_FILES[$nombre_archivo]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo

            $direct = public_path() . '/storage/pacientes/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if (!file_exists($direct)) {
                mkdir($direct, 0777) or die("No se puede crear el directorio comuniquese con el area de sistemas");
            }
            $director = $direct . $id . '/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if (!file_exists($director)) {
                mkdir($director, 0777) or die("No se puede crear el directorio comuniquese con el area de sistemas");
            }

            $directorio = $director. '/archivos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777) or die("No se puede crear el directorio comuniquese con el area de sistemas");
            }

            $dir = opendir($directorio); //Abrimos el directorio de destino
            $fecha =  Carbon::now()->format('d-m-Y');
            $filename =  '_' . $fecha . '_' . $filename;
            $z = $this->verificar_archivo($id ,$filename,$i );
           
            while ($z == 1 )
            {
                $i++;
                $z = $this->verificar_archivo($id ,$filename, $i);
            }

            $target_path = $directorio . $i .$filename; //Indicamos la ruta de destino, así como el nombre del archivo
            move_uploaded_file($source, $target_path);

            closedir($dir);
        }
        $i++;
       
    }
    return redirect()->back()->with('message', 'Operation Successful !');
    //return redirect()->route('admin.comunicaciones.archivos', ['id' => $id]);
}

public function verificar_archivo($id, $nombre, $i)
{
    $path = public_path() . '/storage/clientes/' . $id . '/archivos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

    $z=0;

    if (file_exists($path)) {
        $files = File::allFiles($path);

        foreach ($files as $file) {
           
            if ($file->getFilename() == $i.$nombre) {
              $z=1;
            }
        }
    }
    return  $z;
}

public function archivos($id)
{
    $i = 1;
    $eva = $this->cantidad_archivos($id, 'Archivo_Adjunto', 15);
   
    $cliente = Cliente::find($id);
    $puede_eliminar = true;
    $puede_modificar = false;        
     
    return view('admin.clientes.archivos', compact('id','eva','i','puede_eliminar',
    'puede_modificar' ));
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
