<div class="modal fade" id="editAsigBondTurnModal" tabindex="-1" aria-labelledby="editAsigBondTurnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAsigBondTurnModalLabel">Editar Asignación de Bono a Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/bondturn/editAsigTurnBond.php" method="post">
                    <input type="hidden" name="codebondt" id="codebondt" value="">

                    <div class="mb-3">
                        <label for="codeturn" class="form-label">Seleccionar Turno</label>
                        <select class="form-select" id="codeturn" name="codeturn" onchange="mostrarDetallesTurnoEdit()">
                            <option value="">-- Seleccione un turno --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="turnnameDisplayedit" class="form-label">Nombre del Turno</label>
                        <input type="text" class="form-control" id="turnnameDisplayedit" name="turnnameDisplayedit" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="turnscheduleedit" class="form-label">Horario</label>
                        <input type="text" class="form-control" id="turnscheduleedit" name="turnscheduleedit" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="codebondedit" class="form-label">Seleccionar Bono</label>
                        <select class="form-select" id="codebondedit" name="codebondedit" onchange="mostrarDetallesBonoEdit()">
                            <option value="">-- Seleccione un bono --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bondreasonedit" class="form-label">Razón del Bono</label>
                        <input type="text" class="form-control" id="bondreasonedit" name="bondreasonedit" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="bondvalueedit" class="form-label">Valor del Bono</label>
                        <input type="text" class="form-control" id="bondvalueedit" name="bondvalueedit" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="bondtdeleteedit" class="form-label">Estado</label>
                        <select class="form-select" id="bondtdeleteedit" name="bondtdeleteedit">
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
    async function cargarTurnosEdit() {
        try {
            const response = await fetch('../routes/bondturn/getTurn.php');
            const data = await response.json();
            
            const turnos = data.data;
            const combobox = document.getElementById('codeturn');
            combobox.innerHTML = '<option value="">-- Seleccione un turno --</option>';

            turnos.forEach(turno => {
                const option = document.createElement('option');
                option.value = turno.codeturn;
                option.setAttribute('data-turnnameDisplayedit', turno.turnname);
                option.setAttribute('data-turnstart', turno.turnstart);
                option.setAttribute('data-turnend', turno.turnend);
                option.textContent = `${turno.turnname} (${turno.turnstart} - ${turno.turnend})`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar turnos:', error);
        }
    }

    function mostrarDetallesTurnoEdit() {
        const combobox = document.getElementById('codeturn');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('turnnameDisplayedit').value = selectedOption.getAttribute('data-turnnameDisplayedit');
        document.getElementById('turnscheduleedit').value = `${selectedOption.getAttribute('data-turnstart')} - ${selectedOption.getAttribute('data-turnend')}`;
    }

    async function cargarBonosEdit() {
        try {
            const response = await fetch('../routes/bondturn/getBondtModal.php');
            const data = await response.json();
            
            const bonos = data.data;

            const combobox = document.getElementById('codebondedit');
            combobox.innerHTML = '<option value="">-- Seleccione un bono --</option>';

            bonos.forEach(bono => {
                const option = document.createElement('option');
                option.value = bono.codebond;
                option.setAttribute('data-bondreasonedit', bono.bondreason);
                option.setAttribute('data-bondvalueedit', bono.bondvalue);
                option.textContent = `${bono.bondcode} - ${bono.bondreason}`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los bonos:', error);
        }
    }

    function mostrarDetallesBonoEdit() {
        const combobox = document.getElementById('codebondedit');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('bondreasonedit').value = selectedOption.getAttribute('data-bondreasonedit');
        document.getElementById('bondvalueedit').value = selectedOption.getAttribute('data-bondvalueedit');
    }

    document.getElementById('editAsigBondTurnModal').addEventListener('show.bs.modal', async (event) => {
        const button = event.relatedTarget;
        const codebondt = button.getAttribute('data-bs-id');

        await cargarTurnosEdit();
        await cargarBonosEdit();

        const url = '../routes/bondturn/getBondtModal.php';
        const formData = new FormData();
        formData.append('codebondt', codebondt);

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        document.getElementById('codebondt').value = codebondt;
        document.getElementById('codeturn').value = data.codeturn;
        document.getElementById('codebondedit').value = data.codebond;
        document.getElementById('bondtdeleteedit').value = data.bondtdelete;

        mostrarDetallesTurnoEdit();
        mostrarDetallesBonoEdit();

        const turnoSeleccionado = document.querySelector(`#codeturn option[value="${data.codeturn}"]`);
        if (turnoSeleccionado) {
            document.getElementById('turnnameDisplayedit').value = turnoSeleccionado.getAttribute('data-turnnameDisplayedit');
            document.getElementById('turnscheduleedit').value = 
                `${turnoSeleccionado.getAttribute('data-turnstart')} - ${turnoSeleccionado.getAttribute('data-turnend')}`;
        }

        const bonoSeleccionado = document.querySelector(`#codebondedit option[value="${data.codebond}"]`);
        if (bonoSeleccionado) {
            document.getElementById('bondreasonedit').value = bonoSeleccionado.getAttribute('data-bondreasonedit');
            document.getElementById('bondvalueedit').value = bonoSeleccionado.getAttribute('data-bondvalueedit');
        }
    });

    document.getElementById('editAsigBondTurnModal').addEventListener('hidden.bs.modal', () => {
        document.getElementById('codebondt').value = '';
        document.getElementById('codeturn').value = '';
        document.getElementById('codebondedit').value = '';
        document.getElementById('bondtdeleteedit').value = '0';
        document.getElementById('turnnameDisplayedit').value = '';
        document.getElementById('turnscheduleedit').value = '';
        document.getElementById('bondreasonedit').value = '';
        document.getElementById('bondvalueedit').value = '';
    });
</script>