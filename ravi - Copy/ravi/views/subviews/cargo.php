
  <h2 class="titulogestion">Vista Ocupación</h2>
    <!-- Barra de busqueda -->
    <section class="containerOptions">
        <div class="inputArea">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Por nombre o código">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Número de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addOcupationModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Ocupación
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>
    


<div class="containerTable">
    <!-- Tabla de ocupación -->
    <table class="table table-sm table-striped table-hover" id="tablaOcupation">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ocupación</th>
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
    
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scriptRecursive.js"></script>
</body>

<?php include 'modals/ocupation/addOcupationModal.php';?>
<?php include 'modals/ocupation/deleteOccupationModal.php';?>
<?php include 'modals/ocupation/editOccupationModal.php';?>

<script>
    const tabla = document.querySelector('#tablaOcupation tbody');
    const paginacion = document.querySelector('#paginacion');
    const buscarInput = document.querySelector('#buscar');
    const registrosPorPaginaSelect = document.querySelector('#registrosPorPagina');
    let currentPage = 1;
    let rowsPerPage = parseInt(registrosPorPaginaSelect.value);
    let totalPages = 1;

    registrosPorPaginaSelect.addEventListener('change', function () {
        rowsPerPage = parseInt(this.value);
        currentPage = 1; // reset to the first page
        cargarOcupation(currentPage, rowsPerPage);
    });

    async function cargarOcupation(pagina = 1, limite = 10) {
        const buscar = buscarInput.value;

        try {
            const response = await fetch(`../../routes/ocupation/getocupation.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';
            data.occupations.forEach(ocupation => {
                const status = ocupation.occupationdelete === 0 ? 'ACTIVO' : 'INACTIVO';
                const ocupationRow = `
                    <tr>
                        <td>${ocupation.codeoccupation}</td>
                        <td>${ocupation.nameoccupation}</td>
                        <td>${status}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editOccupationModal" data-bs-id="${ocupation.codeoccupation}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOccupationModal" data-bs-id="${ocupation.codeoccupation}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tabla.insertAdjacentHTML('beforeend', ocupationRow);
            });

            totalPages = data.totalPaginas;
            paginacion.innerHTML = '';

            const createPageItem = (page, label = page) => `
                <li class="page-item ${pagina === page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="cargarOcupation(${page}, ${limite})">${label}</a>
                </li>
            `;

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarOcupation(${pagina - 1}, ${limite})">
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
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarOcupation(page, ${limite}); }" 
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
                                onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarOcupation(page, ${limite}); }" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </li>
                        ${createPageItem(totalPages)}
                    `);
                }
            }

            paginacion.insertAdjacentHTML('beforeend', `
                <li class="page-item ${pagina === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="cargarOcupation(${pagina + 1}, ${limite})"><span>Next</span><i class="fas fa-angle-right"></i></a>
                </li>
            `);

        } catch (error) {
            console.error('Error al cargar ocupaciones:', error);
        }
    }

    const eliminaModal = document.getElementById('deleteOccupationModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codeoccupation = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codeoccupation').value = codeoccupation;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codeoccupation').value = '';
        cargarOcupation(currentPage, rowsPerPage);
    });
    
    let editOccupationModal = document.getElementById('editOccupationModal');
    
    editOccupationModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let codeoccupation = button.getAttribute('data-bs-id');
    
        let inputCodeoccupation = editOccupationModal.querySelector('.modal-body #codeoccupation');
        let inputNameoccupation = editOccupationModal.querySelector('.modal-body #nameoccupation');
        let inputOccupationdelete = editOccupationModal.querySelector('.modal-body #occupationdelete');
        let statusLabel = editOccupationModal.querySelector('.modal-body #statusLabel');
    
        let url = '../../routes/ocupation/getOcupationModal.php';
        let formData = new FormData();
        formData.append('codeoccupation', codeoccupation);
    
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            inputCodeoccupation.value = data.codeoccupation;
            inputNameoccupation.value = data.nameoccupation;
            inputOccupationdelete.checked = data.occupationdelete === 1; 
            statusLabel.textContent = data.occupationdelete === 1 ? "INACTIVO" : "ACTIVO";
        })
        .catch(err => console.error('Error al obtener los datos de la ocupación:', err));
    });
    
    editOccupationModal.addEventListener('hidden.bs.modal', () => {
        editOccupationModal.querySelector('.modal-body #codeoccupation').value = '';
        editOccupationModal.querySelector('.modal-body #nameoccupation').value = '';
        editOccupationModal.querySelector('.modal-body #occupationdelete').checked = false;
        editOccupationModal.querySelector('.modal-body #statusLabel').textContent = 'ACTIVO';
    });
    
    let addModal = document.getElementById('addOcupationModal');
    
    addModal.addEventListener('shown.bs.modal', event => {
        addModal.querySelector('.modal-body #nameoccupation').focus()
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
        cargarOcupation(1, parseInt(registrosPorPaginaSelect.value));
    });

    document.addEventListener('DOMContentLoaded', () => cargarOcupation(currentPage, rowsPerPage));
</script>