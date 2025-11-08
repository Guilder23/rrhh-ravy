

<!-- Modal para agregar usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUserModalLabel">Agregar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="routes/users/addUser.php" method="post" enctype="multipart/form-data">
                    <div class="elementoForm">
                        <label for="username" class="labelForm">Nombre Completo:</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>

                    <div class="elementoForm">
                        <label for="userci" class="labelForm">C.I.:</label>
                        <input type="text" name="userci" id="userci" class="form-control" required>
                    </div>

                    <div class="elementoForm">
                        <label for="userphone" class="labelForm">Teléfono:</label>
                        <input type="text" name="userphone" id="userphone" class="form-control">
                    </div>

                    <div class="elementoForm">
                        <label for="useraddress" class="labelForm">Dirección:</label>
                        <input type="text" name="useraddress" id="useraddress" class="form-control">
                    </div>

                    <div class="elementoForm">
                        <label for="usertype" class="labelForm">Tipo de Usuario:</label>
                        <select name="usertype" id="usertype" class="form-select" required>
                            <!-- Las opciones se cargarán dinámicamente -->
                        </select>
                    </div>

                    <div class="elementoForm">
                        <label for="userlogin" class="labelForm">Login:</label>
                        <input type="text" name="userlogin" id="userlogin" class="form-control" required>
                    </div>

                    <div class="elementoForm">
                        <label for="userpassword" class="labelForm">Contraseña:</label>
                        <input type="password" name="userpassword" id="userpassword" class="form-control" required>
                    </div>

                    <div class="elementoForm">
                        <label for="useraccess" class="labelForm">Acceso:</label>
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

<style>
  .elementoForm{
      font-size:1rem;
      display:flex;
      justify-content: space-between;
      margin:5px 0px;
      align-items:center;
  }
  .elementoForm input{
      padding:3px;
      width:250px;
  }
  .elementoForm select{
      width:250px;
  }
  .labelForm {
      margin:0;
  }
</style>

