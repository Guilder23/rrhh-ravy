<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .table thead th {
        background-color: #f8f9fa;
    }
    .table {
        font-size: 14px;
    }
    .table th, .table td {
        padding: 0.5rem;
    }
</style>
     <h2 class="titulogestion">Feriados</h2>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Información general</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="ddlAno" class="form-label">Año:</label>
                        <select class="form-select" id="ddlAno">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="ddlMes" class="form-label">Mes:</label>
                        <select class="form-select" id="ddlMes">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-primary mt-3" id="btnGuardar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Días del mes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 50px;"></th>
                                <th scope="col">Día</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Naturaleza</th>
                                <th scope="col" class="text-center">¿Recorrer si cae domingo?</th>
                                <th scope="col" class="text-center">Feriado medio día</th>
                                <!--<th scope="col">Regionales / Sucursales / Oficinas</th> -->
                            </tr>
                        </thead>
                        <tbody id="tbodyRes">
                        </tbody>
                    </table>
                </div>             
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>

    <script>
        const feriadosFijos = {
            1: [{ dia: 1, descripcion: "Año Nuevo", naturaleza: "Nacional", recorrer: true, medioDia: false }],
            2: [{ dia: 12, descripcion: "Día de la Juventud", naturaleza: "Regional", recorrer: false, medioDia: false }],
            5: [{ dia: 1, descripcion: "Día del Trabajador", naturaleza: "Nacional", recorrer: true, medioDia: false }],
            7: [{ dia: 5, descripcion: "Día de la Independencia", naturaleza: "Nacional", recorrer: true, medioDia: false }],
            12: [{ dia: 25, descripcion: "Navidad", naturaleza: "Nacional", recorrer: true, medioDia: false }]
        };

        function esBisiesto(año) {
            return (año % 4 === 0 && año % 100 !== 0) || (año % 400 === 0);
        }

        function getDiasMes(mes, año) {
            if (mes === 2) { 
                return esBisiesto(año) ? 29 : 28;
            }
            return new Date(año, mes, 0).getDate();
        }

        function cargarDiasMes(mes, año) {
            const tbody = document.getElementById('tbodyRes');
            tbody.innerHTML = ''; 

            const diasMes = getDiasMes(mes, año);
            const feriadosMes = feriadosFijos[mes] || [];

            for (let dia = 1; dia <= diasMes; dia++) {
                const feriado = feriadosMes.find(f => f.dia === dia);
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <input type="checkbox" class="form-check-input chkEditar" ${feriado ? 'checked' : ''}>
                    </td>
                    <td>${dia}</td>
                    <td>
                        <input type="text" class="form-control" value="${feriado ? feriado.descripcion : ''}" ${feriado ? '' : 'disabled'}>
                    </td>
                    <td>
                        <select class="form-select" ${feriado ? '' : 'disabled'}>
                            <option value="Nacional" ${feriado && feriado.naturaleza === "Nacional" ? 'selected' : ''}>Nacional</option>
                            <option value="Regional" ${feriado && feriado.naturaleza === "Regional" ? 'selected' : ''}>Regional</option>
                            <option value="Sucursal" ${feriado && feriado.naturaleza === "Sucursal" ? 'selected' : ''}>Sucursal</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input" ${feriado && feriado.recorrer ? 'checked' : ''} ${feriado ? '' : 'disabled'}>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input" ${feriado && feriado.medioDia ? 'checked' : ''} ${feriado ? '' : 'disabled'}>
                    </td>
                `;
                tbody.appendChild(row);
            }

            const checkboxes = document.querySelectorAll('.chkEditar');
            checkboxes.forEach(chk => {
                chk.addEventListener('change', function() {
                    const inputs = this.closest('tr').querySelectorAll('input, select');
                    inputs.forEach(input => {
                        if (input !== this) {
                            input.disabled = !this.checked;
                        }
                    });
                });

                if (chk.checked) {
                    const inputs = chk.closest('tr').querySelectorAll('input, select');
                    inputs.forEach(input => {
                        if (input !== chk) {
                            input.disabled = false;
                        }
                    });
                }
            });
        }

        function generarOpcionesAno() {
            const ddlAno = document.getElementById('ddlAno');
            const añoActual = new Date().getFullYear();
            for (let i = añoActual; i >= añoActual - 10; i--) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                ddlAno.appendChild(option);
            }
        }

        function actualizarTabla() {
            const mesSeleccionado = document.getElementById('ddlMes').value;
            const añoSeleccionado = document.getElementById('ddlAno').value;
            cargarDiasMes(mesSeleccionado, añoSeleccionado);
        }

        document.getElementById('ddlMes').addEventListener('change', actualizarTabla);
        document.getElementById('ddlAno').addEventListener('change', actualizarTabla);

        const mesActual = new Date().getMonth() + 1; 
        const añoActual = new Date().getFullYear();
        document.getElementById('ddlMes').value = mesActual;
        generarOpcionesAno();
        document.getElementById('ddlAno').value = añoActual;

        actualizarTabla();

        document.getElementById('btnGuardar').addEventListener('click', function() {
            const mesSeleccionado = document.getElementById('ddlMes').value;
            const añoSeleccionado = document.getElementById('ddlAno').value;
            const filas = document.querySelectorAll('#tbodyRes tr');
            const datosGuardados = [];

            filas.forEach(fila => {
                const dia = fila.querySelector('td:nth-child(2)').textContent;
                const descripcion = fila.querySelector('td:nth-child(3) input').value;
                const naturaleza = fila.querySelector('td:nth-child(4) select').value;
                const recorrer = fila.querySelector('td:nth-child(5) input').checked;
                const medioDia = fila.querySelector('td:nth-child(6) input').checked;

                if (descripcion) {
                    datosGuardados.push({
                        dia: parseInt(dia),
                        descripcion,
                        naturaleza,
                        recorrer,
                        medioDia
                    });
                }
            });

            console.log("Datos guardados:", datosGuardados);
            alert(`Datos guardados para ${mesSeleccionado}/${añoSeleccionado}: ${JSON.stringify(datosGuardados)}`);
        });
    </script>
</body>