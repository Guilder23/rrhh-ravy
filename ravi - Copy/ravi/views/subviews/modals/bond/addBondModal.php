<!-- Modal -->
<div class="modal fade" id="addBondModal" tabindex="-1" aria-labelledby="addBondModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addBondModalLabel">Agregar Bono</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/bond/addBond.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codebond" value="">

                    <div class="mb-3">
                        <label for="bondcode" class="form-label">Código del Bono:</label>
                        <input type="text" name="bondcode" id="bondcode" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="bondreason" class="form-label">Razón del Bono:</label>
                        <input type="text" name="bondreason" id="bondreason" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="bondvalue" class="form-label">Valor del Bono:</label>
                        <input type="number" name="bondvalue" id="bondvalue" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="bondnro" class="form-label">Número del Bono:</label>
                        <input type="text" name="bondnro" id="bondnro" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="bondfee" class="form-label">Tarifa del Bono:</label>
                        <input type="number" name="bondfee" id="bondfee" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>