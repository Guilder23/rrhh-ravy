<div class="modal fade" id="workerview" tabindex="-1" aria-labelledby="workerviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerviewLabel">Información del Colaborador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body cuerpoViewWorkers">

             <div class="containerPestanas">
                <button class="pestania3 activar" onclick="seenPestana('infPersonal')">Inf. Personal</button>
                <button class="pestania3" onclick="seenPestana('infLaboral')">Inf. Laboral</button>
                <button class="pestania3" onclick="seenPestana('infOtros')">Inf. Otros</button>
            </div>

                <div class="container">
                    <!-- Información personal -->
                    <div class="section" id="infPersonal">
                        <div class="section-title">INFORMACIÓN PERSONAL</div>
                        <div class="personal-info">
                            <!-- Tabla de datos personales -->
                            <table class="table" id="personal-info-table">
                                <tr>
                                  <div class="containerFirstView">
                                    <div style="display:flex; flex-direction:column; gap:10px;">
                                        <div class="elemView2">
                                            <b>Primer Nombre:</b>
                                            <span style="max-width:200px;" id="worker_name1"></span>
                                        </div>
                                        <div class="elemView2">
                                            <b>Segundo Nombre:</b>
                                            <span id="worker_name2"></span>
                                        </div>
                                    </div>
                                    <!-- Imagen del colaborador -->
                                    <img src="/resource/images/foto-perfil-hombre.avif" alt="Fotografía" class="photo imgWorkerView" id="worker-photo">
                                   </div>
                                </tr>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                          <b>Primer Apellido:</b>
                                            <span id="worker_lastname1"></span>
                                        </div>
                           
                               
                                         <div class="elemView">
                                          <b>Segundo Apellido:</b>
                                            <span id="worker_lastname2"></span>
                                        </div>
                                    </div>
                                 
                                </tr>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                           <b>Documento de identidad:</b>
                                            <span id="worker-doc-id"></span>
                                        </div>
                                    
                                        <div class="elemView">
                                            <b>Fecha de nacimiento:</b>
                                            <span id="worker-birthday"></span>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                            <b>Sexo:</b>
                                            <span id="worker-gender"></span>
                                        </div>
                                        
                                        <div class="elemView">
                                        <b>Estado civil:</b>
                                            <span id="worker-civil-status"></span>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                            <b>Ciudad o Provincia:</b>
                                            <span id="worker-bol-nat"></span>
                                        </div>
                                        <div class="elemView">
                                            <b>Nacionalidad:</b>
                                            <span id="worker-nat"></span>
                                        </div>
                                    </div>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                            <b>NIT:</b>
                                            <span id="worker-nit"></span>
                                        </div>
                                        
                                        <div class="elemView">
                                            <b>Cuenta de Banco Principal:</b>
                                            <span id="worker-banknum"></span>
                                        </div>
                                    </div>
                                </tr>
                                </tr>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                            <b>Licencia conducir:</b>
                                            <span id="worker-license"></span>
                                        </div>
                                        
                                        <div class="elemView">
                                            <b>Teléfono móvil:</b>
                                            <span id="worker-mobile"></span>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="filaElem">
                                        <div class="elemView">
                                            <b>Otro teléfono:</b>
                                            <span id="worker-phone"></span>
                                        </div>
                                        <div class="elemView">
                                            <b>Dirección:</b>
                                            <span id="worker-address"></span>
                                        </div>
                                    </div>
                                </tr>
                            </table>
                        </div>
                    </div>
                

                    <!-- Información laboral -->
                    <div class="section"  id="infLaboral" style="display:none">
                        <div class="section-title">INFORMACIÓN LABORAL</div>
                        <table class="table">
                            <tr>
                                <div class="filaElem">
                                    <div class="elemView">
                                    <b>Inicio del Contrato:</b>
                                        <span id="start-date"></span>
                                    </div>
                                     <div class="elemView">
                                    <b>Fin del Contrato:</b>
                                        <span id="end-date"></span>
                                    </div>
                                </div>
                            </tr>
                            <!-- En la sección de Información Laboral del modal -->
                            <tr>
                                <div class="filaElem">
                                    <div class="elemView">
                                        <b>Área:</b>
                                        <select id="department" class="form-control form-control-sm" disabled>
                                            <option value="">Cargando áreas...</option>
                                        </select>
                                    </div>
                                    <div class="elemView">
                                        <b>Rol:</b>
                                        <select id="role" class="form-control form-control-sm" disabled>
                                            <option value="">Cargando roles...</option>
                                        </select>
                                        <i class="fas fa-edit edit-icon" data-field="role"></i>
                                    </div>
                                    <div class="elemView">
                                        <b>Seccion:</b>
                                        <select id="section" class="form-control form-control-sm" disabled>
                                            <option value="">Cargando secciones...</option>
                                        </select>
                                        <i class="fas fa-edit edit-icon" data-field="section"></i>
                                    </div>
                                </div>
                            </tr>
                        </table>
                    </div>



                    
                    <!-- Sección de cuentas bancarias secundarias -->
            <div class="section" id="infOtros" style="display:none">
                    <div class="section">
                        <div class="section-title">CUENTAS BANCARIAS</div>

                        <table class="table" id="bank-accounts-table">
                            <tbody id="bank-accounts-body">
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Sección de Familiares -->
                    <div class="section">
                        <div class="section-title">FAMILIARES</div>
                        <table class="table" id="family-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Sexo</th>
                                    <th>Edad</th>
                                    <th>Parentesco</th>
                                </tr>
                            </thead>
                            <tbody id="family-body">

                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Sección de Turnos -->
                    <div class="section">
                        <div class="section-title">TURNOS</div>
                        <table class="table" id="turnw-table">
                            <thead>
                                <tr>
                                    <th>Nombre del Turno</th>
                                    <th>Hora de Inicio</th>
                                    <th>Hora de Fin</th>
                                </tr>
                            </thead>
                            <tbody id="turnw-body">
                                
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Sección de Documentos -->
                    <div class="section">
                        <div class="section-title">DOCUMENTOS</div>
                        <table class="table" id="document-table">
                            <thead>
                                <tr>
                                    <th>Grado de formacion</th>
                                    <th>Título</th>
                                    <th>Certificado</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="documentWorker-body">
                                
                            </tbody>
                        </table>
                    </div>
                    
        </div>





            </div> <!--fin cuerpoViewWorkers -->
            <!-- Pie del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
  function seenPestana(idMostrar) {
    const secciones = ['infPersonal', 'infLaboral', 'infOtros'];
    const botones = document.querySelectorAll('.pestania3');
    
    // Ocultar/mostrar secciones y actualizar clases de botones
    secciones.forEach((id, index) => {
        // Mostrar/ocultar sección
        document.getElementById(id).style.display = (id === idMostrar) ? 'block' : 'none';
        
        // Actualizar clase del botón correspondiente
        if (id === idMostrar) {
            botones[index].classList.add('activar');
        } else {
            botones[index].classList.remove('activar');
        }
    });
}



    function updateTurnTimes(selectElement, workShiftId) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const startTime = selectedOption.getAttribute('data-start');
        const endTime = selectedOption.getAttribute('data-end');
        
        const row = selectElement.closest('tr');
        row.querySelector('.turn-start').textContent = startTime || 'N/A';
        row.querySelector('.turn-end').textContent = endTime || 'N/A';
    }
