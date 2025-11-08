<div class="modal fade" id="editAsigAreaModal" tabindex="-1" aria-labelledby="editAsigAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAsigAreaModalLabel">Editar Asignación de Turno a Área</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/area/editAsigAreaTurn.php" method="post">
                    <input type="hidden" name="codeturna" id="codeturna" value="">

                    <div class="mb-3">
                        <label for="codearea" class="form-label">Seleccionar Área</label>
                        <select class="form-select" id="codearea" name="codearea" onchange="mostrarDetallesAreaEdit()">
                            <option value="">-- Seleccione un área --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="areanameDisplayedit" class="form-label">Nombre del Área</label>
                        <input type="text" class="form-control" id="areanameDisplayedit" name="areanameDisplayedit" disabled>
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
                        <label for="turnadeleteedit" class="form-label">Estado</label>
                        <select class="form-select" id="turnadeleteedit" name="turnadeleteedit">
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
    async function cargarAreasEdit() {
        try {
            const response = await fetch('../routes/asigarea/getArea.php');
            const areas = await response.json();

            const combobox = document.getElementById('codearea');
            combobox.innerHTML = '<option value="">-- Seleccione un área --</option>';

            areas.forEach(area => {
                const option = document.createElement('option');
                option.value = area.codearea;
                option.setAttribute('data-areanameedit', area.areaname);
                option.textContent = `${area.codearea} - ${area.areaname}`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar áreas:', error);
        }
    }

    function mostrarDetallesAreaEdit() {
        const combobox = document.getElementById('codearea');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('areanameDisplayedit').value = selectedOption.getAttribute('data-areanameedit');
    }

    async function cargarTurnosEdit() {
        try {
            const response = await fetch('../routes/asigarea/getTurn.php');
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

    document.getElementById('editAsigAreaModal').addEventListener('show.bs.modal', async (event) => {
        const button = event.relatedTarget;
        const codeturna = button.getAttribute('data-bs-id');
    
        await cargarAreasEdit();
        await cargarTurnosEdit();
    
        const url = '../routes/asigarea/getTurnaModal.php';
        const formData = new FormData();
        formData.append('codeturna', codeturna);
    
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
    
        const data = await response.json();
    
        document.getElementById('codeturna').value = codeturna;
        document.getElementById('codearea').value = data.codearea;
        document.getElementById('codeturnedit').value = data.codeturn;
        document.getElementById('turnadeleteedit').value = data.turnadelete;
    
        mostrarDetallesAreaEdit();
        mostrarDetallesTurnoEdit();
    
        const areaSeleccionada = document.querySelector(`#codearea option[value="${data.codearea}"]`);
        if (areaSeleccionada) {
            document.getElementById('areanameDisplayedit').value = areaSeleccionada.getAttribute('data-areanameedit');
        }
    
        const turnoSeleccionado = document.querySelector(`#codeturnedit option[value="${data.codeturn}"]`);
        if (turnoSeleccionado) {
            document.getElementById('turnstartedit').value = turnoSeleccionado.getAttribute('data-turnstartedit');
            document.getElementById('turnendedit').value = turnoSeleccionado.getAttribute('data-turnendedit');
        }
    });

    document.getElementById('editAsigAreaModal').addEventListener('hidden.bs.modal', () => {
        document.getElementById('codeturna').value = '';
        document.getElementById('codearea').value = '';
        document.getElementById('codeturnedit').value = '';
        document.getElementById('turnadeleteedit').value = '0';
        document.getElementById('areanameDisplayedit').value = '';
        document.getElementById('turnstartedit').value = '';
        document.getElementById('turnendedit').value = '';
    });
</script>