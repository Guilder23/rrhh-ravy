<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codeturn = $_POST['codeturn'];

        $checkStmt = $conn->prepare("SELECT turndelete FROM turn WHERE codeturn = ?");
        $checkStmt->bindParam(1, $codetturn, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['turndelete'] == 0) {
            $_SESSION['message'] = 'El turno ya está eliminado';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE turn SET turndelete = '1' WHERE codeturn = ?");
            $stmt->bindParam(1, $codeturn, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Turno eliminado correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar el turno';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error al eliminar el turno';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=turnos");
exit;