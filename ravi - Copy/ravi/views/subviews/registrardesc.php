<h2 class="titulogestion">Vista Descuentos</h2>
<div class="section">
    <form action="routes/license/addLicense.php" method="POST" onsubmit="return validarFormulario()">
        <table class="table table-bordered">
            <tr>
                <td style="width: 115px">Duración:</td>
                <td colspan="3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="rbtDuracionDefinida" type="radio" name="duracion" value="1" checked="checked">
                        <label class="form-check-label" for="rbtDuracionDefinida">Definida</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="rbtDuracionIndefinida" type="radio" name="duracion" value="0">
                        <label class="form-check-label" for="rbtDuracionIndefinida">Indefinida</label>
                    </div>
                </td>
            </tr>
            <tr id="trPeriodo" style="display: none;">
                <td>Período inicio:</td>
                <td>
                    <div class="row">
                        <div class="col">
                            <select class="form-select" name="periodoMesInicio" id="ddlPeriodoMesInicio">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option selected="selected" value="4">Abril</option>
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
                        <div class="col">
                            <select class="form-select" name="periodoAnioInicio" id="ddlPeriodoAnioInicio">
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option selected="selected" value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td>Período fin:</td>
                <td>
                    <div class="row">
                        <div class="col">
                            <select class="form-select" name="periodoMesFin" id="ddlPeriodoMesFin">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option selected="selected" value="4">Abril</option>
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
                        <div class="col">
                            <select class="form-select" name="periodoAnioFin" id="ddlPeriodoAnioFin">
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option selected="selected" value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="mb-3">
                        <label>Código del Trabajador:</label>
                        <input oninput="buscarCodeWorker(this.value)" type="text" class="form-control" id="searchInput">
                        <input type="hidden" id="codeworker" name="codeworker" value="">
                        <div id="suggestionsCodeWorker" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label>Nombre del Trabajador:</label>
                        <input name="workername" id="workername" type="text" class="form-control" disabled>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label style="width: 115px">Cargo actual:</label>
                            <input name="workerrol" id="workerrol" type="text" class="form-control" disabled>
                        </div>
                        <div class="col">
                            <label style="width: 115px">Fecha de ingreso:</label>
                            <input name="workerdateinit" id="workerdateinit" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="mb-3">
                        <label>Cantidad del descuento:</label>
                        <input name="licensecode" id="licensecode" type="text" style="width: 115px">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="mb-3">
                        <label>Razón o motivo del descuento:</label>
                        <textarea class="form-control" rows="3" name="observaciones"></textarea>
                    </div>
                </td>
            </tr>
        </table>
        <div class="d-grid">
            <button class="btn btn-primary" type="submit">Aceptar</button>
        </div>
    </form>
</div>

<script>
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
        document.getElementById('codeworker').value = workercode;
        document.getElementById('workername').value = name;
        document.getElementById('workerrol').value = rol;
        document.getElementById('workerdateinit').value = dateInit;
        document.getElementById('suggestionsCodeWorker').innerHTML = '';
        document.getElementById('searchInput').value = code + " - " + name;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const rbtDuracionDefinida = document.getElementById('rbtDuracionDefinida');
        const rbtDuracionIndefinida = document.getElementById('rbtDuracionIndefinida');
        const trPeriodo = document.getElementById('trPeriodo');

        rbtDuracionDefinida.addEventListener('change', function() {
            if (this.checked) {
                trPeriodo.style.display = 'table-row';
            }
        });

        rbtDuracionIndefinida.addEventListener('change', function() {
            if (this.checked) {
                trPeriodo.style.display = 'none';
            }
        });

        if (rbtDuracionDefinida.checked) {
            trPeriodo.style.display = 'table-row';
        } else {
            trPeriodo.style.display = 'none';
        }
    });

    function validarFormulario() {
        const codeworker = document.getElementById('codeworker').value;
        const licensecode = document.getElementById('licensecode').value;
        const observaciones = document.querySelector('textarea[name="observaciones"]').value;

        if (!codeworker || !licensecode || !observaciones) {
            alert('Por favor, complete todos los campos obligatorios.');
            return false;
        }

        return true;
    }
</script>

<style>
    body {
        font-size: 14px;
        font-family: Arial, sans-serif;
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

    .form-control {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .form-check-inline {
        display: inline-block;
        margin-right: 10px;
    }

    .form-select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .d-grid {
        display: grid;
        place-items: center;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }
</style>