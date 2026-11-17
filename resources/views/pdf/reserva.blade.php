<!DOCTYPE html>
<html>

<head>
    <title>RESERVA {{isset($reserva->Cliente) ? $reserva->Cliente->nombre : '' }}</title>
    <style>
        @page {
            margin: 0px;
        }

        header {
            margin: 0px;
        }

        html {
            margin: 0px;
        }

        .img {
            filter: blur(5px);

        }
    </style>
</head>

<header>
    <img src="{{ asset('img/alto.jpg')}}" alt="alto" style="height: 200px; width: 800px;">

</header>

<main>

    <div class="container">
        <table class="titulo" style="width: 100%;">
            <thead>
                <tr>
                    <th style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size:30px; padding-top: 2em;"></th>
                </tr>
                <br>
                <br>

                <tr>
                    <th style="font-size:xx-large; color:saddlebrown">RESERVA</th>
                </tr>
                <hr style="width: 100%;">
            </thead>
        </table>
        <table class="datos" style="width: 100%;">
            <tbody>
                <br>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Cliente: <b>{{ isset($reserva->Cliente) ? $reserva->Cliente->nombre : '' }}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">DNI: <b>{{ number_format(isset($reserva->Cliente) ? $reserva->Cliente->dni : '' , 0 ,',', '.') != 0 ? number_format(isset($reserva->Cliente) ? $reserva->Cliente->dni : '' , 0 ,',', '.') : ''}}</b></td>
                </tr>

                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Cabaña: <b>{{ isset($reserva->Cabania) ? $reserva->Cabania->denominacion : '' }}</b></td>
                </tr>

                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Cantidad de huéspedes: <b>{{ $reserva->cantidad_personas}}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Fecha de ingreso: <b>{{ $reserva->fecha_desde }}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Fecha de salida: <b>{{ $reserva->fecha_hasta }}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Cantidad de Noches: <b>{{ $reserva->cant_dias }}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Tarifa acordada: <b> {{$reserva->moneda == 'Dolares' ? 'U$S ' : '$ '}} {{number_format(( $reserva->valor ) , 2, ',', '.')}}</b></td>
                </tr>
            </tbody>


        </table>
        <br>

        <table class="titulo" style="width: 100%;">
            <thead>
                <br>
                <br>
                <tr>
                    <th style="font-size:xx-large; color:saddlebrown">PAGO</th>
                </tr>
                <hr style="width: 100%;">
            </thead>
        </table>

        <table class="datos" style="width: 100%;">
            <tbody>
                <br>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Recibido al reservar: <b>{{$reserva->moneda == 'Dolares' ? 'U$S ' : '$ '}} {{number_format(($reserva->senia) , 2, ',', '.')}}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Fecha de pago: <b> {{$reserva->fecha_reserva}}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Saldo a pagar al ingresar: <b>{{$reserva->moneda == 'Dolares' ? 'U$S ' : '$ '}} {{number_format(($reserva->valor - $reserva->senia) , 2, ',', '.')}}</b></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
</main>

<footer >
     <img src="{{ asset('img/estadia.jpg')}}" alt="estadia" style="height: 200px; width: 800px; padding-top: 3em;>  
</footer>

</html>