<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $reasonname = $conn->quote($_POST['reasonname']);
        $reasondelete = isset($_POST['reasondelete']) ? (int)$_POST['reasondelete'] : 1;

        $sql = "INSERT INTO reason (reasonname) 
                VALUES ($reasonname)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Motivo agregada correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al agregar el motivo';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error al agregar el motivo';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/motivos");
exit;