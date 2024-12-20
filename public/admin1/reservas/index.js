
  $(document).ready(function () {
    $('#reservas').DataTable({
        "language": {
            "search":   "Buscar",
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
          


        }
        , order: [[ 0, 'desc' ]]
     }
     
     );


});