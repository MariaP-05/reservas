  
  $('#VerModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Vizualizando reserva ' + recipient.id)
    modal.find('.cabania').val(recipient.deno_cabania)
    modal.find('.cliente').val(recipient.nom_cliente)
    modal.find('.forma_pago').val(recipient.deno_pago)
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

  $(document).ready(function() {
    $('#reservas').DataTable({
            "language": {
                "search": "Buscar",
                "lengthMenu": "Reservas por pagina _MENU_ ",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "infoPostFix": "",
                "url": "",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                }



           
    },
   
   responsive: true,
   autowith:false ,
   order: [[ 0, 'desc' ]]
        }

    );


});