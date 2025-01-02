$('#EliminarModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('¿Desea eliminar a ' + recipient.denominacion + '?' )  

});



$(document).ready(function () {
    
    $('#cabanias').DataTable({
        "language": {
            "search":   "Buscar",
            "lengthMenu": "Cabañas por pagina _MENU_ ",
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
          


        }
        , 
            responsive: true,
            autowith: false,
            order: [
                [0, 'desc']
            ]
     }
     
     );


});