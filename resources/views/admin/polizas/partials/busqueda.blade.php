<link href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
    rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet" />
<link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"  />

<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.css') }}">
<div class="cadr-body">
    <br>
    <div class="form-group col-sm-12" place-items= "center">
        <h4 class="box-title">Búsqueda</h4>
    </div>
    <hr>
    <div class="box-body">
        {{ Form::open(['route' => 'admin.polizas.index', 'method' => 'GET', 'role' => 'form']) }}
        <div class="form-group col-sm-12">
            <div class="row ">


                <div class="col-md-6 form-group">
                    <label for="id_cliente">Cliente</label>
                    {{ Form::select('id_cliente', $clientes, $id_cliente, ['id' => 'id_cliente', 'class' => 'form-control select2']) }}
                </div>

                <div class="col-md-6 form-group">
                    <label for="dominio">Dominio</label>
                    {{ Form::text('dominio', $dominio, ['id' => 'dominio', 'class' => 'form-control']) }}
                </div>

                <div class="col-md-6 form-group">
                    <label for="numero_poliza">Poliza</label>
                    {{ Form::text('numero_poliza', $numero_poliza, ['id' => 'numero_poliza', 'class' => 'form-control']) }}
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label for="id_estado_polizas">Estado</label>
                    {{ Form::select('id_estado_polizas', $estado_polizas, $id_estado_polizas, ['id' => 'id_estado_polizas', 'class' => 'form-control select2']) }}
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                </div>

                <div class="form-group col-sm-6">
                    <label for="vig_desde">
                        Vigencia Desde
                    </label>
                    <div class="input-group date">
                        {{ Form::text('vig_desde', $vigencia_desde, ['id' => 'vig_desde', 'class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group col-sm-6">
                    <label for="vig_hasta">
                        Vigencia Hasta
                    </label>
                    <div class="input-group date">

                        {{ Form::text('vig_hasta', $vigencia_hasta, ['id' => 'vig_hasta', 'class' => 'form-control']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer form-group">
        <div class="form-group pull-rigth col-sm-6" place-items= "center">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </div>
    {{ Form::close() }}
</div>
{{ Form::hidden('id_cliente') }}
{{ Form::hidden('dominio') }}

</div>
<br>
