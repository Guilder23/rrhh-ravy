<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
<h2 class="titulogestion">Gestión usuario</h2>
<section class="containerOptions">
        <!-- Boton para agregar nuevo producto -->
            <div class="col-auto">
                <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa-solid fa-circle-plus"></i> Nuevo Registro
                </button>
            </div>
            <div class="col-auto">
                <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addUserType">
                    <i class="fa-solid fa-circle-plus"></i> Tipo de Usuario
                </button>
            </div>
            <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
</section>



<?php
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    
    echo "<div class='message $message_type'>$message</div>";
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<div class="containerTable">
    <table class="table table-sm table-striped table-hover" id="tablaUsers">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NOMBRE COMPLETO</th>
                <th scope="col">C.I.</th>
                <th scope="col">TELEFONO</th>
                <th scope="col">DIRECCION</th>
                <th scope="col">TIPO USUARIO</th>
                <th scope="col">LOGIN</th>
                <th scope="col">CONTRASEÑA</th>
                <th scope="col">ESTADO</th>
                <th scope="col">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas de datos -->
        </tbody>
    </table>
</div>
<nav>
    <ul class="pagination justify-content-center" id="paginacion">
    </ul>
</nav>
<?php include 'modals/users/addUserModal.php'; ?>
<?php include 'modals/users/deleteUserModal.php'; ?>
<?php include 'modals/users/editUserModal.php'; ?>
<?php include 'modals/users/addUserType.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scriptRecursive.js"></script>
</body>
<script>

const tabla = document.querySelector('#tablaUsers tbody');
const paginacion = document.querySelector('#paginacion');
let paginaActual = 1;

    function cargarUsuarios(pagina = 1) {
        fetch(`../routes/users/getUsers.php?pagina=${pagina}`)
            .then(response => response.json())
            .then(data => {
                tabla.innerHTML = ''; // Limpiar tabla
                paginacion.innerHTML = ''; // Limpiar paginacion
    
                data.usuarios.forEach(usuario => {
                    const estado = usuario.userstate === 'Activo' 
                        ? '<div class="estado activo"><i class="fas fa-circle"></i><span style="color:#333">Activo</span></div>' 
                        : '<div class="estado inactivo"><i class="fas fa-circle"></i><span style="color:#333">Inactivo</span></div>';
                    tabla.innerHTML += `
                        <tr>
                            <td>${usuario.codeuser}</td>
                            <td>${usuario.username}</td>
                            <td>${usuario.userci}</td>
                            <td>${usuario.userphone}</td>
                            <td>${usuario.useraddress}</td>
                            <td>${usuario.namecategory}</td>
                            <td>${usuario.userlogin}</td>
                            <td>${usuario.userpassword}</td>
                            <td>${estado}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editUserModal" 
                                    data-bs-id="${usuario.codeuser}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteUserModal" 
                                    data-bs-id="${usuario.codeuser}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                });
    
                // paginacion
                if (data.totalPaginas > 1) {
                    for (let i = 1; i <= data.totalPaginas; i++) {
                        paginacion.innerHTML += `
                            <li class="page-item ${pagina === i ? 'active' : ''}">
                                <a class="page-link" href="#" onclick="cargarUsuarios(${i})">${i}</a>
                            </li>
                        `;
                    }
                }
            })
            .catch(error => console.error('Error al cargar usuarios:', error));
    }
    let eliminaModal = document.getElementById('deleteUserModal');
    if (eliminaModal) {
        eliminaModal.addEventListener('show.bs.modal', event => {
            let button = event.relatedTarget;
            let codeuser = button.getAttribute('data-bs-id');
            let codeuserInput = eliminaModal.querySelector('input[name="codeuser"]');
            if (codeuserInput && codeuser) {
                codeuserInput.value = codeuser;
                console.log('Codeuser establecido:', codeuser);
            } else {
                console.error('No se pudo establecer codeuser. Input:', codeuserInput, 'Codeuser:', codeuser);
            }
        });
        
        eliminaModal.addEventListener('hidden.bs.modal', () => {
            let codeuserInput = eliminaModal.querySelector('input[name="codeuser"]');
            if (codeuserInput) {
                codeuserInput.value = '';
            }
        });
    }
    
    setTimeout(function() {
        var message = document.querySelector('.message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000); // 5000 ms = 5 segundos
    
    document.addEventListener('DOMContentLoaded', () => cargarUsuarios(paginaActual));
</script>

<style>


.message {
    padding: 15px;
    margin: 20px;
    font-size: 16px;
    border-radius: 5px;
    width: 50%;
    margin-left: auto;
    margin-right: auto;
}

.success {
    color: green;
}

.error {
    color: red;
}

.estado {
    display: flex;
    align-items:center;
    align-items: center;
    gap: 2px;
}
.activo {
    color: green;
}
.inactivo {
    color: red;
}




</style>