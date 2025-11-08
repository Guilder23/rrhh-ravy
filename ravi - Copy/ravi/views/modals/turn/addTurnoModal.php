<!-- Modal -->
<div class="modal fade" id="addTurnoModal" tabindex="-1" aria-labelledby="addTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTurnoModalLabel">Agregar Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/turn/addTurn.php" method="post" enctype="multipart/form-data">

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