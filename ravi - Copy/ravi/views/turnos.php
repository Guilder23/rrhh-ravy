<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
<body>
    <h2 class="titulogestion">Programar Turnos</h2>
    <section class="containerOptions">
        <div class="inputTurno">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Nombre de turno a buscar...">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Número de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addTurnoModal">
            <i class="fa-solid fa-circle-plus"></i> Nuevo Registro de Turno
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>


<div class="containerTable">
    <!-- Tabla de turnos -->
    <table class="table table-sm table-striped table-hover" id="tablaTurno">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Inicio Turno</th>
                <th scope="col">Fin Turno</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
    <!-- Paginacion -->
    <nav>
        <ul class="pagination justify-content-center" id="paginacion">
        </ul>
    </nav>
    
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

<?php include 'modals/turn/addTurnoModal.php'; ?>
<?php include 'modals/turn/deleteTurnoModal.php'; ?>
<?php include 'modals/turn/editTurnoModal.php'; ?>

<script>
    const tabla = document.querySelector('#tablaTurno tbody');
    const paginacion = document.querySelector('#paginacion');
    const buscarInput = document.querySelector('#buscar');
    const registrosPorPaginaSelect = document.querySelector('#registrosPorPagina');
    let currentPage = 1;
    let rowsPerPage = parseInt(registrosPorPaginaSelect.value);
    let totalPages = 1;

    registrosPorPaginaSelect.addEventListener('change', function () {
        rowsPerPage = parseInt(this.value);
        currentPage = 1; // reset to the first page
        cargarTurno(currentPage, rowsPerPage);
    });

    async function cargarTurno(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;

        try {
            const response = await fetch(`../routes/turn/getTurn.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';
            data.turnos.forEach(turno => {
                const status = turno.turndelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const turnoRow = `
                    <tr>
                        <td>${turno.turncreate}</td>
                        <td>${turno.turnname}</td>
                        <td>${turno.turnstart}</td>
                        <td>${turno.turnend}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTurnoModal" data-bs-id="${turno.codeturn}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTurnoModal" data-bs-id="${turno.codeturn}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tabla.insertAdjacentHTML('beforeend', turnoRow);
            });

            totalPages = data.totalPaginas;
            paginacion.innerHTML = '';

            const createPageItem = (page, label = page) => `
                <li class="page-item ${pagina === page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="cargarTurno(${page}, ${limite})">${label}</a>
                </li>
            `;

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarTurno(${pagina - 1}, ${limite})">
                        <i class="fas fa-angle-left"></i><span>Prev</span>
                    </a>
                </li>
            `);

            if (totalPages <= 7) {
                for (let i = 1; i <= totalPages; i++) {
                    paginacion.insertAdjacentHTML('beforeend', createPageItem(i));
                }
            } else {
                if (pagina > 3) {
                    paginacion.insertAdjacentHTML('beforeend', `
                        ${createPageItem(1)}
                        <li class="page-item">
                            <input type="number" id="jumpToPage" class="form-control" placeholder="..." min="1" max="${totalPages}" style="width: 60px;" 
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarTurno(page, ${limite}); }" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </li>
                    `);
                }

                const startPage = Math.max(1, pagina - 1);
                const endPage = Math.min(totalPages, pagina + 1);

                for (let i = startPage; i <= endPage; i++) {
                    paginacion.insertAdjacentHTML('beforeend', createPageItem(i));
                }

                if (pagina < totalPages - 2) {
                    paginacion.insertAdjacentHTML('beforeend', `
                        <li class="page-item">
                            <input type="number" id="jumpToPage" class="form-control" placeholder="..." min="1" max="${totalPages}" style="width: 60px;" 
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarTurno(page, ${limite}); }" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </li>
                        ${createPageItem(totalPages)}
                    `);
                }
            }

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarTurno(${pagina + 1}, ${limite})"><span>Next</span><i class="fas fa-angle-right"></i></a>
                </li>
            `);

        } catch (error) {
            console.error('Error al cargar turnos:', error);
        }
    }

    const eliminaModal = document.getElementById('deleteTurnoModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codeturn = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codeturn').value = codeturn;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codeturn').value = '';
        cargarTurno(currentPage, rowsPerPage);
    });
    
    let editaModal = document.getElementById('editTurnoModal');
    
    editaModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let codeturn = button.getAttribute('data-bs-id');
    
        let inputCodeturn = editaModal.querySelector('.modal-body #codeturn');
        let inputTurnname = editaModal.querySelector('.modal-body #turnname');
        let inputTurnstart = editaModal.querySelector('.modal-body #turnstart');
        let inputTurnend = editaModal.querySelector('.modal-body #turnend');
        let inputTurndelete = editaModal.querySelector('.modal-body #turndelete');
        let statusLabel = editaModal.querySelector('.modal-body #statusLabel');
    
        let url = '../routes/turn/getTurnoModal.php';
        let formData = new FormData();
        formData.append('codeturn', codeturn);
    
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            inputCodeturn.value = data.codeturn;
            inputTurnname.value = data.turnname;
            inputTurnstart.value = data.turnstart;
            inputTurnend.value = data.turnend;
    
            inputTurndelete.checked = data.turndelete === 1;
            statusLabel.textContent = data.turndelete === 1 ? "ACTIVO" : "INACTIVO";
        })
        .catch(err => console.error('Error al obtener los datos del turno:', err));
    });
    
    editaModal.addEventListener('hidden.bs.modal', () => {
            editaModal.querySelector('.modal-body #codeturn').value = '';
            editaModal.querySelector('.modal-body #turnname').value = '';
            editaModal.querySelector('.modal-body #turnstart').value = '';
            editaModal.querySelector('.modal-body #turnend').value = '';
            editaModal.querySelector('.modal-body #turndelete').checked = false;
            editaModal.statusLabel.textContent = 'INACTIVO'; 
        });
    
    let addModal = document.getElementById('addTurnoModal');
    
    addModal.addEventListener('shown.bs.modal', event => {
        addModal.querySelector('.modal-body #turnname').focus()
    })

    addModal.addEventListener('hidden.bs.modal', event => {
        addModal.querySelector('.modal-body #turnname').value = ""
    })
        
    setTimeout(function() {
        const message = document.querySelector('.message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000); // 5000 ms = 5 segundos

    // Llamada para ejecutar la consulta del input busqueda
    buscarInput.addEventListener('input', function () {
        cargarTurno(1, parseInt(registrosPorPaginaSelect.value));
    });

    document.addEventListener('DOMContentLoaded', () => cargarTurno(currentPage, rowsPerPage));
</script>