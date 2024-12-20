@extends('adminlte::page')

@section('title', 'Archivos de Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')
<div class="card">


 

    <div class="card-body">
        @if($puede_modificar)
         
        <h2 class="text-center"><button type="submit" class="btn btn-primary">Cargar Archivos</button></h2>
        @endif
        <div class="row">
            <div class="info-card bg-secondary col-lg-12 col-md-6 col-xs-6">
                <label for="Archivo_Adjunto">Archivos Adjuntos</label>
                @if($puede_modificar)
                <input type="file" class="form-control" id="Archivo_Adjunto[]" name="Archivo_Adjunto[]" multiple="">
                @endif
                <div class="row">
                    @foreach($eva as $archivo)
                    <div class="info-card bg-secondary col-lg-12 col-md-6 col-xs-6">
                        <div class="card-header">
                            @if($puede_eliminar)
                             
                            <a href="{{route('admin.pacientes.delete_file',['id'=>$id, 'file_name'=>$archivo['nombre']])}}"
                                class="btn btn-xs btn-danger float-right" title="Eliminar" role="button">
                                <i class="fa fa-trash"></i></a>
                               
                            @endif
                        </div>
                        <div class="card-body">
                            @if($archivo['extension'] !== 'jpg' && $archivo['extension'] !== 'jpeg'
                            && $archivo['extension'] !== 'gif' && $archivo['extension'] !== 'png'
                            && $archivo['extension'] !== 'tiff' && $archivo['extension'] !== 'tif'
                            && $archivo['extension'] !== 'raw' && $archivo['extension'] !== 'bmp'
                            && $archivo['extension'] !== 'psd' )

                            @if($archivo['extension'] !== 'xls' && $archivo['extension'] !== 'doc'
                            && $archivo['extension'] !== 'xlsx' && $archivo['extension'] !== 'docx')

                            <embed name="plugin" src="{{url('storage/clientes/'.$id.'/archivos/'.$archivo['nombre'])}}"
                                type="application/pdf" style="width: 100%; height: 500px ">
                            @else
                            <img src="{{url('storage/clientes/'.$id.'/archivos/'.$archivo['nombre'])}}" style="width: 100% ; height: auto " class="center-block">
                            @endif
                            @else
                            <img src="{{url('storage/clientes/'.$id.'/archivos/'.$archivo['nombre'])}}" style="width: 100% ; height: auto " class="center-block">

                            @endif
                        </div>

                        <a type="button"
                            href="{{url('storage/clientes/'.$id.'/archivos/'.$archivo['nombre'])}}"
                            target="_blank" class="btn-secondary" title="{{$archivo['nombre']}}">
                            <p><span>{{$archivo['nombre']}}</span>
                            </p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>



        <div class="col-lg-12 col-md-12 col-xs-12">
            @if($puede_modificar)

            <h2 class="text-center"><button type="submit" class="btn btn-primary">Cargar Archivos</button></h2>

            @endif

        </div>
    </div>
</div>





@stop


@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@stop

@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>



@stop