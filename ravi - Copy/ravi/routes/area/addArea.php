<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $areaname = $conn->quote($_POST['areaname']);

        $sql = "INSERT INTO area (areaname) 
                VALUES ($areaname)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Área agregada correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al agregar el área';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/area");
exit;