<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $nameoccupation = $conn->quote($_POST['nameoccupation']);

        $sql = "INSERT INTO occupation (nameoccupation) 
                VALUES ($nameoccupation)";

         if ($conn->exec($sql)) {
                $_SESSION['message'] = 'Ocupación agregada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al agregar la ocupación';
                $_SESSION['message_type'] = 'error';
            }
    } else {
        $_SESSION['message'] = 'Error al agregar la ocupación';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/cargo");
exit;