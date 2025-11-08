<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');

$subpagina = isset($_GET['s']) ? $_GET['s'] : 'pag1&reg10';
preg_match('/pag(\d+)&reg(\d+)/', $subpagina, $matches);

$currentPage = isset($matches[1]) ? intval($matches[1]) : 1;
$rowsPerPage = isset($matches[2]) ? intval($matches[2]) : 10;
?>
    <section class="containerOptions">
        <div class="inputArea">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Por código o razón">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Numero de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addBondModal">
            <i class="fa-solid fa-circle-plus"></i> Nuevo Bono
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>

<div class="containerTable">
    <!-- Tabla de bond -->
    <table class="table table-sm table-striped table-hover" id="tablaBond">
        <thead class="table-dark">
            <tr>
                <th scope="col">Fecha de Creación</th>
                <th scope="col">Código</th>
                <th scope="col">Razón</th>
                <th scope="col">Valor</th>
                <th scope="col">Número</th>
                <th scope="col">Tarifa</th>
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

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>

<?php include 'modals/bond/addBondModal.php'; ?>
<?php include 'modals/bond/deleteBondModal.php'; ?>
<?php include 'modals/bond/editBondModal.php'; ?>

<script>
       const tabla = document.querySelector('#tablaBond tbody');
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

    // Función para cargar los bonos
    async function cargarBond(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;

        try {
            const response = await fetch(`../../routes/bond/getBond.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';
            data.bonds.forEach(bond => {
                const status = bond.bondelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const bondRow = `
                    <tr>
                        <td>${bond.fecha}</td>
                        <td>${bond.bondcode}</td>
                        <td>${bond.bondreason}</td>
                        <td>${bond.bondvalue}</td>
                        <td>${bond.bondnro}</td>
                        <td>${bond.bondfee}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBondModal" data-bs-id="${bond.codebond}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBondModal" data-bs-id="${bond.codebond}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tabla.insertAdjacentHTML('beforeend', bondRow);
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
            console.error('Error al cargar bonds:', error);
        }
    }
    
    function cambiarPagina(page, limit) {
        currentPage = page;
        updateUrlParams(currentPage, limit); 
        cargarBond(currentPage, limit); 
    }

    const eliminaModal = document.getElementById('deleteBondModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codebond = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codebond').value = codebond;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codebond').value = '';
        cargarBond(currentPage, rowsPerPage);
    });
    
    let editaModal = document.getElementById('editBondModal');
    
    editaModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let codebond = button.getAttribute('data-bs-id');
    
        let inputCodebond = editaModal.querySelector('.modal-body #codebond');
        let inputBondcode = editaModal.querySelector('.modal-body #bondcode');
        let inputBondreason = editaModal.querySelector('.modal-body #bondreason');
        let inputBondvalue = editaModal.querySelector('.modal-body #bondvalue');
        let inputBondnro = editaModal.querySelector('.modal-body #bondnro');
        let inputBondfee = editaModal.querySelector('.modal-body #bondfee');
        let inputBondelete = editaModal.querySelector('.modal-body #bondelete');
        let statusLabel = editaModal.querySelector('.modal-body #statusLabel');
    
        let url = '../../routes/bond/getBondModal.php';
        let formData = new FormData();
        formData.append('codebond', codebond);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            inputCodebond.value = data.codebond;
            inputBondcode.value = data.bondcode;
            inputBondreason.value = data.bondreason;
            inputBondvalue.value = data.bondvalue;
            inputBondnro.value = data.bondnro;
            inputBondfee.value = data.bondfee;
            inputBondelete.checked = data.bondelete === 1; 
            statusLabel.textContent = data.bondelete === 1 ? "INACTIVO" : "ACTIVO";
        })
        .catch(err => console.error('Error al obtener los datos del bond:', err));
    });
    
    editaModal.addEventListener('hidden.bs.modal', () => {
        editaModal.querySelector('.modal-body #codebond').value = '';
        editaModal.querySelector('.modal-body #bondcode').value = '';
        editaModal.querySelector('.modal-body #bondreason').value = '';
        editaModal.querySelector('.modal-body #bondvalue').value = '';
        editaModal.querySelector('.modal-body #bondnro').value = '';
        editaModal.querySelector('.modal-body #bondfee').value = '';
        editaModal.querySelector('.modal-body #bondelete').checked = false;
        editaModal.querySelector('.modal-body #statusLabel').textContent = 'ACTIVO';
    });
    
    let addModal = document.getElementById('addBondModal');
    
    addModal.addEventListener('shown.bs.modal', event => {
        addModal.querySelector('.modal-body #bondcode').focus()
    })

    addModal.addEventListener('hidden.bs.modal', event => {
        addModal.querySelector('.modal-body #bondcode').value = ""
    })
        
    setTimeout(function() {
        const message = document.querySelector('.message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000); // 5000 ms = 5 segundos

    // Llamada para ejecutar la consulta del input busqueda
    buscarInput.addEventListener('input', function () {
        cargarBond(1, parseInt(registrosPorPaginaSelect.value));
    });

    document.addEventListener('DOMContentLoaded', () => cargarBond(currentPage, rowsPerPage));
</script>