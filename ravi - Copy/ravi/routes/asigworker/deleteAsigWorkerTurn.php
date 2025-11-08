<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codeturnw = $_POST['codeturnw'];

        $checkStmt = $conn->prepare("SELECT turnwdelete FROM turnw WHERE codeturnw = ?");
        $checkStmt->bindParam(1, $codeturnw, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['turnwdelete'] == 1) {
            $_SESSION['message'] = 'La asignacion ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE turnw SET turnwdelete = '1' WHERE codeturnw = ?");
            $stmt->bindParam(1, $codeturnw, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Asignacion eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar la asignacion';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error al eliminar la asignacion';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=turnotrabajador");
exit;
?>