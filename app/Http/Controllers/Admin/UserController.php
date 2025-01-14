<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use App\Models\User;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.edit');
    }

    public function store(Request $request)
    {
       

        try {
            $usuario = new User($request->all());
            $usuario->password = bcrypt($usuario->password);

            $usuario->save();

        
            
            return redirect()->route('admin.users.index')->with('success', trans('message.successaction'));
        } catch (QueryException  $ex) {
          
            return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
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
        $user = User::findOrFail($id);
        
        return view('admin.users.edit', compact('user' ));
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
            
            $usuario = User::findOrFail($id);
           
            
            if (isset($request->password) && $request->password !== '') {
                $usuario->password = bcrypt($request->password);
         
            }

          
             
                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->save();
 
            
                return redirect()->route('admin.users.index')->with('success', trans('message.successaction'));
            } catch (QueryException  $ex) {
              
                return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
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
            $movimientos = Movimiento::where('id_usuario', $id)->count();
            if ($movimientos == 0 ) {
               User::destroy($id);
               return redirect()->route('admin.users.index')->with('success', trans('message.successaction'));
            }
   
            else{
               return redirect()->route('admin.users.index')->with('error', '¡Error! El Usuario tiene asignado un Movimiento, no se puede eliminar.');
            }
   
           
           } catch (QueryException  $ex) {
               //session()->flash('alert-danger', $ex->getMessage());
               return redirect()->route('admin.users.index')->with('error', $ex->getMessage());
           }
       }
    }
