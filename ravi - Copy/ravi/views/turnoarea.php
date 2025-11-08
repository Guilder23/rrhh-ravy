<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
<body>   
    <section class="containerOptions">
        <div class="inputTurno">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Área o Asignado por...">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Numero de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addAsigTurnAreaModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Asignacion
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>
    
    <div class="containerTable">
    <table class="table table-sm table-striped table-hover" id="tablaAsigTurn">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Area</th>
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
    <!-- Paginaci車n -->
    <nav>
        <ul class="pagination justify-content-center" id="paginacion">
        </ul>
    </nav>
    
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

<?php include 'modals/asigturnarea/addAsigTurnAreaModal.php'; ?>
<?php include 'modals/asigturnarea/editAsigAreaModal.php'; ?>
<?php include 'modals/asigturnarea/deleteAsigAreaModal.php'; ?>

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
        cargarAsigArea(currentPage, rowsPerPage);
    });

    buscarInput.addEventListener('input', function () {
        currentPage = 1;
        cargarAsigArea(currentPage, rowsPerPage);
    });

    async function cargarAsigArea(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;

        try {
            const response = await fetch(`../routes/asigarea/getAsigAreaTurn.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';

            data.turnas.forEach(turna => {
                const status = turna.turnadelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const turnaRow = `
                    <tr>
                        <td>${turna.turnacreate}</td>
                        <td>${turna.areaname}</td>
                        <td>${turna.asigfullname}</td>
                        <td>${turna.turnname}</td>
                        <td>${turna.turnstart}</td>
                        <td>${turna.turnend}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAsigAreaModal" data-bs-id="${turna.codeturna}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAsigAreaModal" data-bs-id="${turna.codeturna}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tabla.insertAdjacentHTML('beforeend', turnaRow);
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
    
    let editaModal = document.getElementById('editAsigAreaModal');

    editaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codeturna = button.getAttribute('data-bs-id');
        const codearea = button.getAttribute('data-bs-codearea');
        const codeturn = button.getAttribute('data-bs-codeturn');
        const turnadelete = button.getAttribute('data-bs-turnadelete');
        const areaname = button.getAttribute('data-bs-areaname');
        const turnstart = button.getAttribute('data-bs-turnstart');
        const turnend = button.getAttribute('data-bs-turnend');
    
        editaModal.querySelector('.modal-body #codeturna').value = codeturna;
        editaModal.querySelector('.modal-body #codearea').value = codearea;
        editaModal.querySelector('.modal-body #codeturnedit').value = codeturn;
        editaModal.querySelector('.modal-body #turnadeleteedit').value = turnadelete;
        editaModal.querySelector('.modal-body #areanameDisplayedit').value = areaname;
        editaModal.querySelector('.modal-body #turnstartedit').value = turnstart;
        editaModal.querySelector('.modal-body #turnendedit').value = turnend;
    });
    
    editaModal.addEventListener('hidden.bs.modal', () => {
        editaModal.querySelector('.modal-body #codeturna').value = '';
        editaModal.querySelector('.modal-body #codearea').value = '';
        editaModal.querySelector('.modal-body #codeturnedit').value = '';
        editaModal.querySelector('.modal-body #turnadeleteedit').value = '0';
        editaModal.querySelector('.modal-body #areanameDisplayedit').value = '';
        editaModal.querySelector('.modal-body #turnstartedit').value = '';
        editaModal.querySelector('.modal-body #turnendedit').value = '';
    });
    
    const eliminaModal = document.getElementById('deleteAsigAreaModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codeturna = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codeturna').value = codeturna;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codeturna').value = '';
        cargarAsig(currentPage, rowsPerPage);
    });

    document.addEventListener('DOMContentLoaded', () => {
        cargarAsigArea(currentPage, rowsPerPage);
    });
</script>