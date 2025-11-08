<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
<body>
<h2 class="titulogestion">Asistencias</h2>
<section class="containerOptions">
    <div class="inputArea">
        <label for="buscar">Buscar</label>
        <input type="text" id="buscar" class="form-control" placeholder="Por nombre o c¨®digo">
    </div>
    <i class="fas fa-sync-alt refresh-icon" onclick="cargarLicencia()"></i>
</section>

<section class="bordeOrdenado">
    <strong><u>Permisos Pendientes de Aprobacion</u></strong>
    <table class="table" id="tablaLicense">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Solicitud</th>
                <th scope="col">Trabajador</th>
                <th scope="col">Codigo</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
            </tr>
        </thead>
        <tbody>
            <!-- Las filas se insertar¨¢n aqu¨ª din¨¢micamente -->
        </tbody>
    </table>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary" type="button">Aprobar o Rechazar de forma Masiva</button>
    </div>
</section>

<section class="bordeOrdenado">
    <strong><u>Memorandums Pendientes de Aprobacion</u></strong>
    <table class="table" id="tablaMemorandums">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Solicitud</th>
                <th scope="col">Trabajador</th>
                <th scope="col">Codigo</th>
                <th scope="col">Cargo</th>
                <th scope="col">Area</th>
                <th scope="col">Modelo</th>
                <th scope="col">Solicitante</th>
                <th scope="col">Solicitud</th>
            </tr>
        </thead>
        <tbody>
            <!-- Las filas se insertar¨¢n aqu¨ª din¨¢micamente -->
        </tbody>
    </table>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary" type="button">Aprobar o Rechazar de forma Masiva</button>
    </div>
    
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</section>

<?php include 'modals/license/viewLicenseModal.php'; ?>

<script>
    const tabla = document.querySelector('#tablaLicense tbody');
    const buscarInput = document.querySelector('#buscar');
    
    document.addEventListener('DOMContentLoaded', () => {
        const viewLicenseModal = document.getElementById('viewLicenseModal');
    
        viewLicenseModal.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const licenseId = button.getAttribute('data-bs-id');
            const code = button.getAttribute('data-bs-id1');
            
            let inputCodetlicense= viewLicenseModal.querySelector('.modal-footer #codetlicense');
            inputCodetlicense.value = code;
            console.log("ID de la licencia:", licenseId); 
            console.log("ID de la licencia:", code); 
    
            if (licenseId) {
                await cargarDetallesLicencia(licenseId);
            } else {
                console.error("ID de la licencia no encontrado");
            }
        });
    });
    
   async function cargarDetallesLicencia(licenseId) {
        try {
            const response = await fetch(`../routes/license/getLicenseDetails.php?id=${licenseId}`);
            const data = await response.json();
    
            if (data.success) {
                const license = data.license;
                const tipo = data.tipo;
    
                // Get the elements first
                const seleccionHora = document.getElementById('seleccionHora');
                const seleccionFecha = document.getElementById('seleccionFecha');
                
                // Make sure elements exist before manipulating them
                if (!seleccionHora || !seleccionFecha) {
                    console.error('Required elements not found in the DOM');
                    return;
                }
    
                document.getElementById('fechaPermiso').value = license.licensecreate.split(' ')[0]; 
                document.getElementById('nombreTrabajador').value = license.fullname;
                document.getElementById('cedulaTrabajador').value = license.workercode;
                document.getElementById('motivoSalida').value = license.licensereason;
    
                // Hide both sections first
                seleccionHora.classList.add('hidden');
                seleccionFecha.classList.add('hidden');
    
                if (tipo === 'hora') {
                    seleccionHora.classList.remove('hidden');
                    
                    document.getElementById('fechaHora').value = license.licenseinit.split(' ')[0];
                    document.getElementById('horaInicio').value = license.licenseinit.split(' ')[1];
                    document.getElementById('horaFin').value = license.licenseend.split(' ')[1];
                } else if (tipo === 'fechas') {
                    seleccionFecha.classList.remove('hidden');
    
                    document.getElementById('fechaInicio').value = license.licenseinit.split(' ')[0];
                    document.getElementById('fechaFin').value = license.licenseend.split(' ')[0];
                }
            } else {
                console.error('Error al cargar los detalles de la licencia:', data.message);
            }
        } catch (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    }

    async function cargarLicencia() {
        const buscar = buscarInput.value;
        try {
            const response = await fetch(`../routes/management/getLicense.php?buscar=${buscar}`);
            const data = await response.json();

            tabla.innerHTML = '';

            if (data.licenses && Array.isArray(data.licenses)) {
                data.licenses.forEach(license => {
                    const row = `
                        <tr>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#viewLicenseModal" data-bs-id="${license.codelicense}" data-bs-id1="${license.codetlicense}">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            </td>
                            
                            <td>${license.licensecreate}</td>
                            <td>${license.fullname}</td>
                            <td>${license.workercode}</td>
                            <td>${license.workerrol|| '----'}</td>
                            <td>${license.workerarea|| '----'}</td>
                        </tr>
                    `;
                    tabla.insertAdjacentHTML('beforeend', row);
                });
            } else {
                console.error('La respuesta no contiene datos v¨¢lidos:', data);
            }
        } catch (error) {
            console.error('Error al cargar licencias:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', cargarLicencia);

    buscarInput.addEventListener('input', cargarLicencia);
</script>
</body>