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
    <img src="{{ asset('img/mar.png')}}" alt="mar" height="170px" width="800px">

</header>

<main>

    <div class="container">
        <table class="titulo" style="width: 100%;">
            <thead>
                <tr>
                    <th style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size:30px; padding-top: 2em;">ALTO DE LAS PAMPAS</th>
                </tr>
                <br>
                <br>

                <tr>
                    <th style="font-size: large;">RESERVA</th>
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
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">DNI: <b>{{ number_format(isset($reserva->Cliente) ? $reserva->Cliente->dni : '' , 0 ,',', '.')}}</b></td>
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
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em;">Tarifa acordada: <b> ${{number_format(( $reserva->valor ) , 2, ',', '.')}}</b></td>
                </tr>
            </tbody>


        </table>
        <br>

        <table class="titulo" style="width: 100%;">
            <thead>
                <br>
                <br>
                <tr>
                    <th style="font-size: large;">PAGO</th>
                </tr>
                <hr style="width: 100%;">
            </thead>
        </table>

        <table class="datos" style="width: 100%;">
            <tbody>
                <br>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Recibido al reservar: <b>${{number_format(($reserva->senia) , 2, ',', '.')}}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Fecha de pago: <b> {{$reserva->created_at->format('d-m-Y')}}</b></td>
                </tr>
                <tr>
                    <td style="font-family:Verdana, Geneva, Tahoma, sans-serif; font-size:medium; padding-left: 5em; ">Saldo a pagar al ingresar: <b>${{number_format(($reserva->valor - $reserva->senia) , 2, ',', '.')}}</b></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
</main>

<footer style="padding-top: 8em;">
        <div class="row">
            <div style="text-align:left; line-height:0; display:inline-block; padding-left: 8em;">
                <b style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:15px;">Alto de las Pampas</b>
                <br>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:12px;">Villa Gesell - Mar de las Pampas - Argentina</p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:12px;">Whatsapp <b><a href="https://api.whatsapp.com/send?phone=5492255576581">+54 9 2255 57-6581</a></b></p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:12px;">Facebook <b><a href="www.facebook.com/altodelaspampas">altodelaspampas</a></b></p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:12px;">Instagram <b><a href="www.instagram.com/altodelaspampas">altodelaspampas</a></b></p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:12px;">Sitio web <b><a href="www.aalto.com.ar">aalto.com.ar</a></b></p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:12px;">Correo <b><a href="altodelaspampas@yahoo.com.ar">altodelaspampas@yahoo.com.ar</a></b></p>
            </div>
            <div style="text-align: right; display:inline-block; padding-left:2em; padding-bottom:0.5em;"> 
                <img src="{{ asset('img/estadia.png')}}" alt="estadia" height="100px" width="200px">
            </div>
        </div>
    </div>
</footer>

</html>