</script>

<style>
.containerPestanas{
    display:flex;
}
.pestania3{
   border-bottom:none;
   padding:10px 20px;
   background:#f0f0f0;
   opacity:0.8;
}
.activar{
    color: rgb(13, 182, 13);
    opacity:1;
    font-weight:bold;
    border:1px solid rgb(13, 182, 13);
    border-bottom:none;
    background:white;
    box-shadow:  0 -4px 4px -2px rgba(0, 0, 0, 0.1), -4px 0 4px -2px rgba(0, 0, 0, 0.1), 4px 0 4px -2px rgba(0, 0, 0, 0.1); 
}





    /*Estilo de la funcion updateTurnTimes */ 
    .turn-select {
        min-width: 150px;
    }
    
    .turn-start, .turn-end {
        padding: 0.5rem;
        vertical-align: middle;
    }
    /*////////////////////////////////////*/ 
    .edit-icon {
        margin-left: 10px;
        cursor: pointer;
        color: #007bff;
        display: none; /* Oculto por defecto */
    }
    
    /* Estilos para el modo edición */
    .editing-mode .edit-icon {
        display: inline-block !important;
    }
    
    .editing-mode .elemView, 
    .editing-mode .elemView2 {
        background-color: #f8f9fa;
        padding: 5px;
        border-radius: 4px;
    }
    
    .active {
        color: #28a745 !important;
    }
    .delete-icon {
        cursor: pointer;
        color: red;
        margin-left: 10px;
        display: none; /* Oculto por defecto */
    }
    
    .editing-mode .delete-icon {
        display: inline-block; /* Visible en modo edición */
    }
    
    .turn-select:not(:disabled) {
        background-color: #fff;
        border: 1px solid #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    #save-button {
        display: none; /* Oculto por defecto */
    }
    
    
   /*Evitamos que los inputs se sobrepasen*/ 
    .cuerpoViewWorkers {
        font-size: 0.9rem;
    }
    .cuerpoViewWorkers input {
        width: 150px;
         font-size: 0.9rem;
    }
    .cuerpoViewWorkers input:focus {
        font-size: 0.9rem;
        width: 150px; 
    }


    /*foto de perfil tamanio*/
    .imgWorkerView{
        width:110px;
        height:110px;
        border-radius:50%;
    }
    .containerFirstView{
        display:flex;
        justify-content:space-between;
        padding-right:40px;
        padding-left:10px;
        align-items:center;
    }
    .filaElem{
        display:flex; justify-content:space-between;
        padding:0 10px;
        border-bottom:1px solid #cdcdcd;
    }
    .elemView{
        width:49%;
        display:flex;
        align-items:center;
        gap:5px;
        padding:7px 0;
    }
    .elemView2{
        width:450px;
        border-bottom:1px solid #cdcdcd;
        padding:7px 0;
        display:flex;
        align-items:center;
    }
    @media (max-width: 768px) {
      .containerFirstView{
        padding-right:0px;
      }
        .filaElem{
          flex-direction:column;
          align-items:center;
          gap:7px;
          padding:0;
          border-bottom:none;
      }
      .elemView{
        width:100%;
        border-bottom:1px solid #cdcdcd;
      }
      .elemView2{
        width:100%;
       }
    }

</style>