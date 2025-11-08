<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codeturna = $_POST['codeturna'];

        $checkStmt = $conn->prepare("SELECT turnadelete FROM turna WHERE codeturna = ?");
        $checkStmt->bindParam(1, $codeturna, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['turnadelete'] == 1) {
            $_SESSION['message'] = 'La asignación ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE turna SET turnadelete = '1' WHERE codeturna = ?");
            $stmt->bindParam(1, $codeturna, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Asignación eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar la asignación';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=turnoarea");
exit;
?>