<?php
header('Content-Type: text/html; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>

<div class="modal fade" id="getLicenseModal" tabindex="-1" aria-labelledby="getLicenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Horarios de Observacion</h5>
                <div id="horariosObservacion">
                    <!-- Aqui se mostraran los horarios -->
                </div>
                <div id="licenseSection">
                    <!-- Aqu赤 se colocar芍 din芍micamente el bot車n o el mensaje de "No hay licencia" -->
                </div>
            </div>
            <div class="modal-footer">
                <form action="routes/gestion/setLicencse.php" method="post">
                    <input type="hidden" id="codeworkerHidden" name="codeworkerHidden">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const getLicenseModal = document.getElementById('getLicenseModal');
        let licenseData = null;

        getLicenseModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; 
            const codeworker = button.getAttribute('data-codeworker');
            const fecha = button.getAttribute('data-fecha');
            
            document.getElementById('codeworkerHidden').value = codeworker;
            const licenseSection = document.getElementById('licenseSection');
            
            fetch(`../routes/turn/getLicense.php?codeworker=${encodeURIComponent(codeworker)}&fecha=${encodeURIComponent(fecha)}`)
                .then(response => response.json())
                .then(data => {
                    licenseData = data;
                    
                    if (data.success && data.license) {
                        // Si hay licencia: mostrar bot車n + contenedor oculto
                        licenseSection.innerHTML = `
                            <button type="button" class="btn btn-primary" id="mostrarLicenciaBtn">
                                Mostrar Licencia
                            </button>
                            <div id="licenciaContainer" style="display: none; margin-top: 15px;"></div>
                        `;
                        
                        // Configurar evento para el bot車n
                        document.getElementById('mostrarLicenciaBtn').addEventListener('click', function() {
                            const licenciaContainer = document.getElementById('licenciaContainer');
                            const mostrarBtn = document.getElementById('mostrarLicenciaBtn');
                            
                            if (licenciaContainer.style.display === 'none') {
                                const licencia = licenseData.license;
                                licenciaContainer.innerHTML = `
                                    <h5>Licencia</h5>
                                    <p><strong>Tipo:</strong> ${licenseData.tipo || 'No especificado'}</p>
                                    <p><strong>Inicio:</strong> ${licencia.licenseinit}</p>
                                    <p><strong>Fin:</strong> ${licencia.licenseend}</p>
                                    <p><strong>Descripcion:</strong> ${licencia.licensereason}</p>
                                `;
                                licenciaContainer.style.display = 'block';
                                mostrarBtn.textContent = 'Ocultar Licencia';
                            } else {
                                licenciaContainer.style.display = 'none';
                                mostrarBtn.textContent = 'Mostrar Licencia';
                            }
                        });
                    } else {
                        // Si NO hay licencia: mostrar directamente el mensaje
                        licenseSection.innerHTML = '<p>No hay licencia registrada para esta fecha.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener la licencia:', error);
                    licenseSection.innerHTML = '<p>Error al cargar la informaci車n de licencia.</p>';
                });
        });
    });
</script>