<h2 class="titulogestion">Configure los parametros del bono de antiguedad</h2>
<section class="bordeOrdenado">
<div class="mt-4">
    <div class="card-body">
      <!--  <div class="mb-3">
            <label class="form-label">Estado:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estado" id="rbtEstadoActivo" value="1" checked>
                <label class="form-check-label" for="rbtEstadoActivo">Activo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estado" id="rbtEstadoInactivo" value="0">
                <label class="form-check-label" for="rbtEstadoInactivo">Inactivo</label>
            </div>
        </div>-->
        <button type="button" id="btnGuardar" class="btn btn-primary">Guardar</button>
    </div>
    <button type="button" id="btnAgregarParametro" class="btn btn-success mb-3">
        <i class="bi bi-plus"></i> Agregar regla
    </button>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th></th>
                <th class="text-center">Base</th>
                <th></th>
                <th class="text-center">Anos</th>
                <th class="text-center">Bono</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tDatos">
            <!-- Las filas dinamicas -->
        </tbody>
    </table>
</div>
</section>
<script>
document.getElementById('btnAgregarParametro').addEventListener('click', function () {
    const tbody = document.getElementById('tDatos');

    const newRow = document.createElement('tr');
    const rowCount = tbody.children.length + 1;
    newRow.setAttribute('item', rowCount);
    newRow.classList.add('grd_fila');

    const actionsCell = document.createElement('td');
    actionsCell.classList.add('text-center');

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'me-1');
    deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
    deleteButton.onclick = function () {
        btnQuitarParametro_Click(rowCount);
    };
    actionsCell.appendChild(deleteButton);

    const editButton = document.createElement('button');
    editButton.type = 'button';
    editButton.classList.add('btn', 'btn-warning', 'btn-sm');
    editButton.innerHTML = '<i class="bi bi-pencil"></i>';
    editButton.onclick = function () {
        btnEditarParametro_Click(rowCount);
    };
    actionsCell.appendChild(editButton);

    newRow.appendChild(actionsCell);

    const baseCell = document.createElement('td');
    baseCell.textContent = 'Antiguedad';
    newRow.appendChild(baseCell);

    const compareCell = document.createElement('td');
    compareCell.classList.add('text-center');
    const compareSelect = document.createElement('select');
    compareSelect.classList.add('form-select', 'form-select-sm');
    compareSelect.innerHTML = `
        <option value="1">&gt;</option>
        <option value="2">&gt;=</option>
        <option value="3">=</option>
        <option value="4" selected>&lt;</option>
        <option value="5">&lt;=</option>
    `;
    compareCell.appendChild(compareSelect);
    newRow.appendChild(compareCell);

    const yearsCell = document.createElement('td');
    yearsCell.classList.add('text-center');
    const yearsInput = document.createElement('input');
    yearsInput.type = 'text';
    yearsInput.classList.add('form-control', 'form-control-sm');
    yearsInput.value = '0';
    yearsInput.maxLength = 3;
    yearsCell.appendChild(yearsInput);
    newRow.appendChild(yearsCell);

    const bonusValueCell = document.createElement('td');
    bonusValueCell.classList.add('text-center');

    const bonusInput = document.createElement('input');
    bonusInput.type = 'text';
    bonusInput.classList.add('form-control', 'form-control-sm');
    bonusInput.value = '0.00';
    bonusInput.maxLength = 5;

    bonusInput.addEventListener('input', function (event) {
        const value = event.target.value;
        const regex = /^\d*\.?\d{0,2}$/;
        if (!regex.test(value)) {
            event.target.value = event.target.value.slice(0, -1);
        }
    });

    bonusValueCell.appendChild(bonusInput);
    newRow.appendChild(bonusValueCell);

    const percentSymbolCell = document.createElement('td');
    percentSymbolCell.classList.add('text-center');
    percentSymbolCell.textContent = '%'; // S¨ªmbolo est¨¢tico
    newRow.appendChild(percentSymbolCell);

    tbody.appendChild(newRow);

    document.getElementById('btnGuardar').style.display = 'inline-block';
});

function btnQuitarParametro_Click(rowIndex) {
    const tbody = document.getElementById('tDatos');
    const rowToRemove = tbody.querySelector(`tr[item="${rowIndex}"]`);
    if (rowToRemove) {
        tbody.removeChild(rowToRemove);

        if (tbody.children.length === 0) {
            document.getElementById('btnGuardar').style.display = 'none';
        }
    }
}

function btnEditarParametro_Click(rowIndex) {
    const tbody = document.getElementById('tDatos');
    const rowToEdit = tbody.querySelector(`tr[item="${rowIndex}"]`);

    if (rowToEdit) {
        const compareSelect = rowToEdit.querySelector('select');
        const yearsInput = rowToEdit.querySelector('input[type="text"]');
        const bonusInput = rowToEdit.querySelectorAll('input[type="text"]')[1];

        compareSelect.disabled = !compareSelect.disabled;
        yearsInput.disabled = !yearsInput.disabled;
        bonusInput.disabled = !bonusInput.disabled;

        const editButton = rowToEdit.querySelector('button.btn-warning');
        if (compareSelect.disabled) {
            editButton.innerHTML = '<i class="bi bi-pencil"></i>';
        } else {
            editButton.innerHTML = '<i class="bi bi-check"></i>';
        }
    }
}
</script>

<style>
    table.table-bordered td {
        padding: 0.25rem;
    }
    
    #btnGuardar {
        display: none;
    }
</style>