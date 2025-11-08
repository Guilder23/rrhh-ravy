<div class="modal fade" id="deleteAsigBondTurnModal" tabindex="-1" aria-labelledby="deleteAsigBondTurnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteAsigBondTurnModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Desea eliminar la asignación del bono al turno?
            </div>
            <div class="modal-footer">
                <form action="routes/bondturn/deleteAsigTurnBond.php" method="post">
                    <input type="hidden" name="codebondt" id="codebondt">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('deleteAsigBondTurnModal').addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const codebondt = button.getAttribute('data-bs-id');
        document.getElementById('codebondt').value = codebondt;
    });

    document.getElementById('deleteAsigBondTurnModal').addEventListener('hidden.bs.modal', () => {
        document.getElementById('codebondt').value = '';
    });
</script>