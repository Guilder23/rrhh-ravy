<div class="modal fade" id="editTurnoModal" tabindex="-1" aria-labelledby="editTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTurnoModalLabel">Editar Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/turn/editTurn.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codeturn" id="codeturn">

                    <div class="mb-3">
                        <label for="turnname" class="form-label">Nombre del Turno:</label>
                        <input type="text" name="turnname" id="turnname" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnstart" class="form-label">Hora de Inicio:</label>
                        <input type="time" name="turnstart" id="turnstart" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnend" class="form-label">Hora de Fin:</label>
                        <input type="time" name="turnend" id="turnend" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="turndelete" class="form-label">Estado:</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="turndelete" id="turndelete" class="form-check-input" value="1">
                            <label class="form-check-label" for="turndelete" id="statusLabel">ACTIVO</label>
                        </div>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById("turndelete");
        const statusLabel = document.getElementById("statusLabel");
        
        function updateStatusLabel() {
            statusLabel.textContent = checkbox.checked ? "ACTIVO" : "INACTIVO";
        }

        checkbox.addEventListener("change", updateStatusLabel);

        updateStatusLabel();
    });
</script>