<div class="modal fade" id="addAsigBondWorkerModal" tabindex="-1" aria-labelledby="addAsigBondWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAsigBondWorkerModalLabel">Asignar Bono</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/bondworker/addAsigWorkerBond.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codebondw" id="codebondw" value="">

                    <input type="hidden" name="bondwname" id="bondwname" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="bondwlastname" id="bondwlastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">

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
                                <label for="codebond" class="form-label">Seleccionar Bono</label>
                                <select class="form-select" id="codebond" name="codebond" onchange="mostrarDetallesBono()">
                                    <option value="">-- Seleccione un bono --</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="bondreason" class="form-label">Razón del Bono</label>
                                <input type="text" class="form-control" id="bondreason" name="bondreason" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="bondvalue" class="form-label">Valor del Bono</label>
                                <input type="text" class="form-control" id="bondvalue" name="bondvalue" disabled>
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

    async function cargarBonos() {
        try {
            const response = await fetch('../routes/bondworker/getBondModal.php');
            const bonos = await response.json();

            const combobox = document.getElementById('codebond');

            combobox.innerHTML = '<option value="">-- Seleccione un bono --</option>';

            bonos.forEach(bono => {
                const option = document.createElement('option');
                option.value = bono.codebond;
                option.setAttribute('data-bondreason', bono.bondreason);
                option.setAttribute('data-bondvalue', bono.bondvalue);
                option.textContent = `${bono.bondcode} - ${bono.bondreason}`; <!-- Cambiado bondname por bondcode -->
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los bonos:', error);
        }
    }

    function mostrarDetallesBono() {
        const combobox = document.getElementById('codebond');
        const selectedOption = combobox.options[combobox.selectedIndex];

        document.getElementById('bondreason').value = selectedOption.getAttribute('data-bondreason');
        document.getElementById('bondvalue').value = selectedOption.getAttribute('data-bondvalue');
    }

    document.getElementById('addAsigBondWorkerModal').addEventListener('shown.bs.modal', () => {
        cargarTrabajadores();
        cargarBonos();
    });
</script>