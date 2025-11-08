<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codereason = $_POST['codereason'];

        $checkStmt = $conn->prepare("SELECT reasondelete FROM reason WHERE codereason = ?");
        $checkStmt->bindParam(1, $codereason, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['reasondelete'] == 1) {
            $_SESSION['message'] = 'El motivo ya está eliminado';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE reason SET reasondelete = '0' WHERE codereason = ?");
            $stmt->bindParam(1, $codereason, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Motivo eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar el motivo';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
       $_SESSION['message'] = 'Error al eliminar el motivo';;
       $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/motivos");
exit;





