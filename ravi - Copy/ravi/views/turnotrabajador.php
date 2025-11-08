<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
<body>   
    <section class="containerOptions">
        <div class="inputTurno">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Código o nombre completo">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Número de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addAsigTurnWorkerModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Asignación
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>
    
    <div class="containerTable">
    <table class="table table-sm table-striped table-hover" id="tablaAsigTurn">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Asignado Por</th>
                <th scope="col">Nombre Turno</th>
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

<?php include 'modals/asigturnworker/addAsigTurnWorkerModal.php'; ?>
<?php include 'modals/asigturnworker/editAsigWorkerModal.php'; ?>
<?php include 'modals/asigturnworker/deleteAsigWorkerModal.php'; ?>

<script>
    const tabla = document.querySelector('#tablaAsigTurn tbody');
    const paginacion = document.querySelector('#paginacion');
    const buscarInput = document.querySelector('#buscar');
    const registrosPorPaginaSelect = document.querySelector('#registrosPorPagina');
    let currentPage = 1;
    let rowsPerPage = parseInt(registrosPorPaginaSelect.value);
    let totalPages = 1;

    registrosPorPaginaSelect.addEventListener('change', function () {
        rowsPerPage = parseInt(this.value);
        currentPage = 1; // Reset to the first page
        cargarAsig(currentPage, rowsPerPage);
    });

    buscarInput.addEventListener('input', function () {
        currentPage = 1;
        cargarAsig(currentPage, rowsPerPage);
    });

    async function cargarAsig(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;

        try {
            const response = await fetch(`../routes/asigworker/getAsigWorkerTurn.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';

            data.turnos.forEach(turno => {
                const status = turno.turnwdelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const turnoRow = `
                    <tr>
                        <td>${turno.turnwcreate}</td>
                        <td>${turno.workercode}</td>
                        <td>${turno.fullname}</td>
                        <td>${turno.asigfullname}</td>
                        <td>${turno.turnname}</td>
                        <td>${turno.turnstart}</td>
                        <td>${turno.turnend}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAsigWorkerModal"
                               data-bs-id="${turno.codeturnw}"
                               data-bs-codeworker="${turno.codeworker}"
                               data-bs-codeturn="${turno.codeturn}"
                               data-bs-turnwdelete="${turno.turnwdelete}"
                               data-bs-fullname="${turno.fullname}"
                               data-bs-workercode="${turno.workercode}"
                               data-bs-turnstart="${turno.turnstart}"
                               data-bs-turnend="${turno.turnend}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAsigWorkerModal" data-bs-id="${turno.codeturnw}">
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
                    <a class="page-link" href="#" onclick="cargarAsig(${page}, ${limite})">${label}</a>
                </li>
            `;

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarAsig(${pagina - 1}, ${limite})">
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
                    paginacion.insertAdjacentHTML('beforeend', createPageItem(1));
                    paginacion.insertAdjacentHTML('beforeend', `
                        <li class="page-item">
                            <input type="number" id="jumpToPage" class="form-control" placeholder="..." min="1" max="${totalPages}" style="width: 60px;" 
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarAsig(page, ${limite}); }" 
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
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarAsig(page, ${limite}); }" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </li>
                        ${createPageItem(totalPages)}
                    `);
                }
            }

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarAsig(${pagina + 1}, ${limite})"><span>Next</span><i class="fas fa-angle-right"></i></a>
                </li>
            `);

        } catch (error) {
            console.error('Error al cargar asignaciones de turnos:', error);
        }
    }

    const editaModal = document.getElementById('editAsigWorkerModal');

    editaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codeturnw = button.getAttribute('data-bs-id');
        const codeworker = button.getAttribute('data-bs-codeworker');
        const codeturn = button.getAttribute('data-bs-codeturnedit');
        const turnwdelete = button.getAttribute('data-bs-turnwdelete');
        const fullname = button.getAttribute('data-bs-fullnameedit');
        const workercode = button.getAttribute('data-bs-workercodeDisplayedit');
        const turnstart = button.getAttribute('data-bs-turnstart');
        const turnend = button.getAttribute('data-bs-turnend');

        editaModal.querySelector('.modal-body #codeturnw').value = codeturnw;
        editaModal.querySelector('.modal-body #codeworker').value = codeworker;
        editaModal.querySelector('.modal-body #codeturnedit').value = codeturn;
        editaModal.querySelector('.modal-body #turnwdelete').value = turnwdelete;
        editaModal.querySelector('.modal-body #fullnameedit').value = fullname;
        editaModal.querySelector('.modal-body #workercodeDisplayedit').value = workercode;
        editaModal.querySelector('.modal-body #turnstart').value = turnstart;
        editaModal.querySelector('.modal-body #turnend').value = turnend;
    });

    editaModal.addEventListener('hidden.bs.modal', () => {
        editaModal.querySelector('.modal-body #codeturnw').value = '';
        editaModal.querySelector('.modal-body #codeworker').value = '';
        editaModal.querySelector('.modal-body #codeturnedit').value = '';
        editaModal.querySelector('.modal-body #turnwdelete').value = '0';
        editaModal.querySelector('.modal-body #fullnameedit').value = '';
        editaModal.querySelector('.modal-body #workercodeDisplayedit').value = '';
        editaModal.querySelector('.modal-body #turnstart').value = '';
        editaModal.querySelector('.modal-body #turnend').value = '';
    });

    const eliminaModal = document.getElementById('deleteAsigWorkerModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codeturnw = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codeturnw').value = codeturnw;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codeturnw').value = '';
        cargarAsig(currentPage, rowsPerPage);
    });

    document.addEventListener('DOMContentLoaded', () => {
        cargarAsig(currentPage, rowsPerPage);
    });
</script>