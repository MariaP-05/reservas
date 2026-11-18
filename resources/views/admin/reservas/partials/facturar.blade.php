<div class="modal fade" id="FacturarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <form>
                        <div class="row">
                            <div class=" col-6 form-group">
                                <label for="cabania" class="col-form-label">Cabaña</label>
                                <input type="text" class="form-control cabania" id="cabania" disabled>
                            </div>
                            <div class=" col-6 form-group">
                                <label for="moneda" class="col-form-label">Moneda</label>
                                <input type="text" class="form-control moneda" id="moneda" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="valor" class="col-form-label">Valor</label>
                                <input type="text" class="form-control valor" id="valor" disabled>
                            </div>
                            <div class="col-6 form-group">
                                <label for="senia" class="col-form-label">Seña</label>
                                <input type="text" class="form-control senia" id="senia" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-6 form-group">
                            <form method="get"
                                action="{{ route('admin.reservas.create_factura', ['id' => $reserva->id, 'id_prestador' => 1]) }}">

                                <button type="submit" class="btn btn-outline-primary"
                                    title="Crear Factura de Guadalupe">
                                    <i class="fa fa-barcode"> Guadalupe</i>
                                </button>
                            </form>
                        </div>

                        <div class="col-6 form-group">
                            <form method="get"
                                action="{{ route('admin.reservas.create_factura', ['id' => $reserva->id, 'id_prestador' => 2]) }}">

                                <button type="submit" class="btn btn-outline-success" title="Crear Factura de Rodrigo">
                                    <i class="fa fa-barcode"> Rodrigo</i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
