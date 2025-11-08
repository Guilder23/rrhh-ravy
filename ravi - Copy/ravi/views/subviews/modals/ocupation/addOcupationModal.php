<div class="modal fade" id="addOcupationModal" tabindex="-1" aria-labelledby="addOcupationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addOcupationModalLabel">Agregar Ocupación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/ocupation/addocupation.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codeocupation" value="">

                    <div class="mb-3">
                        <label for="nameoccupation" class="form-label">Nombre de la Ocupación:</label>
                        <input type="text" name="nameoccupation" id="nameoccupation" class="form-control" required>
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