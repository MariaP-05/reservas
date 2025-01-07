if (!reservas) {
  var reservas = {};
}

reservas = {

  FechaChange: function () {
    var val = $(this).val(),
        $that = $(this),
        fecha_desde = $('#fecha_desde').val(),
        id_cabania = $('#id_cabania').val(),
        fecha_hasta = $('#fecha_hasta').val(),

        data = {fecha_desde: fecha_desde, fecha_hasta: fecha_hasta , id_cabania: id_cabania},       
        url = $that.data('url');

    if (val !== '') {
        $.ajax({
            method: 'GET',
            data: data,
            url: url + '/' + val
        }).done(function (res) {
          $('#importe_reserva').val(res.data);           
         //   $('.dest-data').show();
            
        }).error(function (res) {
            console.log(res);
        });
       
    } else {
      //  $('.dest-data').hide();
    }
},

UpdatePorce: function () {
  var     importe_reserva =   fecha_desde = $('#importe_reserva').val(),          
          descuento_porce = $(".descuento_porce").val(),
          descuento = 0;
        
  if(descuento_porce > 0)
  {
      descuento = (parseFloat(importe_reserva)   ) /100 * descuento_porce;
      descuento = (descuento).toFixed(2);

      $('#descuento').val(descuento);
     
  }       
  total = importe_reserva - descuento;
  total = (total).toFixed(2);
  $('#total').val(total);
},

UpdateDescuento: function () {
  var     importe_reserva =   fecha_desde = $('#importe_reserva').val(),   
          descuento = $(".descuento").val(),
          descuento_porce = 0;
        
  if(descuento > 0)
  {
      descuento_porce = 100 * descuento /(parseFloat(importe_reserva)  ) ;
      descuento_porce = (descuento_porce).toFixed(2);

      $('#descuento_porce').val(descuento_porce);
     
  }     
  total = importe_reserva - descuento;
  total = (total).toFixed(2);
  $('#total').val(total);  
},

UpdateDeuda: function () {
  var     total = $(".total").val(),
          senia = $(".senia").val(),
          total_deuda = 0;
        
  if(total > 0)
  {
    total_deuda = total - senia;
    total_deuda = (total_deuda).toFixed(2);   
     
  }     
  $('#total_deuda').val(total_deuda);
},

  init: function () {
    $("#fecha_desde, #fecha_hasta").on('change', this.FechaChange);
    $(".descuento_porce").on('input', this.UpdatePorce);
    $(".descuento").on('input', this.UpdateDescuento);
   // $(".senia").on('change', this.UpdateDeuda);
    $(".senia").on('input', this.UpdateDeuda);
  },
};

$(function () {
  "use strict";
  reservas.init();
});
