<div class="modal fade" id="addAsigTurn" tabindex="-1" aria-labelledby="addAsigTurnLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAsigTurnLabel">Asignar Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/turn/addTurnWorker1.php" method="post" enctype="multipart/form-data">
                    
                    <input type="hidden" name="codeworkerasig" id="codeworkerasig" value="">

                    <input type="hidden" name="turnwname" id="turnwname" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="turnwlastname" id="turnwlastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="mb-3">
                        <label for="workercodeDisplay" class="form-label">Código de Trabajador</label>
                        <input type="text" class="form-control" id="workercodeDisplay" name="workercodeDisplay" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="codeturn" class="form-label">Seleccionar Turno</label>
                        <select class="form-select" id="codeturn" name="codeturn" onchange="mostrarDetallesTurno()">
                            <option value="">-- Seleccione un turno --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="turnstartasig" class="form-label">Horario de Inicio de Turno</label>
                            <input type="text" class="form-control" id="turnstartasig" name="turnstartasig" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="turnendasig" class="form-label">Horario de Fin de Turno</label>
                            <input type="text" class="form-control" id="turnendasig" name="turnendasig" disabled>
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
async function cargarTurnos() {
    try {
        const response = await fetch('../routes/asigworker/getTurn.php');
        const turnos = await response.json();

        const combobox = document.getElementById('codeturn');

        combobox.innerHTML = '<option value="">-- Seleccione un turno --</option>';

        turnos.forEach(turno => {
            const option = document.createElement('option');
            option.value = turno.codeturn;
            option.setAttribute('data-turnstartasig', turno.turnstart);
            option.setAttribute('data-turnendasig', turno.turnend);
            option.textContent = `${turno.turnname} ${turno.turnstart} - ${turno.turnend}`;
            combobox.appendChild(option);
        });
    } catch (error) {
        console.error('Error al cargar los turnos:', error);
    }
}

function mostrarDetallesTurno() {
    const combobox = document.getElementById('codeturn');
    const selectedOption = combobox.options[combobox.selectedIndex];

    document.getElementById('turnstartasig').value = selectedOption.getAttribute('data-turnstartasig');
    document.getElementById('turnendasig').value = selectedOption.getAttribute('data-turnendasig');
}    

</script>