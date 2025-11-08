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
            <input type="text" id="buscar" class="form-control" placeholder="Nombre de turno o asignado por">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">N√∫mero de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addAsigBondTurnModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Asignaci√≥n
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>

    <div class="containerTable">
        <table class="table table-sm table-striped table-hover" id="tablaAsigBond">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Horario</th>
                    <th scope="col">Asignado Por</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Codigo Bono</th>
                    <th scope="col">Valor del Bono</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Paginaci®Æn -->
    <nav>
        <ul class="pagination justify-content-center" id="paginacion">
        </ul>
    </nav>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

<?php include 'modals/asigbondturn/addAsigBondTurnModal.php'; ?>
<?php include 'modals/asigbondturn/editAsigBondTurnModal.php'; ?>
<?php include 'modals/asigbondturn/deleteAsigBondTurnModal.php'; ?>

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
        cargarBondTurn(currentPage, rowsPerPage);
    });

    async function cargarBondTurn(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;
    
        try {
            const response = await fetch(`../../routes/bondturn/getAsigTurnBond.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();
    
            if (!data.bondts) {
                console.error('La respuesta no contiene datos v√°lidos:', data);
                return;
            }
    
            tabla.innerHTML = '';
            data.bondts.forEach(bondt => {
                const status = bondt.bondtdelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const turnSchedule = `${bondt.turnstart} - ${bondt.turnend}`;
                const bondtRow = `
                    <tr>
                        <td>${bondt.fecha}</td>
                        <td>${bondt.turnname}</td>
                        <td>${turnSchedule}</td>
                        <td>${bondt.fullname}</td>
                        <td>${bondt.bondreason}</td>
                        <td>${bondt.bondcode}</td>
                        <td>${bondt.bondvalue}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAsigBondTurnModal"
                               data-bs-id="${bondt.codebondt}"
                               data-bs-codeturn="${bondt.codeturn}"
                               data-bs-codebond="${bondt.codebond}"
                               data-bs-bondtdelete="${bondt.bondtdelete}"
                               data-bs-turnname="${bondt.turnname}"
                               data-bs-turnstart="${bondt.turnstart}"
                               data-bs-turnend="${bondt.turnend}"
                               data-bs-bondstart="${bondt.bondstart}"
                               data-bs-bondend="${bondt.bondend}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAsigBondTurnModal" data-bs-id="${bondt.codebondt}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tabla.insertAdjacentHTML('beforeend', bondtRow);
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
            console.error('Error al cargar asignaciones de bonos a turnos:', error);
        }
    }

    function cambiarPagina(page, limit) {
        currentPage = page;
        updateUrlParams(currentPage, limit);
        cargarBondTurn(currentPage, limit); 
    }

    const editaModal = document.getElementById('editAsigBondTurnModal');

    editaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codebondt = button.getAttribute('data-bs-id');
        const codeturn = button.getAttribute('data-bs-codeturn');
        const codebond = button.getAttribute('data-bs-codebond');
        const bondtdelete = button.getAttribute('data-bs-bondtdelete');
        const turnname = button.getAttribute('data-bs-turnname');
        const turnstart = button.getAttribute('data-bs-turnstart');
        const turnend = button.getAttribute('data-bs-turnend');
        const bondstart = button.getAttribute('data-bs-bondstart');
        const bondend = button.getAttribute('data-bs-bondend');

        editaModal.querySelector('.modal-body #codebondt').value = codebondt;
        editaModal.querySelector('.modal-body #codeturn').value = codeturn;
        editaModal.querySelector('.modal-body #codebond').value = codebond;
        editaModal.querySelector('.modal-body #bondtdelete').value = bondtdelete;
        editaModal.querySelector('.modal-body #turnname').value = turnname;
        editaModal.querySelector('.modal-body #turnstart').value = turnstart;
        editaModal.querySelector('.modal-body #turnend').value = turnend;
        editaModal.querySelector('.modal-body #bondstart').value = bondstart;
        editaModal.querySelector('.modal-body #bondend').value = bondend;
    });

    editaModal.addEventListener('hidden.bs.modal', () => {
        editaModal.querySelector('.modal-body #codebondt').value = '';
        editaModal.querySelector('.modal-body #codeturn').value = '';
        editaModal.querySelector('.modal-body #codebond').value = '';
        editaModal.querySelector('.modal-body #bondtdelete').value = '0';
        editaModal.querySelector('.modal-body #turnname').value = '';
        editaModal.querySelector('.modal-body #turnstart').value = '';
        editaModal.querySelector('.modal-body #turnend').value = '';
        editaModal.querySelector('.modal-body #bondstart').value = '';
        editaModal.querySelector('.modal-body #bondend').value = '';
    });

    const eliminaModal = document.getElementById('deleteAsigBondTurnModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codebondt = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codebondt').value = codebondt;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codebondt').value = '';
        cargarBondTurn(currentPage, rowsPerPage);
    });
    
    setTimeout(function() {
        const message = document.querySelector('.message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000); 
    
    buscarInput.addEventListener('input', function () {
        cargarBondTurn(1, parseInt(registrosPorPaginaSelect.value));
    });

    document.addEventListener('DOMContentLoaded', () => {
        cargarBondTurn(currentPage, rowsPerPage);
    });
</script>