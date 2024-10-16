<?php

use App\Http\Controllers\Admin\ClienteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function(){
    return redirect()->route('login');
    
});

Route::get('admin/clientes/createTXT', [ClienteController::class, 'createTXT'] )->name('admin.clientes.createTXT')->middleware('auth');
Route::get('admin/clientes/createPDF', [ClienteController::class, 'createPDF'] )->name('admin.clientes.createPDF')->middleware('auth');
Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class)->names('admin.users')->middleware('auth');
Route::resource('admin/clientes', App\Http\Controllers\Admin\ClienteController::class)->names('admin.clientes')->middleware('auth');

Route::resource('admin/formas_pago', App\Http\Controllers\Admin\Forma_pagoController::class)->names('admin.formas_pago')->middleware('auth');
Route::resource('admin/secciones', App\Http\Controllers\Admin\SeccionController::class)->names('admin.secciones')->middleware('auth');
Route::resource('admin/productores', App\Http\Controllers\Admin\ProductorController::class)->names('admin.productores')->middleware('auth');
Route::resource('admin/companias', App\Http\Controllers\Admin\CompaniaController::class)->names('admin.companias')->middleware('auth');
Route::resource('admin/polizas', App\Http\Controllers\Admin\PolizaController::class)->names('admin.polizas')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
