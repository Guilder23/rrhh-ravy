<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="editSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editSectionModalLabel">Editar registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">            
                <form action="routes/section/editSection.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="codesection" id="codesection">

                    <div class="mb-3">
                        <label for="namesection" class="form-label">Nombre:</label>
                        <input type="text" name="namesection" id="namesection" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="sectiondelete" class="form-label">Estado</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="sectiondelete" id="sectiondelete" class="form-check-input" value="1">
                            <label class="form-check-label" for="sectiondelete" id="statusLabel">ACTIVO</label>
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
        const checkbox = document.getElementById("sectiondelete");
        const statusLabel = document.getElementById("statusLabel");

        function updateStatusLabel() {
            statusLabel.textContent = checkbox.checked ? "INACTIVO" : "ACTIVO";
        }

        checkbox.addEventListener("change", updateStatusLabel);

        updateStatusLabel();
    });
</script>
