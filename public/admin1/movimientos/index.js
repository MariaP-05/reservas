$(document).ready(function() {

    $('.select2').select2();
  
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
  
    $.datepicker.setDefaults($.datepicker.regional['es']);
  
    $("#fec_desde").datepicker({
        todayBtn: "linked",
        language: 'es',
        autoclose: true,
        todayHighlight: true,
        dateFormat: 'dd-mm-yy'
    });

    $("#fec_hasta").datepicker({
        todayBtn: "linked",
        language: 'es',
        autoclose: true,
        todayHighlight: true,
        dateFormat: 'dd-mm-yy'
    });
    
    $('#movimientos').DataTable({
            "language": {
                "search": "Buscar",
                "lengthMenu": "Movimientos por pagina _MENU_ ",
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