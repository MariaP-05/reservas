<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tarea;
use App\Models\Estado_tarea;
use App\Models\Historial_obs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    public function index(Request $request)
    {
        $tareas = Tarea::search($request)->get();

        $fecha_desde = null;

        if (isset($request->fec_desde)) {
            $fecha_desde = $request->fec_desde;
        }
        $fecha_hasta = null;

        if (isset($request->fec_hasta)) {
            $fecha_hasta = $request->fec_hasta;
        }
 
         //buscar usuarios
        //en la vista se mostrara el select con los usuarios 
        $usuarios = User::orderBy('name')->pluck('name', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        if (isset($request->id_usuario)) {
            $id_usuario = $request->id_usuario;
        } else {
            $id_usuario = null;
        }
        $estados_tarea = Estado_tarea::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estados_tarea = array('' => trans('message.select')) + $estados_tarea;

         if (isset($request->estado)) {
            $estado = $request->estado;
        } else {
            $estado = null;
        }


        return view('admin.tareas.index', compact('tareas', 'fecha_desde',
            'fecha_hasta', 'usuarios', 'id_usuario', 'estado', 'estados_tarea'));
    }

    public function create()
    {
    
        $usuarios = User::orderBy('name')->pluck('name', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        $estados_tarea = Estado_tarea::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estados_tarea = array('' => trans('message.select')) + $estados_tarea;


        return view('admin.tareas.edit', compact('usuarios','estados_tarea'));
    }

    public function store(Request $request)
    {

        try {

            $tarea = new Tarea($request->all());
            if($tarea->id_estado_tarea == '' || $tarea->id_estado_tarea == null)
            {
                $tarea->id_estado_tarea = 1;
            }
 
            $tarea->save();

            if(isset($request->observaciones))
            {
            $historial_obs = new Historial_obs();
           
            $fecha = new Carbon();
            $historial_obs->fecha  = $fecha->format('Y-m-d');
            $historial_obs->id_usuario = Auth::User()->id ;
            $historial_obs->id_tarea = $tarea->id;


            //divido las observaciones en oraciones
            $cadenas =  explode(". ", $request->observaciones);
            $historial_obs->observaciones= null; //pongo la observacion en null para evitar repeticiones
            foreach($cadenas as $cadena )
            {
                if($historial_obs->observaciones != null) //si ya tiene algun valor agrrego . espacio nueva oracion
                {
                    $historial_obs->observaciones = $historial_obs->observaciones . '. '. ucfirst($cadena );
                }
                else
                {//si no tiene ningun valor solo nueva oracion (es la primer oracion)
                    $historial_obs->observaciones = ucfirst($cadena );
                }
               
            }
         


            $historial_obs->save();
            }
           

 
            
            return redirect()->route('admin.tareas.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
          
            return redirect()->route('admin.tareas.index')->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $tarea = Tarea::findOrFail($id);


        $usuarios = User::orderBy('name')->pluck('name', 'id')->all();
        $usuarios = array('' => trans('message.select')) + $usuarios;

        $estados_tarea = Estado_tarea::orderBy('denominacion')->pluck('denominacion', 'id')->all();
        $estados_tarea = array('' => trans('message.select')) + $estados_tarea;



        return view('admin.tareas.edit', compact('tarea', 'usuarios', 'estados_tarea' ));
    }

    public function update(Request $request, $id)
    {
        try {
            $tarea = Tarea::findOrFail($id);
        
            $tarea->denominacion = $request->denominacion;
            $tarea->fecha = $request->fecha;
            $tarea->descripcion = $request->descripcion;
            $tarea->prioridad =ucwords(strtolower($request->prioridad));
            $tarea->id_usuario = $request->id_usuario;
            $tarea->id_estado_tarea = $request->id_estado_tarea;
        
            $tarea->observaciones = $request->observaciones;
            $tarea->save();

            if(isset($request->observaciones))
            {
            $historial_obs = new Historial_obs();
           
            $fecha = new Carbon();
            $historial_obs->fecha  = $fecha->format('Y-m-d');
            $historial_obs->id_usuario = Auth::User()->id ;
            $historial_obs->id_tarea = $tarea->id;

            //divido las observaciones en oraciones
            $cadenas =  explode(". ", $request->observaciones);
            $historial_obs->observaciones= null; //pongo la observacion en null para evitar repeticiones
            foreach($cadenas as $cadena )
            {
                if($historial_obs->observaciones != null) //si ya tiene algun valor agrrego . espacio nueva oracion
                {
                    $historial_obs->observaciones = $historial_obs->observaciones . '. '. ucfirst($cadena );
                }
                else
                {//si no tiene ningun valor solo nueva oracion (es la primer oracion)
                    $historial_obs->observaciones = ucfirst($cadena );
                }
               
            }
         


            $historial_obs->save();
            }

          
            return redirect()->route('admin.tareas.index')->with ('success', trans('message.successaction'));
        } catch (QueryException  $ex) {

           
            return redirect()->route('admin.tareas.index')->with('error', $ex->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
        
            Tarea::destroy($id);
           
           
          return redirect()->route('admin.tareas.index')->with('success', trans('message.successaction'));
       
        
        } catch (QueryException  $ex) {
            //session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.tareas.index')->with('error', $ex->getMessage());
        }
    }


    public function delete_ho($id)


    {
        try {
            
        Historial_obs ::destroy($id);


        session()->flash('alert-success', trans('message.successaction'));
        return redirect()->back();
    } catch (QueryException  $ex) {
        session()->flash('alert-danger', $ex->getMessage());
        return redirect()->back();
    }
       
    }

}