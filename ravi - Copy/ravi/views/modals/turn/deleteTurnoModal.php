<!-- Modal -->
<div class="modal fade" id="deleteTurnoModal" tabindex="-1" aria-labelledby="deleteTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteTurnoModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                多Desea eliminar el registro?
            </div>
            <div class="modal-footer">
                <form action="routes/turn/deleteTurn.php" method="post">
                    <input type="hidden" name="codeturn" id="codeturn">
                    <button type="submit" class="btn btn-primary">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>