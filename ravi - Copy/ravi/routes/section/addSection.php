<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $namesection = $conn->quote($_POST['namesection']);

        $sql = "INSERT INTO section (namesection) 
                VALUES ($namesection)";

        if ($conn->exec($sql)) {
                $_SESSION['message'] = 'Seccion agregada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al agregar una seccion';
                $_SESSION['message_type'] = 'error';
            }
    } else {
        $_SESSION['message'] = 'Error al agregar una seccion';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/section");
exit;