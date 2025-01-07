if (!reservas) {
    var reservas = {};
}

reservas = {
    FechaChange: function () {
        var val = $(this).val(),
            $that = $(this),
            fecha_desde = $("#fecha_desde").val(),
            id_cabania = $("#id_cabania").val(),
            fecha_hasta = $("#fecha_hasta").val(),
            descuento_porce = $(".descuento_porce").val(),
            descuento = $(".descuento").val(),
            total_fecha = 0,
            data = {
                fecha_desde: fecha_desde,
                fecha_hasta: fecha_hasta,
                id_cabania: id_cabania,
            },
            url = $that.data("url");

        if (
            val !== "" &&
            fecha_desde !== "" &&
            fecha_hasta !== "" &&
            id_cabania !== ""
        ) {
            $.ajax({
                method: "GET",
                data: data,
                url: url + "/" + val,
            })
                .done(function (res) {
                    total_fecha = res.data;
                    total_fecha = total_fecha.toFixed(2);
                    $("#importe_reserva").val(total_fecha);
                    if (descuento > 0) {
                        reservas.UpdateDescuento();
                    } else {
                        if (descuento_porce > 0) {
                            reservas.UpdatePorce();
                        } else {
                            $("#descuento").val(0);
                            $("#descuento_porce").val(0);
                            $("#total").val(total_fecha);
                        }
                    }

                    reservas.UpdateDeuda();
                    //  total_fecha =  res.data;
                })
                .error(function (res) {
                    console.log(res);
                });
        }
    },

    UpdatePorce: function () {
        var importe_reserva = $("#importe_reserva").val(),
            descuento_porce = $(".descuento_porce").val(),
            descuento = 0;

        if (descuento_porce > 0) {
            descuento = (parseFloat(importe_reserva) / 100) * descuento_porce;
            descuento = descuento.toFixed(2);

            $("#descuento").val(descuento);
        }

        total = importe_reserva - descuento;
        total = total.toFixed(2);
        $("#total").val(total);
        reservas.UpdateDeuda();
    },

    UpdateDescuento: function () {
        var importe_reserva = $("#importe_reserva").val(),
            descuento = $(".descuento").val(),
            descuento_porce = 0;

        if (descuento > 0) {
            descuento_porce = (100 * descuento) / parseFloat(importe_reserva);
            descuento_porce = descuento_porce.toFixed(2);

            $("#descuento_porce").val(descuento_porce);
        }

        total = importe_reserva - descuento;
        total = total.toFixed(2);
        $("#total").val(total);
        reservas.UpdateDeuda();
    },

    UpdateRecargo: function () {
        var total = $("#total").val(),
            recargo = $(".recargo").val(),
            recargo_porce = 0;

        if (recargo > 0) {
            recargo_porce = (100 * recargo) / parseFloat(total);
            recargo_porce = recargo_porce.toFixed(2);

            $("#recargo_porce").val(recargo_porce);
        }

        reservas.UpdateDeuda();
    },

    UpdateRecargoPorce: function () {
        var total = $("#total").val(),
            recargo_porce = $(".recargo_porce").val(),
            recargo = 0;

        if (recargo_porce > 0) {
            recargo = (parseFloat(total) / 100) * recargo_porce;
            recargo = recargo.toFixed(2);

            $("#recargo").val(recargo);
        }
        reservas.UpdateDeuda();
    },

    UpdateDeuda: function () {
        var total = $("#total").val(),
            senia = $(".senia").val(),
            recargo = $(".recargo").val(),
            total_deuda = 0;

        if (parseFloat(total) > 0) {
            total_deuda =
                parseFloat(total) + parseFloat(recargo) - parseFloat(senia);
            total_deuda = total_deuda.toFixed(2);
        }
        $("#total_deuda").val(total_deuda);
    },

    init: function () {
        $("#fecha_desde, #fecha_hasta, #id_cabania").on(
            "change",
            this.FechaChange
        );
        $(".descuento_porce").on("input", this.UpdatePorce);
        $(".descuento").on("input", this.UpdateDescuento);
        $(".recargo_porce").on("input", this.UpdateRecargoPorce);
        $(".recargo").on("input", this.UpdateRecargo);
        // $(".senia").on('change', this.UpdateDeuda);
        $(".senia").on("input", this.UpdateDeuda); 
    },
};

$(function () {
    "use strict";
    reservas.init();
});
