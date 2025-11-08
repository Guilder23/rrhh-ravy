<div class="modal fade" id="editOccupationModal" tabindex="-1" aria-labelledby="editOccupationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editOccupationModalLabel">Editar registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">            
                <form action="routes/ocupation/editOcupation.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="codeoccupation" id="codeoccupation">

                    <div class="mb-3">
                        <label for="nameoccupation" class="form-label">Nombre:</label>
                        <input type="text" name="nameoccupation" id="nameoccupation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="occupationdelete" class="form-label">Estado</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="occupationdelete" id="occupationdelete" class="form-check-input" value="1">
                            <label class="form-check-label" for="occupationdelete" id="statusLabel">ACTIVO</label>
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar
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
        const checkbox = document.getElementById("occupationdelete");
        const statusLabel = document.getElementById("statusLabel");

        function updateStatusLabel() {
            statusLabel.textContent = checkbox.checked ? "INACTIVO" : "ACTIVO";
        }

        checkbox.addEventListener("change", updateStatusLabel);

        updateStatusLabel();
    });
</script>
