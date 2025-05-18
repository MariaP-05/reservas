
<div class="cadr-body">
    <br>
    <div class="form-group col-sm-12" place-items= "center">
        <h4 class="box-title">Búsqueda</h4>
    </div>
    <div class="box-body">
        {{ Form::open(['route' => 'admin.tareas.index', 'method' => 'GET', 'role' => 'form']) }}
        <div class="form-group col-sm-12">
            <div class="row ">

                <div class="form-group col-sm-4">
                    <label for="fec_desde">Fecha Desde</label>
                    <div class="input-group date">
                        {{ Form::text('fec_desde', $fecha_desde, ['id' => 'fec_desde', 'class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label for="fec_hasta">Fecha Hasta</label>
                    <div class="input-group date">
                        {{ Form::text('fec_hasta', $fecha_hasta, ['id' => 'fec_hasta', 'class' => 'form-control']) }}
                    </div>
                </div>
 
                  <div class="form-group col-sm-4">
                    <label for="id_usuario">Usuario</label>
                        {{ Form::select('id_usuario', $usuarios, $id_usuario,  ['id' => 'id_usuario','class' => 'form-control select2']) }}
                </div>

                 <div class="form-group col-md-4">
                            <label for="estado">Estado</label>
                           {{ Form::select('id_estado_tarea', $estados_tarea, $estado, ['id' => 'id_estado_tarea', 'class' => 'form-control select2']) }}
                                      
                        </div>
            </div>
        </div>
    </div>
    <div class="box-footer form-group">
        <div class="form-group pull-rigth col-sm-6" place-items= "center">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
        </div>
    </div>
    {{ Form::close() }}
</div> 
{{ Form::hidden('fec_desde') }}
{{ Form::hidden('fec_hasta') }}
{{ Form::hidden('id_categoria') }}
