<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $username = $conn->quote($_POST['username']);
        $userci = $conn->quote($_POST['userci']);
        $userphone = isset($_POST['userphone']) ? $conn->quote($_POST['userphone']) : 'NULL';
        $useraddress = isset($_POST['useraddress']) ? $conn->quote($_POST['useraddress']) : 'NULL';
        $usertype = $conn->quote($_POST['usertype']);
        $userlogin = $conn->quote($_POST['userlogin']);
        $userpassword = $conn->quote($_POST['userpassword']);
        $userstate = $conn->quote('Activo');
        $useraccess = $conn->quote($_POST['useraccess']);

        $sql = "INSERT INTO user (username, userci, userphone, useraddress, usertype, userlogin, userpassword, userstate, useraccess) 
                VALUES ($username, $userci, $userphone, $useraddress, $usertype, $userlogin, $userpassword, $userstate, $useraccess)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Usuario agregado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al agregar el usuario';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=usuarios");
exit;


