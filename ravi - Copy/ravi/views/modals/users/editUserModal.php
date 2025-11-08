<!-- Modal para agregar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserModalModalLabel">Agregar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/users/addUser.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre Completo:</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="userci" class="form-label">C.I.:</label>
                        <input type="text" name="userci" id="userci" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="userphone" class="form-label">Teléfono:</label>
                        <input type="text" name="userphone" id="userphone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="useraddress" class="form-label">Dirección:</label>
                        <input type="text" name="useraddress" id="useraddress" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="usertype" class="form-label">Tipo de Usuario:</label>
                        <select name="usertype" id="usertype" class="form-select" required>
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="userlogin" class="form-label">Login:</label>
                        <input type="text" name="userlogin" id="userlogin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="userpassword" class="form-label">Contraseña:</label>
                        <input type="password" name="userpassword" id="userpassword" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="useraccess" class="form-label">Acceso:</label>
                        <input type="text" name="useraccess" id="useraccess" class="form-control" required>
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

<script>
function cargarTiposDeUsuario() {
    fetch('../../routes/users/getCategorias.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('usertype');
            select.innerHTML = '';
            data.categorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.codecategory;
                option.textContent = categoria.namecategory;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar categorías:', error));
}

document.getElementById('addUserModal').addEventListener('show.bs.modal', cargarTiposDeUsuario);
</script>
