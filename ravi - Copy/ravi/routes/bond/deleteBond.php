<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codebond = $_POST['codebond'];

        $checkStmt = $conn->prepare("SELECT bondelete FROM bond WHERE codebond = ?");
        $checkStmt->bindParam(1, $codebond, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['bondelete'] == 1) {
            $_SESSION['message'] = 'El bono ya está eliminado';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE bond SET bondelete = '1' WHERE codebond = ?");
            $stmt->bindParam(1, $codebond, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Bono eliminado correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar el bono';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/bono");
exit;