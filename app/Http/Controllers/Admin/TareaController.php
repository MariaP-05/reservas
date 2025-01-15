<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tarea;
use App\Models\Estado_tarea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class TareaController extends Controller
{
    public function index(Request $request)
    {
        $tareas = Tarea::all();

        return view('admin.tareas.index', compact('tareas'));
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

            $tareas = new Tarea($request->all());

            $tareas->save();
 
            
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
        
            $tarea->denominacion =ucwords(strtolower($request->denominacion));
            $tarea->fecha = $request->fecha;
            $tarea->descripcion = $request->descripcion;
            $tarea->prioridad =ucwords(strtolower($request->prioridad));
            $tarea->id_usuario = $request->id_usuario;
            $tarea->id_estado_tarea = $request->id_estado_tarea;
        
            $tarea->observaciones = $request->observaciones;
            $tarea->save();

          
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
}