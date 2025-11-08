<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $turnname = $conn->quote($_POST['turnname']);
        $turnstart = $conn->quote($_POST['turnstart']);
        $turnend = $conn->quote($_POST['turnend']);

        $sql = "INSERT INTO turn (turnname, turnstart, turnend) 
                VALUES ($turnname, $turnstart, $turnend)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Turno agregado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al agregar el turno';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=turnos");
exit;