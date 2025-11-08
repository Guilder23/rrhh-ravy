<div class="modal fade" id="editAsigBondWorkerModal" tabindex="-1" aria-labelledby="editAsigBondWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editAsigBondWorkerModalLabel">Editar Asignaci車n de Bono</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../routes/bondworker/editAsigWorkerBond.php" method="post">
                    <input type="hidden" name="codebondw" id="codebondw" value="">
                    <input type="hidden" name="codebondt" id="codebondt" value="">

                    <div class="mb-3">
                        <label for="codeworker" class="form-label">Seleccionar Trabajador</label>
                        <select class="form-select" id="codeworker" name="codeworker" onchange="mostrarDetallesTrabajadorEdit()">
                            <option value="">-- Seleccione un trabajador --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="workercodeDisplayedit" class="form-label">C車digo de Trabajador</label>
                        <input type="text" class="form-control" id="workercodeDisplayedit" name="workercodeDisplayedit" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="fullnameedit" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="fullnameedit" name="fullnameedit" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="codebondedit" class="form-label">Seleccionar Bono</label>
                        <select class="form-select" id="codebondedit" name="codebondedit" onchange="mostrarDetallesBonoEdit()">
                            <option value="">-- Seleccione un bono --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bondreasonedit" class="form-label">Raz車n del Bono</label>
                        <input type="text" class="form-control" id="bondreasonedit" name="bondreasonedit" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="bondvalueedit" class="form-label">Valor del Bono</label>
                        <input type="text" class="form-control" id="bondvalueedit" name="bondvalueedit" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="bondwdeleteedit" class="form-label">Estado</label>
                        <select class="form-select" id="bondwdeleteedit" name="bondwdeleteedit">
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
            const response = await fetch('../../routes/bondworker/getWorkers.php');
            if (!response.ok) throw new Error('Error al cargar trabajadores');
            
            const data = await response.json();
            if (!data || !Array.isArray(data.workers)) throw new Error('Datos de trabajadores no v芍lidos');

            const combobox = document.getElementById('codeworker');
            if (!combobox) return;

            combobox.innerHTML = '<option value="">-- Seleccione un trabajador --</option>';

            data.workers.forEach(trabajador => {
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
        if (!combobox) return;

        const selectedOption = combobox.options[combobox.selectedIndex];
        if (!selectedOption || selectedOption.value === "") return;

        const fullnameInput = document.getElementById('fullnameedit');
        const workercodeInput = document.getElementById('workercodeDisplayedit');
        
        if (fullnameInput) fullnameInput.value = selectedOption.getAttribute('data-fullnameedit') || '';
        if (workercodeInput) workercodeInput.value = selectedOption.getAttribute('data-workercodeDisplayedit') || '';
    }

    async function cargarBonosEdit() {
        try {
            const response = await fetch('../../routes/bondworker/getBondModal.php');
            if (!response.ok) throw new Error('Error al cargar bonos');
            
            const data = await response.json();
            if (!data || !Array.isArray(data.bondw)) throw new Error('Datos de bonos no v芍lidos');

            const combobox = document.getElementById('codebondedit');
            if (!combobox) return;

            combobox.innerHTML = '<option value="">-- Seleccione un bono --</option>';

            data.bondw.forEach(bono => {
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
        if (!combobox) return;

        const selectedOption = combobox.options[combobox.selectedIndex];
        if (!selectedOption || selectedOption.value === "") return;

        const reasonInput = document.getElementById('bondreasonedit');
        const valueInput = document.getElementById('bondvalueedit');
        
        if (reasonInput) reasonInput.value = selectedOption.getAttribute('data-bondreasonedit') || '';
        if (valueInput) valueInput.value = selectedOption.getAttribute('data-bondvalueedit') || '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editAsigBondWorkerModal');
        if (!editModal) return;

        editModal.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            if (!button) return;

            const codebondw = button.getAttribute('data-bs-id');
            if (!codebondw) return;

            // Cargar datos iniciales
            await cargarTrabajadoresEdit();
            await cargarBonosEdit();

            try {
                const response = await fetch('../../routes/bondworker/getBondwModal.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `codebondw=${encodeURIComponent(codebondw)}`
                });

                if (!response.ok) throw new Error('Error al cargar datos de asignaci車n');
                
                const data = await response.json();
                if (!data) throw new Error('Datos de asignaci車n no v芍lidos');

                // Actualizar campos del formulario
                const codebondwInput = document.getElementById('codebondw');
                const codeworkerSelect = document.getElementById('codeworker');
                const codebondSelect = document.getElementById('codebondedit');
                const bondwdeleteSelect = document.getElementById('bondwdeleteedit');
                const fullnameInput = document.getElementById('fullnameedit');
                const workercodeInput = document.getElementById('workercodeDisplayedit');
                const reasonInput = document.getElementById('bondreasonedit');
                const valueInput = document.getElementById('bondvalueedit');

                if (codebondwInput) codebondwInput.value = codebondw;
                if (codeworkerSelect) codeworkerSelect.value = data.codeworker || '';
                if (codebondSelect) codebondSelect.value = data.codebond || '';
                if (bondwdeleteSelect) bondwdeleteSelect.value = data.bondwdelete || '0';
                if (fullnameInput) fullnameInput.value = data.fullname || '';
                if (workercodeInput) workercodeInput.value = data.workercode || '';
                if (reasonInput) reasonInput.value = data.bondreason || '';
                if (valueInput) valueInput.value = data.bondvalue || '';

            } catch (error) {
                console.error('Error al cargar datos de asignaci車n:', error);
            }
        });

        editModal.addEventListener('hidden.bs.modal', () => {
            // Limpiar campos al cerrar el modal
            const inputs = [
                'codebondw', 'codeworker', 'codebondedit', 'bondwdeleteedit',
                'fullnameedit', 'workercodeDisplayedit', 'bondreasonedit', 'bondvalueedit'
            ];

            inputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    if (element.tagName === 'SELECT' && id === 'bondwdeleteedit') {
                        element.value = '0';
                    } else {
                        element.value = '';
                    }
                }
            });
        });
    });
</script>