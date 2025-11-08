<div class="modal fade" id="viewLicenseModal" tabindex="-1" aria-labelledby="viewLicenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLicenseModalLabel">Informacion de la licencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="titleCabecera">PERMISO DE SALIDA</div>
                    
                    <div class="separador5">
                        <div style="display:flex; flex-direction:column; width:calc(50% - 5px); padding-right:5px; box-sizing:border-box;">
                           <div class="bordear">
                                <label class="letritas" for="fechaPermiso" class="form-label">FECHA DE EMISION DEL PERMISO:</label>
                                <input type="date" class="form-control" id="fechaPermiso" name="fechaPermiso">
                            </div>
                          
                            <!-- Campos para permiso por hora -->
                            <div id="seleccionHora" class="hidden">
                                <div class="bordear">
                                    <label class="letritas" for="fechaHora">FECHA DEL PERMISO:</label>
                                    <input type="date" id="fechaHora" name="fechaHora">
                                </div>
                                <div class="bordear">
                                    <label class="letritas" for="horaInicio">HORA DE SALIDA:</label>
                                    <input type="time" id="horaInicio" name="horaInicio">
                               </div>
                                <div class="bordear">
                                    <label class="letritas" for="horaFin">HORA DE ENTRADA:</label>
                                    <input type="time" id="horaFin" name="horaFin">
                                </div>
                            </div>
                        </div><!--fin mitad-->   
                       
                        <div style="display:flex; flex-direction:column; width:calc(50% - 5px); padding-left:5px; box-sizing:border-box;">
                            <!-- Campos para permiso por fechas -->
                            <div id="seleccionFecha" class="hidden">
                                <div class="elementoForm">
                                    <label class="letritas" for="fechaInicio">FECHA DE INICIO:</label>
                                    <input type="date" id="fechaInicio" name="fechaInicio">
                                </div>
                               <div class="elementoForm">
                                    <label class="letritas" for="fechaFin">FECHA DE FIN:</label>
                                    <input type="date" id="fechaFin" name="fechaFin">
                                </div>
                            </div>
                            
                            <div class="bordear">
                                <label class="letritas" for="nombreTrabajador">NOMBRE DEL TRABAJADOR:</label>
                                <input type="text" class="form-control" id="nombreTrabajador" name="nombreTrabajador">
                            </div>
                      
                            <div class="bordear">
                                <label class="letritas" for="cedulaTrabajador">CODIGO DEL TRABAJADOR:</label>
                                <input type="text" class="form-control" id="cedulaTrabajador" name="cedulaTrabajador">
                           </div>
                      
                            <div class="elementoForm bordear">
                                <label class="letritas" for="motivoSalida">MOTIVO DE SALIDA:</label>
                                <input type="text" class="form-control" id="motivoSalida" name="motivoSalida">  
                            </div>
                        </div><!--fin mitad-->
                    </div>
                </div>
            </div>
                  
            <div class="modal-footer">
                <form action="routes/gestion/setLicencse.php" method="post">
                    <input type="hidden" id="codetlicense" name="codetlicense">
                    <button value="1" type="submit" class="btn btn-primary">Aprobar Licencia</button>
                    <button value="2" type="submit" class="btn btn-primary">Rechazar Licencia</button>
                    <button value="3" type="submit" class="btn btn-primary">Enviar a Revisi¨®n</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.titleCabecera{
    font-weight:bold;
    text-align:center;
    background:#cdcdcd;
    margin:0;
    border:2px solid #cdcdcd;
}
.separador5{
    display:flex; flex-wrap:wrap;
    background:#f0f0f0;
}
.bordear{
   box-sizing:border-box;
   border-bottom: 2px solid #cdcdcd;
   padding:5px 0px;
   display:flex;
   gap:10px;
}
.bordear input{
    border:none;
    background:#f0f0f0;
    margin:0;
}
.letritas{
    font-size:0.9rem;
}
.hidden {
    display: none;
}
</style>