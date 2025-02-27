  
 
 $('#VerModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Vizualizando reserva de: ' + recipient.nom_cliente)
    modal.find('.cabania').val(recipient.deno_cabania)
    modal.find('.cliente').val(recipient.nom_cliente)
    modal.find('.forma_pago').val(recipient.deno_pago)
    modal.find('.ctabancaria').val(recipient.ctabancaria)
    modal.find('.estado_reserva').val(recipient.deno_est_reserva)
    modal.find('.cantidad_personas').val(recipient.cantidad_personas)
    modal.find('.descuento').val(recipient.descuento)
    modal.find('.senia').val(recipient.senia)
    modal.find('.fecha_desde').val(recipient.fecha_desde)
    modal.find('.fecha_hasta').val(recipient.fecha_hasta)
    modal.find('.hora_ingreso').val(recipient.hora_ingreso)
    modal.find('.hora_egreso').val(recipient.hora_egreso)
    modal.find('.observaciones').val(recipient.observaciones)
  });
   