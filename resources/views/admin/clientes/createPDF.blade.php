<!DOCTYPE html>
<html>
<head>
    <title>Listado de servicios de los clientes al dia de la Fecha </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h4>Listado de servicios activos al dia de la fecha: {{$fecha_presentacion->format('d-m-Y')}}</h4>
    
  
    <table class="table table-bordered">
        <tr>
            
            <th>Cliente</th>            
            <th>Servicios</th>
            <th>Descuento</th>
            <th>Total</th>
        </tr>
        <?php $total_todos = 0 ?>
        <?php $cantidad_servicios = 0 ?>
        @foreach($clientes as $cliente)
      
        <tr>
             
            <td>{{ $cliente->denominacion }}</td>
            
            <td>
            <?php $total = 0 ?>
            @foreach ($cliente->ClienteServicios as $servicio) 
            <?php $fecha_fin = new Carbon\Carbon ($servicio->fecha_hasta)?>
                @if ($fecha_fin >= $fecha_presentacion || is_null($servicio->fecha_hasta)) 
                   {{$servicio->ServicioValorActivo()->Servicio->nombre. ' $' . number_format($servicio->ServicioValorActivo()->valor, 2, ',', '.')    }}</br>
                   <?php $total += $servicio->ServicioValorActivo()->valor ?>
                   <?php $cantidad_servicios++ ?>
                   @else
                   {{$servicio->fecha_hasta. ' ' .$fecha_presentacion. ' '.$servicio->ServicioValorActivo()->Servicio->nombre. ' $' . number_format($servicio->ServicioValorActivo()->valor, 2, ',', '.')    }}</br>
                   
                   @endif 
            @endforeach
            </td> 
            <?php $total = $total - ($total * $cliente->descuento /100)  ?>
            <?php $total_todos += $total ?>
            <td>{{ $cliente->descuento }}</td>
            <td>${{ number_format($total, 2, ',', '.')  }}</td>
        </tr>
       
        @endforeach
    </table>
    <p>El Total a Cobrar es ${{number_format($total_todos, 2, ',', '.')}}</p>
    <p>La cantidad de servicios a cobrar es {{$cantidad_servicios}}</p>
     
</body>
</html>