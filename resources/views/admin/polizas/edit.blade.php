@extends('adminlte::page')

@section('title', 'Nueva Poliza')


@section('content_header')
<h1>Polizas</h1>
  
<link href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet"/>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" ></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet"/>
<link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.css') }}"> 
@stop

@section('content')
<div class="card">
    <div class="cadr-body">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    
                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    @if(isset($poliza))
                    {{ Form::model($poliza,['route'=>['admin.polizas.update', $poliza->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.polizas.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($poliza->id))
                    <div class="row  col-md-12">
                    <div class="form-group col-md-6">
                        <label for="id">{{ trans('message.code') }}</label>
                        {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                    </div>
                    </div>
                    @endif
                   
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_compania">Compañia</label>
                            {{ Form::select('id_compania', $companias, null,  array('id' => 'id_compania','class' => 'select2 form-control ')) }}
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_cliente">Cliente</label>
                                {{ Form::select('id_cliente', $clientes, null,  array('id' => 'id_cliente','class' => 'form-control select2')) }}
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        
                    </div>                   

                    <div class="row  col-md-12">                       
                        <div class="col-md-6 form-group has-feedback">
                            <label for="numero_poliza">Número Poliza</label>
                            {{ Form::text('numero_poliza', null, array('id' => 'numero_poliza','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        @if(isset($poliza->id))
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_estado_polizas">Estado</label>
                            {{ Form::select('id_estado_polizas', $estado_polizas, null,  array('id' => 'id_estado_polizas','class' => 'form-control select2')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        @endif
                    </div>      


                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                                <label for="vigencia_desde">Vigencia desde</label>
                                <div class="input-group date">
                                    
                                    {{ Form::text('vigencia_desde',isset($valor->vigencia_desde) ? $valor->vigencia_desde : null,  array('id' => 'vigencia_desde','class' => 'form-control')) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                
                        </div>
                            <div class="col-md-6 form-group has-feedback">
                                <label for="vigencia_hasta">Vigencia hasta</label>
                                <div class="input-group date">
                        
                                    {{ Form::text('vigencia_hasta',isset($valor->vigencia_hasta) ? $valor->vigencia_hasta : null,  array('id' => 'vigencia_hasta','class' => 'form-control')) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                    </div>

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="vehiculo">Vehículo</label>
                            {{ Form::text('vehiculo', null, array('id' => 'vehiculo','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="marca">Marca</label>
                            {{ Form::text('marca', null, array('id' => 'marca','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div> 

                    <div class="row col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="dominio">Dominio</label>
                            {{ Form::text('dominio', null, array('id' => 'dominio','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_seccion">Sección</label>
                                {{ Form::select('id_seccion', $secciones, null,  array('id' => 'id_seccion','class' => 'form-control select2')) }}
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                    </div> 

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                        <label for="id_forma_pago">Forma de Pago</label>
                            {{ Form::select('id_forma_pago', $formas_pago, null,  array('id' => 'id_forma_pago','class' => 'form-control select2')) }}
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="cantidad_cuotas">Cantidad de Cuotas</label>
                            {{ Form::text('cantidad_cuotas', null, array('id' => 'cantidad_cuotas','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div> 
                    
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                        <label for="id_productor">Productor</label>
                            {{ Form::select('id_productor', $productores, null,  array('id' => 'id_productor','class' => 'form-control select2')) }}
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="cobertura">Cobertura</label>
                            {{ Form::text('cobertura', null, array('id' => 'cobertura','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div> 
                    
                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-danger" href="{{route('admin.polizas.index')}}">{{ trans('message.close') }}</a>
                        <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
                    </div>
                    {{ Form::close() }}
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.box -->
        </div>


    </div>
</div>
@stop

@section('css')
@stop


@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script type="text/javascript"> 
    $(document).ready(function() {
       
        $('.select2').select2();  
    
        $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '<Ant',
      nextText: 'Sig>',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      weekHeader: 'Sm',
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    };
    
    $.datepicker.setDefaults($.datepicker.regional['es']);
     
      $("#vigencia_desde").datepicker(
        {
           todayBtn: "linked",
           language: 'es',
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'dd-mm-yy' 
       }
      );
      
         $("#vigencia_hasta").datepicker(
        {
           todayBtn: "linked",
           language: 'es',
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'dd-mm-yy' 
       }
      );
    });
    </script>

@stop