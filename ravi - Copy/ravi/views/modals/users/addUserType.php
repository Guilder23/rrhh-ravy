<!-- Modal para agregar tipo de usuario -->
<div class="modal fade" id="addUserType" tabindex="-1" aria-labelledby="addUserTypeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUserTypeLabel">Agregar Tipo de Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/users/addCategory.php" method="post">
                    <div class="mb-3">
                        <label for="namecategory" class="form-label">Nombre de la Categoría:</label>
                        <input type="text" name="namecategory" id="namecategory" class="form-control" required>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
            
            <!-- Lista de categorías existentes -->
            <div class="modal-footer" style="display: block;">
                <h6>Categorías Existentes:</h6>
                <div id="listaCategorias" style="max-height: 200px; overflow-y: auto;">
                    <!-- Las categorías se cargarán dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cargarCategoriasLista() {
    fetch('../../routes/users/getCategorias.php')
        .then(response => response.json())
        .then(data => {
            const lista = document.getElementById('listaCategorias');
            lista.innerHTML = '';
            
            if (data.categorias && data.categorias.length > 0) {
                const ul = document.createElement('ul');
                ul.className = 'list-group';
                
                data.categorias.forEach(categoria => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <span>${categoria.namecategory}</span>
                        <button class="btn btn-sm btn-danger" onclick="eliminarCategoria(${categoria.codecategory})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    `;
                    ul.appendChild(li);
                });
                
                lista.appendChild(ul);
            } else {
                lista.innerHTML = '<p class="text-muted">No hay categorías registradas</p>';
            }
        })
        .catch(error => console.error('Error al cargar categorías:', error));
}

function eliminarCategoria(codecategory) {
    if (confirm('¿Está seguro de eliminar esta categoría?')) {
        fetch(`../../routes/users/deleteCategory.php?codecategory=${codecategory}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Categoría eliminada correctamente');
                cargarCategoriasLista();
            } else {
                alert('Error al eliminar la categoría: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Cargar categorías cuando se abre el modal
document.getElementById('addUserType').addEventListener('show.bs.modal', cargarCategoriasLista);
</script>

<style>
#listaCategorias .list-group-item {
    padding: 8px 12px;
    font-size: 14px;
}
</style>
