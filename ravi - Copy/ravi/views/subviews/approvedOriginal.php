<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
<section class="containerOptions">
    <div class="inputArea">
        <label for="buscar">Buscar</label>
        <input type="text" id="buscar" class="form-control" placeholder="Por nombre o código">
    </div>
    <i class="fas fa-sync-alt refresh-icon" onclick="cargarLicencia()"></i>
</section>

<section class="bordeOrdenado">
    <strong><u>Permisos Aprobados</u></strong>
    <table class="table" id="tablaLicense">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Solicitud</th>
                <th scope="col">Trabajador</th>
                <th scope="col">Código</th>
                <th scope="col">Cargo</th>
                <th scope="col">Área</th>
            </tr>
        </thead>
        <tbody>
            <!-- Las filas se insertarán aquí dinámicamente -->
        </tbody>
    </table>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</section>

<?php include 'modals/approved/viewOrdenOutModal.php'; ?>

<script>
//Henry
function limpiarDatosFormPermiso() {
    document.getElementById('fechaPermiso').value = '';
    document.getElementById('nombreTrabajador').value = '';
    document.getElementById('cedulaTrabajador').value = '';
    document.getElementById('motivoSalida').value = '';
    document.getElementById('seccionSalida').value = '';
    document.getElementById('observacionSalida').value = '';
    document.getElementById('fechaHora').value = '';
    document.getElementById('horaInicio').value = '';
    document.getElementById('horaFin').value = '';
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaFin').value = '';
    document.getElementById('seleccionHora').classList.add('hidden');
    document.getElementById('seleccionFecha').classList.add('hidden');
}








//Diego
    const tabla = document.querySelector('#tablaLicense tbody');
    const buscarInput = document.querySelector('#buscar');
    
    document.addEventListener('DOMContentLoaded', () => {
        const viewLicenseModal = document.getElementById('viewOrdenOutModal');
    
        viewLicenseModal.addEventListener('show.bs.modal', async (event) => {
            const button = event.relatedTarget;
            const licenseId = button.getAttribute('data-bs-id');
            const codetlicense = button.getAttribute('data-bs-id1');
            const workercode = button.getAttribute('data-bs-id2');
            
            // Set hidden inputs
            document.getElementById('codetlicense').value = codetlicense;
            document.getElementById('codelicense').value = licenseId;
            document.getElementById('codeworker').value = workercode;

            if (licenseId && workercode) {
                await cargarDetallesLicencia(licenseId, workercode);
            } else {
                console.error("Datos incompletos para cargar la licencia");
            }
        });
    });
    
    async function cargarDetallesLicencia(licenseId, workercode) {
        try {
            const response = await fetch(`../routes/approved/getOrderOut.php?workercode=${encodeURIComponent(workercode)}&codelicense=${encodeURIComponent(licenseId)}`);
            
            if (!response.ok) {
                throw new Error(`Error HTTP! estado: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Datos recibidos:', data);

            if (data.success) {
                const license = data.license;
                const tipo = data.tipo;

                // Mostrar datos en consola
                console.group('Detalles de la licencia:');
                console.log('Datos completos:', license);
                console.log('Tipo de permiso:', tipo);
                console.groupEnd();
                 

                // Actualizar campos del modal
                document.getElementById('fechaPermiso').value = license.tlicenseapproved?.split(' ')[0] || ''; 
                document.getElementById('fechaHora').value = license.licensecreate?.split(' ')[0] || ''; 
                document.getElementById('nombreTrabajador').value = license.fullname || '';
                document.getElementById('cedulaTrabajador').value = license.workercode || '';
                document.getElementById('motivoSalida').value = license.licensereason || '';
                document.getElementById('observacionSalida').value = license.observacion || '';
                document.getElementById('seccionSalida').value = license.workersection || '';

                // Ocultar todas las secciones primero
                document.getElementById('seleccionHora').classList.add('hidden');
                document.getElementById('seleccionFecha').classList.add('hidden');

                if (tipo === 'hora') {
                    document.getElementById('seleccionHora').classList.remove('hidden');
                    const initParts = license.licenseinit?.split(' ') || ['', ''];
                    const endParts = license.licenseend?.split(' ') || ['', ''];
                    
                    document.getElementById('fechaHora').value = initParts[0] || '';
                    document.getElementById('horaInicio').value = initParts[1] || '';
                    document.getElementById('horaFin').value = endParts[1] || '';
                } else if (tipo === 'fechas') {
                    document.getElementById('seleccionFecha').classList.remove('hidden');
                    document.getElementById('fechaInicio').value = license.licenseinit?.split(' ')[0] || '';
                    document.getElementById('fechaFin').value = license.licenseend?.split(' ')[0] || '';
                }
            } else {
                console.error('Error en los datos:', data.error);
                alert('Error al cargar los detalles: ' + data.error);
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            alert('Error al conectar con el servidor');
        }
    }

    
    async function cargarLicencia() {
        const buscar = buscarInput.value;
        try {
            const response = await fetch(`../routes/approved/getLicense.php?buscar=${encodeURIComponent(buscar)}`);
            
            if (!response.ok) {
                throw new Error(`Error HTTP! estado: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Datos de licencias:', data);

            tabla.innerHTML = '';

            if (data.licenses && Array.isArray(data.licenses)) {
                data.licenses.forEach(license => {
                    const row = `
                        <tr>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                   data-bs-target="#viewOrdenOutModal" 
                                   data-bs-id="${license.codelicense}" 
                                   data-bs-id1="${license.codetlicense}"
                                   data-bs-id2="${license.workercode}">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            </td>
                            <td>${license.licensecreate || '----'}</td>
                            <td>${license.fullname || '----'}</td>
                            <td>${license.workercode || '----'}</td>
                            <td>${license.workerrol || '----'}</td>
                            <td>${license.workerarea || '----'}</td>
                        </tr>
                    `;
                    tabla.insertAdjacentHTML('beforeend', row);
                });
            } else {
                console.error('La respuesta no contiene datos válidos:', data);
                tabla.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>';
            }
        } catch (error) {
            console.error('Error al cargar licencias:', error);
            tabla.innerHTML = '<tr><td colspan="6" class="text-center">Error al cargar los datos</td></tr>';
        }
    }

    // Cargar licencias al inicio
    document.addEventListener('DOMContentLoaded', cargarLicencia);

    // Buscar con debounce para mejor performance
    let timeout;
    buscarInput.addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(cargarLicencia, 300);
    });
</script>