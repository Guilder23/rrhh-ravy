<!-- Modal -->
<div class="modal fade" id="addLicenseModal" tabindex="-1" aria-labelledby="addLicenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addLicenseModalLabel">Agregar Licencia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/license/addLicense.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codearea" value="">
                    
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-default">Dia:</span>
                      <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" readonly>
                    </div>
                    
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-default">Colaborador:</span>
                      <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-default">Motivo:</span>
                      <input list="motivos" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Selecciona o escribe un motivo">
                      <datalist id="motivos">
                        <option value="Consulta">
                        <option value="Reclamo">
                        <option value="Sugerencia">
                        <option value="Felicitación">
                        <option value="Otro">
                      </datalist>
                    </div>
                    
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-default">Observaciones:</span>
                      <textarea type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" ></textarea>
                      </div>
                      
                
                    
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>