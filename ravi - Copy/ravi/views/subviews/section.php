
   <h2 class="titulogestion">Vista Secciones</h2>
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
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addSectionModal">
            <i class="fa-solid fa-circle-plus"></i> Nueva Seccion
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>


<div class="containerTable">
        <!-- Tabla de area -->
    <table class="table table-sm table-striped table-hover" id="tablaSection">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Seccion</th>
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

<?php include 'modals/section/addSectionModal.php'; ?>
<?php include 'modals/section/deleteSectionModal.php'; ?>
<?php include 'modals/section/editSectionModal.php'; ?>

<script>
const tabla = document.querySelector('#tablaSection tbody');
const paginacion = document.querySelector('#paginacion');
const buscarInput = document.querySelector('#buscar');
const registrosPorPaginaSelect = document.querySelector('#registrosPorPagina');
let currentPage = 1;
let rowsPerPage = parseInt(registrosPorPaginaSelect.value);
let totalPages = 1;

registrosPorPaginaSelect.addEventListener('change', function () {
    rowsPerPage = parseInt(this.value);
    currentPage = 1; // reset to the first page
    cargarSection(currentPage, rowsPerPage);
});

async function cargarSection(pagina = 1, limite = 10) {
    const buscar = buscarInput.value;

    try {
        const response = await fetch(`../../routes/section/getsection.php?pagina=${pagina}&limite=${limite}&buscar=${buscar}`);
        const data = await response.json();

        tabla.innerHTML = '';
        data.sections.forEach(section => {
            const status = section.sectiondelete === 0 ? 'ACTIVO' : 'INACTIVO';
            const sectionRow = `
                <tr>
                    <td>${section.codesection}</td>
                    <td>${section.namesection}</td>
                    <td>${status}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSectionModal" data-bs-id="${section.codesection}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSectionModal" data-bs-id="${section.codesection}">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;
            tabla.insertAdjacentHTML('beforeend', sectionRow);
        });

        totalPages = data.totalPaginas;
        paginacion.innerHTML = '';

        const createPageItem = (page, label = page) => `
            <li class="page-item ${pagina === page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="cargarSection(${page}, ${limite})">${label}</a>
            </li>
        `;

        paginacion.insertAdjacentHTML('beforeend', `
            <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="cargarSection(${pagina - 1}, ${limite})">
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
                            onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarSection(page, ${limite}); }" 
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
                            onkeydown="if(event.key === 'Enter') { let page = parseInt(this.value); if (page > totalPages) { page = totalPages; } cargarSection(page, ${limite}); }" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </li>
                    ${createPageItem(totalPages)}
                `);
            }
        }

        paginacion.insertAdjacentHTML('beforeend', `
            <li class="page-item ${pagina === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="cargarSection(${pagina + 1}, ${limite})"><span>Next</span><i class="fas fa-angle-right"></i></a>
            </li>
        `);

    } catch (error) {
        console.error('Error al cargar areas:', error);
    }
}
    const eliminaModal = document.getElementById('deleteSectionModal');
    eliminaModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codesection = button.getAttribute('data-bs-id');
        eliminaModal.querySelector('.modal-footer #codesection').value = codesection;
    });

    eliminaModal.addEventListener('hidden.bs.modal', () => {
        eliminaModal.querySelector('.modal-footer #codesection').value = '';
        cargarSection(currentPage, rowsPerPage);
    });
    
    let editSectionModal = document.getElementById('editSectionModal');

    editSectionModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let codesection = button.getAttribute('data-bs-id');
    
        let inputCodesection = editSectionModal.querySelector('.modal-body #codesection');
        let inputNamesection = editSectionModal.querySelector('.modal-body #namesection');
        let inputSectiondelete = editSectionModal.querySelector('.modal-body #sectiondelete');
        let statusLabel = editSectionModal.querySelector('.modal-body #statusLabel');
    
        let url = '../../routes/section/getSectionModal.php';
        let formData = new FormData();
        formData.append('codesection', codesection);
    
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            inputCodesection.value = data.codesection;
            inputNamesection.value = data.namesection;
            inputSectiondelete.checked = data.sectiondelete === 1;
            statusLabel.textContent = data.sectiondelete === 1 ? "INACTIVO" : "ACTIVO";
        })
        .catch(err => console.error('Error al obtener los datos de la sección:', err));
    });
    
    editSectionModal.addEventListener('hidden.bs.modal', () => {
        editSectionModal.querySelector('.modal-body #codesection').value = '';
        editSectionModal.querySelector('.modal-body #namesection').value = '';
        editSectionModal.querySelector('.modal-body #sectiondelete').checked = false;
        editSectionModal.querySelector('.modal-body #statusLabel').textContent = 'ACTIVO';
    });
    
    let addModal = document.getElementById('addSectionModal');
    
    addModal.addEventListener('shown.bs.modal', event => {
        addModal.querySelector('.modal-body #namesection').focus()
    })

    addModal.addEventListener('hidden.bs.modal', event => {
        addModal.querySelector('.modal-body #namesection').value = ""
    })

    setTimeout(function() {
            const message = document.querySelector('.message');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000); // 5000 ms = 5 segundos
    
    // Llamada para ejecutar la consulta del input busqueda
    buscarInput.addEventListener('input', function () {
        cargarSection(1, parseInt(registrosPorPaginaSelect.value));
    });

document.addEventListener('DOMContentLoaded', () => cargarSection(currentPage, rowsPerPage));
</script>