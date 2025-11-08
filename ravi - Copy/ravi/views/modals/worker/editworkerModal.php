<!-- Modal -->
<div class="modal fade" id="editworkerModal" tabindex="-1" aria-labelledby="editworkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editworkerModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Editar registro
            </div>
            <div class="modal-footer">
                 <input type="text" id="code_worker" readonly>
                <form action="routes/turn/deleteTurn.php" method="post">
                    <input type="hidden" name="codeturn" id="codeturn">
                    <button type="submit" class="btn btn-primary">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>