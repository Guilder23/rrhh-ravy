<?php
session_start();
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codeuser = $_POST['codeuser'];
        $stmt = $conn->prepare("UPDATE user SET userstate = '1' WHERE codeuser = ?");
        $stmt->bindParam(1, $codearea, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Usuario eliminado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al eliminar el usuario';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error al eliminar el usuario';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=usuarios");
exit;


