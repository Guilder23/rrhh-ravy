<link rel="stylesheet" href="../assets/css/styleRecursive.css">


<div class="modal fade" id="addTurn" tabindex="-1" aria-labelledby="addTurnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTurnModalLabel">Registrar Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/turns/createTurn.php" method="post">
                    
             <section class="separar">   
                <div class="mitad">
                    <div class="mb-3">
                        <label for="codeworker" class="form-label">Código del Trabajador</label>
                        <input type="number" class="form-control" id="codeworker" name="codeworker" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnarea" class="form-label">Área del Turno</label>
                        <input type="text" class="form-control" id="turnarea" name="turnarea" required>
                    </div>

                    <div class="mb-3">
                        <label for="turncode" class="form-label">Código del Turno</label>
                        <input type="text" class="form-control" id="turncode" name="turncode" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnname" class="form-label">Nombre del Trabajador</label>
                        <input type="text" class="form-control" id="turnname" name="turnname" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnlastname" class="form-label">Apellido del Trabajador</label>
                        <input type="text" class="form-control" id="turnlastname" name="turnlastname" required>
                    </div>
                </div>
                <div class="mitad">
                    <div class="mb-3">
                        <label for="turnassigned" class="form-label">Turno Asignado</label>
                        <input type="text" class="form-control" id="turnassigned" name="turnassigned" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnrange" class="form-label">Rango de Turno</label>
                        <input type="text" class="form-control" id="turnrange" name="turnrange" required>
                    </div>

                    <div class="mb-3">
                        <label for="turninit" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="turninit" name="turninit" required>
                    </div>

                    <div class="mb-3">
                        <label for="turnend" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="turnend" name="turnend" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar Turno</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div><!--Fin mitad-->
                </section>
                </form>
            </div>
        </div>
    </div>
</div>

