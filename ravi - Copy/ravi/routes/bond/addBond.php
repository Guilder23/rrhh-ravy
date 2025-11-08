<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $bondcode = $conn->quote($_POST['bondcode']);
        $bondreason = $conn->quote($_POST['bondreason']);
        $bondvalue = $conn->quote($_POST['bondvalue']);
        $bondnro = $conn->quote($_POST['bondnro']);
        $bondfee = $conn->quote($_POST['bondfee']);

        $sql = "INSERT INTO bond (bondcode, bondreason, bondvalue, bondnro, bondfee) 
                VALUES ($bondcode, $bondreason, $bondvalue, $bondnro, $bondfee)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Bono agregado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al agregar el bono';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/bono");
exit;