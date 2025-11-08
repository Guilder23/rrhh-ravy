<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database('local');
    $conn = $db->getConnection();

    if ($conn) {
        $namecategory = $conn->quote($_POST['namecategory']);

        $sql = "INSERT INTO category (namecategory) VALUES ($namecategory)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Categoría agregada correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al agregar la categoría';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=usuarios");
exit;
