<h2 class="titulogestion">Programar Licencia</h2>
<div class="section">
    <form action="routes/license/addLicense.php" method="POST">
        <table class="table">
            <tr>
                <th colspan="2">
                    <p class="fw-normal"><strong>INFORMACION PERSONAL</strong></p>
                </th>
            </tr>

            <input type="hidden" name="licensename" id="licensename" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="licenselastname" id="licenselastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">
            
            <tr>
                <td colspan="2">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Codigo del Trabajador:</span>
                        <input oninput="buscarCodeWorker(this.value)" type="text" class="form-control" id="searchInput">
                        <input type="hidden" id="codeworker" name="codeworker" value="">
                    </div>
                    <div id="suggestionsCodeWorker" class="mt-2"></div>
                    <div class="input-group">
                        <span class="input-group-text">Nombre del Trabajador:</span>
                        <input name="workername" id="workername" type="text" class="form-control" disabled>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Cargo actual:</span>
                        <input name="workerrol" id="workerrol" type="text" class="form-control" disabled>
                        <span class="input-group-text">Fecha de ingreso:</span>
                        <input name="workerdateinit" id="workerdateinit" type="text" class="form-control" disabled>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="input-group">
                        <span class="input-group-text">Codigo de Licencia:</span>
                        <input name="licensecode" id="licensecode" type="text" class="form-control">
                        <span class="input-group-text">Nro de Licencia:</span>
                        <input name="licensenro" id="licensenro" type="text" class="form-control">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <span>Con goce de haber?</span>
                        <div style="display: flex;">
                            <div class="form-check" style="margin-right: 10px;">
                                <input class="form-check-input" type="radio" name="goceHaber" id="goceHaberSi" value="0" checked>
                                <label class="form-check-label" for="goceHaberSi">SI</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="goceHaber" id="goceHaberNo" value="1">
                                <label class="form-check-label" for="goceHaberNo">NO</label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <span>Tipo</span>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="porHora" value="hora">
                            <label class="form-check-label" for="porHora">Por hora</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="porFecha" value="fecha">
                            <label class="form-check-label" for="porFecha">Por fecha</label>
                        </div>
                        <div id="seleccionHora" class="hidden">
                            <label for="fechaHora">Seleccione una fecha:</label>
                            <input type="date" id="fechaHora" name="fechaHora">
                            <label for="horaInicio">Hora de inicio:</label>
                            <input type="time" id="horaInicio" name="horaInicio">
                            <label for="horaFin">Hora de fin:</label>
                            <input type="time" id="horaFin" name="horaFin">
                        </div>
                        <div id="seleccionFecha" class="hidden">
                            <label for="fechaInicio">Fecha de inicio:</label>
                            <input type="date" id="fechaInicio" name="fechaInicio">
                            <label for="fechaFin">Fecha de fin:</label>
                            <input type="date" id="fechaFin" name="fechaFin">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="input-group">
                        <span class="input-group-text">Observaciones:</span>
                        <textarea class="form-control" rows="3" name="observaciones"></textarea>
                    </div>
                </td>
            </tr>
        </table>
        <div class="d-grid">
            <button class="btn" type="submit">Aceptar</button>
        </div>
    </form>
</div>

<script>
    const porHora = document.getElementById('porHora');
    const porFecha = document.getElementById('porFecha');
    const seleccionHora = document.getElementById('seleccionHora');
    const seleccionFecha = document.getElementById('seleccionFecha');

    porHora.addEventListener('change', function () {
        if (this.checked) {
            seleccionHora.classList.remove('hidden');
            seleccionFecha.classList.add('hidden');
        }
    });

    porFecha.addEventListener('change', function () {
        if (this.checked) {
            seleccionFecha.classList.remove('hidden');
            seleccionHora.classList.add('hidden');
        }
    });

    function buscarCodeWorker(query) {
        if (query.length <= 1) {
            document.getElementById('suggestionsCodeWorker').innerHTML = '';
            return;
        }

        fetch('../../routes/register/getcodeworker.php?q=' + query)
            .then(response => response.text())
            .then(data => {
                document.getElementById('suggestionsCodeWorker').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function seleccionarCodeWorker(code, workercode, name, rol, dateInit) {
        document.getElementById('codeworker').value = code;
        document.getElementById('workername').value = name;
        document.getElementById('workerrol').value = rol;
        document.getElementById('workerdateinit').value = dateInit;
        document.getElementById('suggestionsCodeWorker').innerHTML = '';
        document.getElementById('searchInput').value = workercode + " - " + name;
    }
</script>

<style>
body {
    font-size: 14px;
    font-family: Arial, sans-serif;
}

.hidden {
    display: none;
}

.section {
    margin: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table td,
.table th {
    padding: 10px;
    border: 1px solid #ddd;
}

.input-group {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    padding: 8px;
    min-width: 150px;
}

.form-control {
    flex: 1;
    padding: 8px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.form-check {
    margin-right: 10px;
}

.btn {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
}

.d-grid {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}
</style>