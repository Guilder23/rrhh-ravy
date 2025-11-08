<div class="modal fade" id="addAsigBondTurnModal" tabindex="-1" aria-labelledby="addAsigBondTurnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAsigBondTurnModalLabel">Asignar Bonos a Turno</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/bondturn/addAsigTurnBond.php" method="post" id="bondTurnForm">
                    <input type="hidden" name="bondtname" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="bondtlastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="mb-3">
                        <label for="turnname" class="form-label">Seleccionar Turno</label>
                        <select class="form-select" id="turnname" name="codeturn" required>
                            <option value="">-- Seleccione un turno --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="turnnameDisplay" class="form-label">Nombre del Turno</label>
                        <input type="text" class="form-control" id="turnnameDisplay" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="turnschedule" class="form-label">Horario</label>
                        <input type="text" class="form-control" id="turnschedule" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="bondSelector" class="form-label">Seleccionar Bonos</label>
                        <select class="form-select" id="bondSelector">
                            <option value="">-- Seleccione un bono --</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addBondBtn">Agregar Bono</button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bonos Seleccionados</label>
                        <div id="selectedBondsContainer" class="border p-2" style="min-height: 100px;">
                            <p class="text-muted">No hay bonos seleccionados</p>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar Asignaciones
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedBonds = [];
    let existingAssignments = [];

    async function cargarTurnos() {
        try {
            const response = await fetch('../routes/bondturn/getTurn.php');
            
            const data = await response.json();
            
            if (!data.success || !Array.isArray(data.data)) {
                throw new Error('Formato de respuesta inválido');
            }
            
            const turnos = data.data;
            const combobox = document.getElementById('turnname');
            combobox.innerHTML = '<option value="">-- Seleccione un turno --</option>';
    
            turnos.forEach(turno => {
                const option = document.createElement('option');
                option.value = turno.codeturn;
                option.setAttribute('data-turnname', turno.turnname);
                option.setAttribute('data-turnstart', turno.turnstart);
                option.setAttribute('data-turnend', turno.turnend);
                option.textContent = `${turno.turnname} (${turno.turnstart} - ${turno.turnend})`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar turnos:', error);
            alert('Error al cargar los turnos. Por favor intente nuevamente.');
        }
    }

    async function cargarBonos() {
        try {
            const response = await fetch('../routes/bondturn/getAvailableBonds.php');
            
            const data = await response.json();

            const bonos = data.data;
            const combobox = document.getElementById('bondSelector');
            combobox.innerHTML = '<option value="">-- Seleccione un bono --</option>';
    
            if (bonos.length === 0) {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No hay bonos disponibles";
                combobox.appendChild(option);
                return;
            }
    
            bonos.forEach(bono => {
                if (!bono.codebond || !bono.bondcode || !bono.bondreason || !bono.bondvalue) {
                    console.warn('Bono con estructura incompleta:', bono);
                    return;
                }
                
                const option = document.createElement('option');
                option.value = bono.codebond;
                option.setAttribute('data-bondname', bono.bondname || '');
                option.setAttribute('data-bondreason', bono.bondreason);
                option.setAttribute('data-bondvalue', bono.bondvalue);
                option.textContent = `${bono.bondcode} - ${bono.bondreason} ($${bono.bondvalue})`;
                combobox.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar los bonos:', error);
            const combobox = document.getElementById('bondSelector');
            combobox.innerHTML = '<option value="">-- Error al cargar bonos --</option>';
        }
    }

    function updateSelectedBondsDisplay() {
        const container = document.getElementById('selectedBondsContainer');
        
        if (selectedBonds.length === 0) {
            container.innerHTML = '<p class="text-muted">No hay bonos seleccionados</p>';
            return;
        }

        container.innerHTML = '';
        selectedBonds.forEach((bond, index) => {
            const bondCard = document.createElement('div');
            bondCard.className = 'card mb-2';
            bondCard.innerHTML = `
                <div class="card-body p-2 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">${bond.bondcode} - ${bond.bondreason}</h6>
                        <small class="text-muted">Valor: $${bond.bondvalue}</small>
                    </div>
                    <div>
                        <input type="hidden" name="bonds[${index}][codebond]" value="${bond.codebond}">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeBond(${bond.codebond})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(bondCard);
        });
    }
    function removeBond(codebond) {
        const codeToRemove = Number(codebond);
        selectedBonds = selectedBonds.filter(bond => Number(bond.codebond) !== codeToRemove);
        updateSelectedBondsDisplay();
    }
    document.getElementById('addBondBtn').addEventListener('click', () => {
        const bondSelector = document.getElementById('bondSelector');
        const selectedOption = bondSelector.options[bondSelector.selectedIndex];
        
        if (!selectedOption.value) {
            alert('Por favor seleccione un bono');
            return;
        }

        const codebond = selectedOption.value;
        const bondreason = selectedOption.getAttribute('data-bondreason');
        const bondvalue = selectedOption.getAttribute('data-bondvalue');
        const bondcode = selectedOption.text.split(' - ')[0];

        // Verificar si el bono ya esta asignado
        if (existingAssignments.includes(parseInt(codebond))) {
            alert('Este bono ya est¨¢ asignado al turno seleccionado');
            return;
        }

        // Verificar si el bono ya fue seleccionado
        if (selectedBonds.some(bond => bond.codebond === codebond)) {
            alert('Este bono ya fue agregado a la lista');
            return;
        }

        selectedBonds.push({
            codebond: codebond,
            bondcode: bondcode,
            bondreason: bondreason,
            bondvalue: bondvalue
        });

        updateSelectedBondsDisplay();
        bondSelector.selectedIndex = 0;
    });

    document.getElementById('turnname').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('turnnameDisplay').value = selectedOption.getAttribute('data-turnname');
        document.getElementById('turnschedule').value = `${selectedOption.getAttribute('data-turnstart')} - ${selectedOption.getAttribute('data-turnend')}`;
        
    });

    document.getElementById('addAsigBondTurnModal').addEventListener('shown.bs.modal', () => {
        cargarTurnos();
        cargarBonos();
        selectedBonds = [];
        existingAssignments = [];
        updateSelectedBondsDisplay();
    });

    document.getElementById('bondTurnForm').addEventListener('submit', function(e) {
        if (selectedBonds.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un bono para asignar');
            return false;
        }
        return true;
    });
</script>