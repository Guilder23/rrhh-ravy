<!-- Modal -->
<div class="modal fade" id="editBondModal" tabindex="-1" aria-labelledby="editBondModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editBondModalLabel">Editar Bono</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/bond/editBond.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codebond" id="codebond">

                    <!-- Campo para el código del bono -->
                    <div class="mb-3">
                        <label for="bondcode" class="form-label">Código del Bono:</label>
                        <input type="text" name="bondcode" id="bondcode" class="form-control" required>
                    </div>

                    <!-- Campo para la razón del bono -->
                    <div class="mb-3">
                        <label for="bondreason" class="form-label">Razón del Bono:</label>
                        <input type="text" name="bondreason" id="bondreason" class="form-control" required>
                    </div>

                    <!-- Campo para el valor del bono -->
                    <div class="mb-3">
                        <label for="bondvalue" class="form-label">Valor del Bono:</label>
                        <input type="number" name="bondvalue" id="bondvalue" class="form-control" step="0.01" required>
                    </div>

                    <!-- Campo para el número del bono -->
                    <div class="mb-3">
                        <label for="bondnro" class="form-label">Número del Bono:</label>
                        <input type="text" name="bondnro" id="bondnro" class="form-control" required>
                    </div>

                    <!-- Campo para la tarifa del bono -->
                    <div class="mb-3">
                        <label for="bondfee" class="form-label">Tarifa del Bono:</label>
                        <input type="number" name="bondfee" id="bondfee" class="form-control" step="0.01" required>
                    </div>

                    <!-- Campo para el estado del bono -->
                    <div class="mb-3">
                        <label for="bondelete" class="form-label">Estado:</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="bondelete" id="bondelete" class="form-check-input" value="1">
                            <label class="form-check-label" for="bondelete" id="statusLabel">ACTIVO</label>
                        </div>
                    </div>

                    <!-- Botones del formulario -->
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
        const checkbox = document.getElementById("bondelete");
        const statusLabel = document.getElementById("statusLabel");

        function updateStatusLabel() {
            statusLabel.textContent = checkbox.checked ? "INACTIVO" : "ACTIVO";
        }
        
        checkbox.addEventListener("change", updateStatusLabel);

        updateStatusLabel();
    });
</script>