<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');

$subpagina = isset($_GET['s']) ? $_GET['s'] : 'pag1&reg10';
preg_match('/pag(\d+)&reg(\d+)/', $subpagina, $matches);

$currentPage = isset($matches[1]) ? intval($matches[1]) : 1;
$rowsPerPage = isset($matches[2]) ? intval($matches[2]) : 10;
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
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addAsigBondWorkerModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Asignación
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>

    <div class="containerTable">
        <table class="table table-sm table-striped table-hover" id="tablaAsigBond">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Código Trabajador</th>
                    <th scope="col">Nombre Trabajador</th>
                    <th scope="col">Asignado Por</th>
                    <th scope="col">Código Bono</th>
                    <th scope="col">Razón del Bono</th>
                    <th scope="col">Valor del Bono</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <nav>
        <ul class="pagination justify-content-center" id="paginacion">
        </ul>
    </nav>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

<?php include 'modals/asigbondworker/addAsigBondWorkerModal.php'; ?>
<?php include 'modals/asigbondworker/editAsigBondWorkerModal.php'; ?>
<?php include 'modals/asigbondworker/deleteAsigBondWorkerModal.php'; ?>

<script>
        const tabla = document.querySelector('#tablaAsigBond tbody');
        const paginacion = document.querySelector('#paginacion');
        const buscarInput = document.querySelector('#buscar');
        const registrosPorPaginaSelect = document.querySelector('#registrosPorPagina');
        
        const urlParams = new URLSearchParams(window.location.search);
        let subpagina = urlParams.get('s') || 'pag1&reg10'; 
        let matches = subpagina.match(/pag(\d+)&reg(\d+)/);
        let currentPage = matches ? parseInt(matches[1]) : 1; 
        let rowsPerPage = matches ? parseInt(matches[2]) : parseInt(registrosPorPaginaSelect.value);

        registrosPorPaginaSelect.value = rowsPerPage;

        function updateUrlParams(page, limit) {
            const newSubpagina = `pag${page}&reg${limit}`;
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('s', newSubpagina);
            window.history.replaceState({}, '', newUrl);
        }

        registrosPorPaginaSelect.addEventListener('change', function () {
            rowsPerPage = parseInt(this.value);
            currentPage = 1; 
            updateUrlParams(currentPage, rowsPerPage); 
            cargarBond(currentPage, rowsPerPage);
        });

        async function cargarBond(pagina = 1, limite = 10) {
            const buscar = buscarInput.value;
    
            try {
                const response = await fetch(`../../routes/bondworker/getBondWorker.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
                const data = await response.json();
    
                if (!data.bondws) {
                    console.error('La respuesta no contiene datos válidos:', data);
                    return;
                }
    
                tabla.innerHTML = '';
                data.bondws.forEach(bondw => {
                    const status = bondw.bondwdelete === 0 ? 'ACTIVO' : 'INACTIVO';
                    const bondwRow = `
                        <tr>
                            <td>${bondw.codebondw}</td>
                            <td>${bondw.workercode}</td>
                            <td>${bondw.fullname}</td>
                            <td>${bondw.bondwname} ${bondw.bondwlastname}</td>
                            <td>${bondw.bondcode}</td>
                            <td>${bondw.bondreason}</td>
                            <td>${bondw.bondvalue}</td>
                            <td>${status}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAsigBondWorkerModal"
                                   data-bs-id="${bondw.codebondw}"
                                   data-bs-codeworker="${bondw.codeworker}"
                                   data-bs-codebond="${bondw.codebond}"
                                   data-bs-bondwdelete="${bondw.bondwdelete}"
                                   data-bs-fullname="${bondw.fullname}"
                                   data-bs-workercode="${bondw.workercode}"
                                   data-bs-codebondt="${bondw.codebondt}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAsigBondWorkerModal" data-bs-id="${bondw.codebondw}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
`;
                    tabla.insertAdjacentHTML('beforeend', bondwRow);
                });
    
                totalPages = data.totalPaginas;
                paginacion.innerHTML = '';
    
                const createPageItem = (page, label = page) => `
                    <li class="page-item ${pagina === page ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${page}, ${limite})">${label}</a>
                    </li>
                `;
    
                paginacion.insertAdjacentHTML('beforeend', `
                    <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${pagina - 1}, ${limite})">
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
                                    onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cambiarPagina(page, ${limite}); }" 
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
                                    onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cambiarPagina(page, ${limite}); }" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </li>
                            ${createPageItem(totalPages)}
                        `);
                    }
                }
    
                paginacion.insertAdjacentHTML('beforeend', `
                    <li class="page-item ${pagina === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="cambiarPagina(${pagina + 1}, ${limite})"><span>Next</span><i class="fas fa-angle-right"></i></a>
                    </li>
                `);
    
            } catch (error) {
                console.error('Error al cargar asignaciones de bonos:', error);
            }
        }

        function cambiarPagina(page, limit) {
            currentPage = page;
            updateUrlParams(currentPage, limit);
            cargarBond(currentPage, limit); 
        }

    const editaModal = document.getElementById('editAsigBondWorkerModal');

    editaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codebondw = button.getAttribute('data-bs-id');
        const codeworker = button.getAttribute('data-bs-codeworker');
        const codebond = button.getAttribute('data-bs-codebond');
        const bondwdelete = button.getAttribute('data-bs-bondwdelete');
        const fullname = button.getAttribute('data-bs-fullname');
        const workercode = button.getAttribute('data-bs-workercode');
        const codebondt = button.getAttribute('data-bs-codebondt');

        editaModal.querySelector('.modal-body #codebondw').value = codebondw;
        editaModal.querySelector('.modal-body #codeworker').value = codeworker;
        editaModal.querySelector('.modal-body #codebondedit').value = codebond;
        editaModal.querySelector('.modal-body #bondwdeleteedit').value = bondwdelete;
        editaModal.querySelector('.modal-body #fullnameedit').value = fullname;
        editaModal.querySelector('.modal-body #workercodeDisplayedit').value = workercode;
        editaModal.querySelector('.modal-body #codebondt').value = codebondt;
    });

    editaModal.addEventListener('hidden.bs.modal', () => {
        editaModal.querySelector('.modal-body #codebondw').value = '';
        editaModal.querySelector('.modal-body #codeworker').value = '';
        editaModal.querySelector('.modal-body #codebondedit').value = '';
        editaModal.querySelector('.modal-body #bondwdeleteedit').value = '0';
        editaModal.querySelector('.modal-body #fullname').value = '';
        editaModal.querySelector('.modal-body #workercode').value = '';
        editaModal.querySelector('.modal-body #codebondt').value = '';
    });

    const eliminaModal = document.getElementById('deleteAsigBondWorkerModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codebondw = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codebondw').value = codebondw;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codebondw').value = '';
        cargarBond(currentPage, rowsPerPage);
    });
    
    setTimeout(function() {
        const message = document.querySelector('.message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000); 
    
    buscarInput.addEventListener('input', function () {
        cargarBond(1, parseInt(registrosPorPaginaSelect.value));
    });

    document.addEventListener('DOMContentLoaded', () => {
        cargarBond(currentPage, rowsPerPage);
    });
</script>