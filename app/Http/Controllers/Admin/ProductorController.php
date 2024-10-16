<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Productor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; 

class ProductorController extends Controller
{
    public function index()
    {
        $productores = Productor::all();

        return view('admin.productores.index', compact('productores'));
    }

    public function create()
    {
        return view('admin.productores.edit');
    }

    public function store(Request $request)
    {

        try {
            $productor = new Productor($request->all());

            $productor->save();

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.productores.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.productores.index');
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
        $productor = Productor::findOrFail($id);
        
        return view('admin.productores.edit', compact('productor' ));
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
            
            $productor = Productor::findOrFail($id);
            
                $productor->nombre = $request->nombre;
                $productor->codigo = $request->codigo;
                $productor->matricula = $request->matricula;
                
                $productor->save();

                session()->flash('alert-success', trans('message.successaction'));
                return redirect()->route('admin.productores.index');
        } catch (QueryException  $ex) {
            
                 session()->flash('alert-danger', $ex->getMessage());
                return redirect()->route('admin.productores.index');
           
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
           
            Productor::destroy($id);

            session()->flash('alert-success', trans('message.successaction'));
            return redirect()->route('admin.productores.index');
        } catch (QueryException  $ex) {
            session()->flash('alert-danger', $ex->getMessage());
            return redirect()->route('admin.productores.index');
        }
    }

}
