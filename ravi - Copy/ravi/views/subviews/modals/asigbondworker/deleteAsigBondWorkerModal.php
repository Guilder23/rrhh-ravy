<div class="modal fade" id="deleteAsigBondWorkerModal" tabindex="-1" aria-labelledby="deleteAsigBondWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteAsigBondWorkerModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Desea eliminar el registro?
            </div>
            <div class="modal-footer">
                <form action="routes/bondworker/deleteAsigWorkerBond.php" method="post">
                    <input type="hidden" name="codebondw" id="codebondw">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>