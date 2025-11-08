<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
    <h2 class="titulogestion">Vista Area</h2>
    <!-- Barra de busqueda -->
    <section class="containerOptions">
        <div class="inputArea">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Por nombre o codigo">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Numero de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addAreaModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Area
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>
    



<div class="containerTable">
    <!-- Tabla de area -->
    <table class="table table-sm table-striped table-hover" id="tablaArea">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Area</th>
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
    <script src="../../assets/js/scriptRecursive.js"></script>
</body>

<?php include 'modals/area/addAreaModal.php'; ?>
<?php include 'modals/area/deleteAreaModal.php'; ?>
<?php include 'modals/area/editAreaModal.php'; ?>

<script>
    const tabla = document.querySelector('#tablaArea tbody');
    const paginacion = document.querySelector('#paginacion');
    const buscarInput = document.querySelector('#buscar');
    const registrosPorPaginaSelect = document.querySelector('#registrosPorPagina');
    let currentPage = 1;
    let rowsPerPage = parseInt(registrosPorPaginaSelect.value);
    let totalPages = 1;

    registrosPorPaginaSelect.addEventListener('change', function () {
        rowsPerPage = parseInt(this.value);
        currentPage = 1; // reset to the first page
        cargarArea(currentPage, rowsPerPage);
    });

    async function cargarArea(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;

        try {
            const response = await fetch(`../../routes/area/getarea.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';
            data.areas.forEach(area => {
                const status = area.areadelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const areaRow = `
                    <tr>
                        <td>${area.codearea}</td>
                        <td>${area.areaname}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAreaModal" data-bs-id="${area.codearea}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAreaModal" data-bs-id="${area.codearea}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tabla.insertAdjacentHTML('beforeend', areaRow);
            });

            totalPages = data.totalPaginas;
            paginacion.innerHTML = '';

            const createPageItem = (page, label = page) => `
                <li class="page-item ${pagina === page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="cargarArea(${page}, ${limite})">${label}</a>
                </li>
            `;

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarArea(${pagina - 1}, ${limite})">
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
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarArea(page, ${limite}); }" 
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
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarArea(page, ${limite}); }" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </li>
                        ${createPageItem(totalPages)}
                    `);
                }
            }

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarArea(${pagina + 1}, ${limite})"><span>Next</span><i class="fas fa-angle-right"></i></a>
                </li>
            `);

        } catch (error) {
            console.error('Error al cargar areas:', error);
        }
    }

    const eliminaModal = document.getElementById('deleteAreaModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codearea = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codearea').value = codearea;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codearea').value = '';
        cargarArea(currentPage, rowsPerPage);
    });
    
    
    let editaModal = document.getElementById('editAreaModal');
    
    editaModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let codearea = button.getAttribute('data-bs-id');
    
        let inputCodearea = editaModal.querySelector('.modal-body #codearea');
        let inputAreaname = editaModal.querySelector('.modal-body #areaname');
        let inputAreadelete = editaModal.querySelector('.modal-body #areadelete');
        let statusLabel = editaModal.querySelector('.modal-body #statusLabel');
    
        let url = '../../routes/area/getAreaModal.php';
        let formData = new FormData();
        formData.append('codearea', codearea);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            inputCodearea.value = data.codearea;
            inputAreaname.value = data.areaname;
            inputAreadelete.checked = data.areadelete === 1; 
            statusLabel.textContent = data.areadelete === 1 ? "INACTIVO" : "ACTIVO";
        })
        .catch(err => console.error('Error al obtener los datos del área:', err));
    });
    
    editaModal.addEventListener('hidden.bs.modal', () => {
        editaModal.querySelector('.modal-body #codearea').value = '';
        editaModal.querySelector('.modal-body #areaname').value = '';
        editaModal.querySelector('.modal-body #areadelete').checked = false;
        editaModal.querySelector('.modal-body #statusLabel').textContent = 'ACTIVO';
    });
    
    let addModal = document.getElementById('addAreaModal');
    
    addModal.addEventListener('shown.bs.modal', event => {
        addModal.querySelector('.modal-body #areaname').focus()
    })

    addModal.addEventListener('hidden.bs.modal', event => {
        addModal.querySelector('.modal-body #areaname').value = ""
    })
        
    setTimeout(function() {
        const message = document.querySelector('.message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000); // 5000 ms = 5 segundos

    // Llamada para ejecutar la consulta del input busqueda
    buscarInput.addEventListener('input', function () {
        cargarArea(1, parseInt(registrosPorPaginaSelect.value));
    });

    document.addEventListener('DOMContentLoaded', () => cargarArea(currentPage, rowsPerPage));
</script>

