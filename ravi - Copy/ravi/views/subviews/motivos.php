<body> 
  <h2 class="titulogestion">Configurar motivos de permisos</h2>
    <section class="containerOptions">
        <div class="inputArea">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" class="form-control" placeholder="Por nombre o codigo">
        </div>
        <div class="inputArea">
            <label for="registrosPorPagina">Numero de Registros</label>
            <select id="registrosPorPagina" class="form-control">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addAreaModal">
            <i class="fa-solid fa-circle-plus"></i> Nuevo motivo de permiso
        </button>
        <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
    </section>
    
    <table class="table table-sm table-striped table-hover" id="tablaArea">
        <thead class="table-dark">
            <tr>
                <td scope="col">#</td>
                <td scope="col">Nombre</td>
                <td scope="col">Estado</td>
                <td scope="col">Accriones</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
        <!-- Paginacion -->
    <nav>
        <ul class="pagination justify-content-center" id="paginacion">
        </ul>
    </nav>

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/scriptRecursive.js"></script>
</body>

<?php include 'modals/reason/addReasonModal.php'; ?>
<?php include 'modals/reason/deleteReasonModal.php'; ?>
<?php include 'modals/reason/editReasonModal.php'; ?>

<script>
    
</script>