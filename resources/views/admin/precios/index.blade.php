@extends('adminlte::page')

@section('title', 'Lista de Precios')

@section('content_header')
    <h1>Precios</h1>
@stop

@section('content')
<div class="card">
    <a  href="{{route('admin.precios.create')}}"
  title="Crear Nuevo Precio" 
    style="position:fixed;	width:60px;	height:60px; top:57px;	right:40px;
    background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
    font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;" 
    target="_blank"
    onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
    onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-plus" style="margin-top:16px"></i>
    </a>
<div class="cadr-body">
    <div class="form-group col-sm-12">
        <div class="row">
            <br>
        </div>
    <table id="precios" class="table table-striped col-sm-12">
        <thead class="bg-secondary text-white">
            <tr>
                <th>Id</th>
                <th>Cabaña</th>
                <th>Fecha desde</th>
                <th>Valor</th>                 
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($precios as $precio)
            <tr>
                <td>{{$precio->id}}</td>
                <td>{{ isset($precio->Cabania) ? $precio->Cabania->denominacion : '' }}</td>
                <td>{{$precio->fecha_desde}}</td>
                <td>{{$precio->valor}}</td>                 
                <td>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <form method="post" action="{{ route('admin.precios.destroy', $precio->id) }}">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger"
                                    title="Eliminar Precio">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 form-group">
                             <form method="get" action="{{route('admin.precios.edit',$precio->id)}}">
                             <button type="submit" class="btn btn-outline-primary" title="Editar Precio">
                                    <i class="fa fa-edit"></i>
                             </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
@stop

@section('css')
   @stop

@section('js')
 
<script src="{{ asset('admin1/precios/index.js') }}"></script>
   

@stop