<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserModalModalLabel">Editar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/users/editUser.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="codeuser" id="edit_codeuser">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Nombre Completo:</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_userci" class="form-label">C.I.:</label>
                        <input type="text" name="userci" id="edit_userci" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_userphone" class="form-label">Teléfono:</label>
                        <input type="text" name="userphone" id="edit_userphone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit_useraddress" class="form-label">Dirección:</label>
                        <input type="text" name="useraddress" id="edit_useraddress" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="edit_usertype" class="form-label">Tipo de Usuario:</label>
                        <select name="usertype" id="edit_usertype" class="form-select" required>
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_userlogin" class="form-label">Login:</label>
                        <input type="text" name="userlogin" id="edit_userlogin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_userpassword" class="form-label">Contraseña:</label>
                        <input type="password" name="userpassword" id="edit_userpassword" class="form-control" placeholder="Dejar en blanco para mantener la actual">
                    </div>

                    <div class="mb-3">
                        <label for="edit_useraccess" class="form-label">Acceso:</label>
                        <input type="text" name="useraccess" id="edit_useraccess" class="form-control" required>
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
function cargarTiposDeUsuarioEdit() {
    fetch('../../routes/users/getCategorias.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('edit_usertype');
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

// Cargar datos del usuario cuando se abre el modal
document.getElementById('editUserModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const codeuser = button.getAttribute('data-bs-id');
    
    // Cargar tipos de usuario primero
    cargarTiposDeUsuarioEdit();
    
    // Cargar datos del usuario
    fetch(`../../routes/users/getUser.php?codeuser=${codeuser}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_codeuser').value = data.usuario.codeuser;
                document.getElementById('edit_username').value = data.usuario.username;
                document.getElementById('edit_userci').value = data.usuario.userci;
                document.getElementById('edit_userphone').value = data.usuario.userphone;
                document.getElementById('edit_useraddress').value = data.usuario.useraddress;
                document.getElementById('edit_userlogin').value = data.usuario.userlogin;
                document.getElementById('edit_useraccess').value = data.usuario.useraccess;
                document.getElementById('edit_userpassword').value = '';
                
                // Esperar a que se carguen las categorías antes de seleccionar
                setTimeout(() => {
                    document.getElementById('edit_usertype').value = data.usuario.usertype;
                }, 100);
            }
        })
        .catch(error => console.error('Error al cargar usuario:', error));
});
</script>
