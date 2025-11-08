<div class="modal fade" id="editAsigWorkerModal" tabindex="-1" aria-labelledby="editAsigWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAsigWorkerModalLabel">Editar Asignacion de Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/asigworker/editAsigWorkerTurn.php" method="post">
                    <input type="hidden" name="codeturnw" id="codeturnw" value="">

                    <div class="mb-3">
                        <label for="codeworker" class="form-label">Seleccionar Trabajador</label>
                        <select class="form-select" id="codeworker" name="codeworker" onchange="mostrarDetallesTrabajadorEdit()">
                            <option value="">-- Seleccione un trabajador --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="workercodeDisplayedit" class="form-label">Codigo de Trabajador</label>
                        <input type="text" class="form-control" id="workercodeDisplayedit" name="workercodeDisplayedit" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fullnameedit" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="fullnameedit" name="fullnameedit" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="codeturnedit" class="form-label">Seleccionar Turno</label>
                        <select class="form-select" id="codeturnedit" name="codeturnedit" onchange="mostrarDetallesTurnoEdit()">
                            <option value="">-- Seleccione un turno --</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="turnstartedit" class="form-label">Horario de Inicio de Turno</label>
                            <input type="text" class="form-control" id="turnstartedit" name="turnstartedit" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="turnendedit" class="form-label">Horario de Fin de Turno</label>
                            <input type="text" class="form-control" id="turnendedit" name="turnendedit" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="turnwdeleteedit" class="form-label">Estado</label>
                        <select class="form-select" id="turnwdeleteedit" name="turnwdeleteedit">
                            <option value="0">ACTIVO</option>
                            <option value="1">INACTIVO</option>
                        </select>
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
    async function cargarTrabajadoresEdit() {
        try {
            const response = await fetch('../routes/asigworker/getWorkers.php');
            const trabajadores = await response.json();

            const combobox = document.getElementById('codeworker');
            combobox.innerHTML = '<option value="">-- Seleccione un trabajador --</option>';

            trabajadores.forEach(trabajador => {
                const option = document.createElement('option');
                option.value = trabajador.codeworker;
                option.setAttribute('data-fullnameedit', trabajador.fullname);
                option.setAttribute('data-workercodeDisplayedit', trabajador.workercode);
                option.textContent = `${trabajador.workercode} - ${trabajador.fullname}`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar trabajadores:', error);
        }
    }

    function mostrarDetallesTrabajadorEdit() {
        const combobox = document.getElementById('codeworker');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('fullnameedit').value = selectedOption.getAttribute('data-fullnameedit');
        document.getElementById('workercodeDisplayedit').value = selectedOption.getAttribute('data-workercodeDisplayedit');
    }

    async function cargarTurnosEdit() {
        try {
            const response = await fetch('../routes/asigworker/getTurn.php');
            const turnos = await response.json();

            const combobox = document.getElementById('codeturnedit');
            combobox.innerHTML = '<option value="">-- Seleccione un turno --</option>';

            turnos.forEach(turno => {
                const option = document.createElement('option');
                option.value = turno.codeturn;
                option.setAttribute('data-turnstartedit', turno.turnstart);
                option.setAttribute('data-turnendedit', turno.turnend);
                option.textContent = `${turno.turnname} ${turno.turnstart} - ${turno.turnend}`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los turnos:', error);
        }
    }

    function mostrarDetallesTurnoEdit() {
        const combobox = document.getElementById('codeturnedit');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('turnstartedit').value = selectedOption.getAttribute('data-turnstartedit');
        document.getElementById('turnendedit').value = selectedOption.getAttribute('data-turnendedit');
    }

    document.getElementById('editAsigWorkerModal').addEventListener('show.bs.modal', async (event) => {
        const button = event.relatedTarget;
        const codeturnw = button.getAttribute('data-bs-id');
    
        await cargarTrabajadoresEdit();
        await cargarTurnosEdit();
    
        const url = '../routes/asigworker/getTurnwModal.php';
        const formData = new FormData();
        formData.append('codeturnw', codeturnw);
    
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
    
        const data = await response.json();
    
        document.getElementById('codeturnw').value = codeturnw;
        document.getElementById('codeworker').value = data.codeworker;
        document.getElementById('codeturnedit').value = data.codeturn;
        document.getElementById('turnwdeleteedit').value = data.turnwdelete;
    
        mostrarDetallesTrabajadorEdit();
        mostrarDetallesTurnoEdit();
    
        const trabajadorSeleccionado = document.querySelector(`#codeworker option[value="${data.codeworker}"]`);
        if (trabajadorSeleccionado) {
            document.getElementById('fullnameedit').value = trabajadorSeleccionado.getAttribute('data-fullnameedit');
            document.getElementById('workercodeDisplay').value = trabajadorSeleccionado.getAttribute('data-workercode');
        }
    
        const turnoSeleccionado = document.querySelector(`#codeturnedit option[value="${data.codeturn}"]`);
        if (turnoSeleccionado) {
            document.getElementById('turnstartedit').value = turnoSeleccionado.getAttribute('data-turnstartedit');
            document.getElementById('turnendedit').value = turnoSeleccionado.getAttribute('data-turnendedit');
        }
    });

    document.getElementById('editAsigWorkerModal').addEventListener('hidden.bs.modal', () => {
        document.getElementById('codeturnw').value = '';
        document.getElementById('codeworker').value = '';
        document.getElementById('codeturnedit').value = '';
        document.getElementById('turnwdeleteedit').value = '0';
        document.getElementById('fullnameedit').value = '';
        document.getElementById('workercodeDisplayedit').value = '';
        document.getElementById('turnstartedit').value = '';
        document.getElementById('turnendedit').value = '';
    });
    
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById("turndelete");
        const statusLabel = document.getElementById("statusLabel");
        
        function updateStatusLabel() {
            statusLabel.textContent = checkbox.checked ? "INACTIVO" : "ACTIVO";
        }

        checkbox.addEventListener("change", updateStatusLabel);

        updateStatusLabel();
    });
</script>