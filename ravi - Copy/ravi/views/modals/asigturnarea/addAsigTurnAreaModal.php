<div class="modal fade" id="addAsigTurnAreaModal" tabindex="-1" aria-labelledby="addAsigTurnAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAsigTurnAreaModalLabel">Asignar Turno a Área</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/asigarea/addAsigAreaTurn.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codeturna" id="codeturna" value="">

                    <input type="hidden" name="turnaname" id="turnaname" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="turnalastname" id="turnalastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">
                     
                <div class="separar">
                    <div class="mitad">
                    <div class="mb-3">
                        <label for="areacode" class="form-label">Seleccionar Área</label>
                        <select class="form-select" id="areacode" name="areacode" onchange="mostrarDetallesArea()">
                            <option value="">-- Seleccione un área --</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="areanameDisplay" class="form-label">Nombre del Área</label>
                        <input type="text" class="form-control" id="areanameDisplay" name="areanameDisplay" disabled>
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
                    </div><!--fin mitad-->
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
    async function cargarAreas() {
        try {
            const response = await fetch('../routes/asigarea/getArea.php');
            const areas = await response.json();

            const combobox = document.getElementById('areacode');
            combobox.innerHTML = '<option value="">-- Seleccione un área --</option>';

            areas.forEach(area => {
                const option = document.createElement('option');
                option.value = area.codearea;
                option.setAttribute('data-areaname', area.areaname);
                option.textContent = `${area.codearea} - ${area.areaname}`;
                combobox.appendChild(option);
            });

        } catch (error) {
            console.error('Error al cargar áreas:', error);
            alert('No se pudieron cargar las áreas. Inténtalo de nuevo más tarde.');
        }
    }
    
    function mostrarDetallesArea() {
        const combobox = document.getElementById('areacode');
        const selectedOption = combobox.options[combobox.selectedIndex];
    
        document.getElementById('areanameDisplay').value = selectedOption.getAttribute('data-areaname');
    }

    async function cargarTurnos() {
        try {
            const response = await fetch('../routes/asigarea/getTurn.php');
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
            alert('No se pudieron cargar los turnos. Inténtalo de nuevo más tarde.');
        }
    }
    
    function mostrarDetallesTurno() {
        const combobox = document.getElementById('codeturn');
        const selectedOption = combobox.options[combobox.selectedIndex];
    
        document.getElementById('turnstart').value = selectedOption.getAttribute('data-turnstart');
        document.getElementById('turnend').value = selectedOption.getAttribute('data-turnend');
    }

    document.getElementById('addAsigTurnAreaModal').addEventListener('shown.bs.modal', () => {
        cargarAreas();
        cargarTurnos();
    });
</script>