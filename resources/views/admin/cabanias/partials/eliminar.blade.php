<div class="modal fade" id="EliminarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row col-sm-12">
                    <div class="col-sm-9" style="text-align: right">
                        <form method="post" action="{{ route('admin.cabanias.destroy', $cabania->id) }}">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger" title="Eliminar Cabaña">
                                Sí
                            </button>
                        </form>
                    </div>
                        <div class="col-sm-3" style="text-align: left">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


 
