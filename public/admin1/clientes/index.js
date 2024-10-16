$('#VerModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Vizualizando Cliente ' + recipient.denomicacion)
    modal.find('.denominacion').val(recipient.denominacion)
    modal.find('.fecha_nacimiento').val(recipient.fecha_nacimiento)
    modal.find('.cuit').val(recipient.cuit)
    modal.find('.localidad').val(recipient.deno_localidad)
    modal.find('.direccion').val(recipient.direccion)
    modal.find('.telefono').val(recipient.telefono)
    modal.find('.celular').val(recipient.celular)
    modal.find('.mail').val(recipient.mail)
    modal.find('.mail_2').val(recipient.mail_2)
    
    
  });

  $(document).ready(function() {
    $('#clientes').DataTable({
            "language": {
                "search": "Buscar",
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
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
            order: [
                [0, 'desc']
            ]
        }

    );


});