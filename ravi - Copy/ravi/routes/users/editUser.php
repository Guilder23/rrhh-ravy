<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database('local');
    $conn = $db->getConnection();

    if ($conn) {
        $codeuser = $conn->quote($_POST['codeuser']);
        $username = $conn->quote($_POST['username']);
        $userci = $conn->quote($_POST['userci']);
        $userphone = isset($_POST['userphone']) ? $conn->quote($_POST['userphone']) : 'NULL';
        $useraddress = isset($_POST['useraddress']) ? $conn->quote($_POST['useraddress']) : 'NULL';
        $usertype = $conn->quote($_POST['usertype']);
        $userlogin = $conn->quote($_POST['userlogin']);
        $useraccess = $conn->quote($_POST['useraccess']);

        // Construir la consulta SQL
        $sql = "UPDATE user SET 
                username = $username, 
                userci = $userci, 
                userphone = $userphone, 
                useraddress = $useraddress, 
                usertype = $usertype, 
                userlogin = $userlogin, 
                useraccess = $useraccess";

        // Solo actualizar la contraseña si se proporcionó una nueva
        if (!empty($_POST['userpassword'])) {
            $userpassword = $conn->quote($_POST['userpassword']);
            $sql .= ", userpassword = $userpassword";
        }

        $sql .= " WHERE codeuser = $codeuser";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Usuario actualizado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al actualizar el usuario';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=usuarios");
exit;
