<div class="modal fade" id="viewOrdenOutModal" tabindex="-1" aria-labelledby="viewOrdenOutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modalHeader">
                <h5 class="modal-title" id="viewOrdenOutModalLabel">Información de la licencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="titleCabecera">PERMISO DE SALIDA</div>
             <form action="../../routes/approved/crearPdf.php" id="printForm" method="post">
                    <input type="hidden" name="name" id="name" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="lastname" id="lastname" value="<?php echo htmlspecialchars($_SESSION['userlastname'], ENT_QUOTES, 'UTF-8'); ?>">
                    
                    <div class="separador5">
                        <div class="columna-izquierda">
                           <div class="bordear">
                                <label class="letritas" for="fechaPermiso">FECHA DE APROBACION DEL PERMISO:</label>
                                <input type="date" class="form-control" id="fechaPermiso" name="fechaPermiso" readonly>
                            </div>
                          
                            <div id="seleccionHora" class="hidden">
                                <div class="bordear">
                                    <label class="letritas" for="fechaHora">FECHA DE EMISIÓN DEL PERMISO:</label>
                                    <input type="date" class="form-control" id="fechaHora" name="fechaHora" readonly>
                                </div>
                                <div class="bordear">
                                    <label class="letritas" for="horaInicio">HORA DE SALIDA:</label>
                                    <input type="time" class="form-control" id="horaInicio" name="horaInicio" readonly>
                               </div>
                                <div class="bordear">
                                    <label class="letritas" for="horaFin">HORA DE ENTRADA:</label>
                                    <input type="time" class="form-control" id="horaFin" name="horaFin" readonly>
                                </div>
                            </div>
                        </div>
                       
                        <div class="columna-derecha">
                            <div id="seleccionFecha" class="hidden">
                                <div class="bordear">
                                    <label class="letritas" for="fechaInicio">FECHA DE INICIO:</label>
                                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" readonly>
                                </div>
                               <div class="bordear">
                                    <label class="letritas" for="fechaFin">FECHA DE FIN:</label>
                                    <input type="date" class="form-control" id="fechaFin" name="fechaFin" readonly>
                                </div>
                            </div>
                            
                            <div class="bordear">
                                <label class="letritas" for="nombreTrabajador">NOMBRE DEL TRABAJADOR:</label>
                                <input type="text" class="form-control" id="nombreTrabajador" name="nombreTrabajador" readonly>
                            </div>
                      
                            <div class="bordear">
                                <label class="letritas" for="cedulaTrabajador">CÓDIGO DEL TRABAJADOR:</label>
                                <input type="text" class="form-control" id="cedulaTrabajador" name="cedulaTrabajador" readonly>
                           </div>
                      
                            <div class="bordear">
                                <label class="letritas" for="motivoSalida">MOTIVO DE SALIDA:</label>
                                <input type="text" class="form-control" id="motivoSalida" name="motivoSalida" readonly>  
                            </div>
                                             
                            <div class="bordear">
                                <label class="letritas" for="seccionSalida">SecciÓn:</label>
                                <input type="text" class="form-control" id="seccionSalida" name="seccionSalida" readonly>  
                            </div>
                            
                            <div class="bordear">
                                <label for="observacionSalida">ObservaciÓn:</label>
                                <textarea id="observacionSalida" name="observacionSalida" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  
            <div class="modal-footer">
                    <input type="hidden" id="codetlicense" name="codetlicense">
                    <input type="hidden" id="codelicense" name="codelicense">
                    <input type="hidden" id="codeworker" name="codeworker">
                    <button type="submit" class="btn btn-primary" id="btnImprimir" onclick="obtenerDatosAsignados()">
                        <i class="fas fa-print me-2"></i>Imprimir
                    </button>
                    <button type="button" onclick="limpiarDatosAsignados()">limpiarDatos</button>
                    <!--en views/aproved.php se obtienen obtienen lo datos por fetch
                     aproval_satus:1 = aprobado 0 = pendiente, 2 =rechazado, 3=enviar para revision
                    -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
            </div>
            </form>
        </div>
    </div>
</div>

<style>
.modalHeader{
    background:#7fbc03;
    color:white;
    display:flex;
    justify-content: space-between;
    padding:10px;
    border-radius:7px 7px 0 0;
}
.titleCabecera {
    font-weight: bold;
    text-align: center;
    background: #0d6efd;
    color: white;
    margin: 0;
    padding: 10px;
    border-radius: 5px 5px 0 0;
}

.separador5 {
    display: flex;
    flex-wrap: wrap;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 0 0 5px 5px;
}

.columna-izquierda,
.columna-derecha {
    display: flex;
    flex-direction: column;
    width: calc(50% - 10px);
    padding: 0 5px;
    box-sizing: border-box;
}

.bordear {
    box-sizing: border-box;
    border-bottom: 1px solid #dee2e6;
    padding: 10px 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.bordear input {
    border: 1px solid #ced4da;
    background: #f8f9fa;
    padding: 8px;
    border-radius: 4px;
}

.bordear input:read-only {
    background-color: #e9ecef;
    cursor: not-allowed;
}

.letritas {
    font-size: 0.9rem;
    color: #495057;
    font-weight: 500;
}

.hidden {
    display: none !important;
}

@media (max-width: 768px) {
    .columna-izquierda,
    .columna-derecha {
        width: 100%;
        padding: 0;
    }
}
</style>