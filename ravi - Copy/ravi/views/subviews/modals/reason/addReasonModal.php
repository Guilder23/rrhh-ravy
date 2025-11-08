<div class="modal fade" id="addReasonModal" tabindex="-1" aria-labelledby="addReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addReasonModalLabel">Agregar una Razon o Motivo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/reason/addReason.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codereason" value="">

                    <div class="mb-3">
                        <label for="reasonname" class="form-label">Motivo o Razon:</label>
                        <input type="text" name="reasonname" id="reasonaname" class="form-control" required>
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