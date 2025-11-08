<div class="modal fade" id="addAsigTurnWorkerModal" tabindex="-1" aria-labelledby="addAsigTurnWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAsigTurnWorkerModalLabel">Asignar Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/asigworker/addAsigWorkerTurn.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codeturnw" id="codeturnw" value="">

                    <input type="hidden" name="turnwname" id="turnwname" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="turnwlastname" id="turnwlastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">
                    
                    
                    <div class="separar">
                    <div class="mitad">
                        <div class="mb-3">
                            <label for="workercode" class="form-label">Seleccionar Trabajador</label>
                            <select class="form-select" id="workercode" name="workercode" onchange="mostrarDetallesTrabajador()">
                                <option value="">-- Seleccione un trabajador --</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="workercodeDisplay" class="form-label">Código de Trabajador</label>
                            <input type="text" class="form-control" id="workercodeDisplay" name="workercodeDisplay" disabled>
                        </div>
    
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" disabled>
                        </div>
                    </div>

                    <div class="mitad">
                        <div class="mb-3">
                            <label for="codeturn" class="form-label">Seleccionar Turno</label>
                            <select class="form-select" id="codeturn" name="codeturn" onchange="mostrarDetallesTurno()">
                                <option value="">-- Seleccione un turno --</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="turnstart" class="form-label">Horario de Inicio de Turno</label>
                                <input type="text" class="form-control" id="turnstart" name="turnstart" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="turnend" class="form-label">Horario de Fin de Turno</label>
                                <input type="text" class="form-control" id="turnend" name="turnend" disabled>
                            </div>
                        </div>
                    </div>
                     </div><!--fin separador-->

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
    async function cargarTrabajadores() {
        try {
            const response = await fetch('../routes/asigworker/getWorkers.php');
            const trabajadores = await response.json();

            const combobox = document.getElementById('workercode');

            combobox.innerHTML = '<option value="">-- Seleccione un trabajador --</option>';

            trabajadores.forEach(trabajador => {
                const option = document.createElement('option');
                option.value = trabajador.codeworker;
                option.setAttribute('data-fullname', trabajador.fullname);
                option.setAttribute('data-workercodeDisplay', trabajador.workercode);
                option.textContent = `${trabajador.workercode} - ${trabajador.fullname}`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar trabajadores:', error);
        }
    }
    
    function mostrarDetallesTrabajador() {
        const combobox = document.getElementById('workercode');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('fullname').value = selectedOption.getAttribute('data-fullname');
        document.getElementById('workercodeDisplay').value = selectedOption.getAttribute('data-workercodeDisplay');
    }

    async function cargarTurnos() {
        try {
            const response = await fetch('../routes/asigworker/getTurn.php');
            const turnos = await response.json();

            const combobox = document.getElementById('codeturn');

            combobox.innerHTML = '<option value="">-- Seleccione un turno --</option>';

            turnos.forEach(turno => {
                const option = document.createElement('option');
                option.value = turno.codeturn;
                option.setAttribute('data-turnstart', turno.turnstart);
                option.setAttribute('data-turnend', turno.turnend);
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

        document.getElementById('turnstart').value = selectedOption.getAttribute('data-turnstart');
        document.getElementById('turnend').value = selectedOption.getAttribute('data-turnend');
    }

    document.getElementById('addAsigTurnWorkerModal').addEventListener('shown.bs.modal', () => {
        cargarTrabajadores();
        cargarTurnos();
    });
</script>