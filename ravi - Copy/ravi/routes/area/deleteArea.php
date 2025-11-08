<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codearea = $_POST['codearea'];

        $checkStmt = $conn->prepare("SELECT areadelete FROM area WHERE codearea = ?");
        $checkStmt->bindParam(1, $codearea, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['areadelete'] == 1) {
            $_SESSION['message'] = 'El área ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE area SET areadelete = '1' WHERE codearea = ?");
            $stmt->bindParam(1, $codearea, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Área eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar el área';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
       $_SESSION['message'] = 'Error al eliminar el área';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/area");
exit;





