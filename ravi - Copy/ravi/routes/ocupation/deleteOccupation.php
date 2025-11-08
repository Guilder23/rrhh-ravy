<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codeoccupation = $_POST['codeoccupation'];

        $checkStmt = $conn->prepare("SELECT occupationdelete FROM occupation WHERE codeoccupation = ?");
        $checkStmt->bindParam(1, $codeoccupation, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['occupationdelete'] == 1) {
            $_SESSION['message'] = 'La ocupación ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE occupation SET occupationdelete = '1' WHERE codeoccupation = ?");
            $stmt->bindParam(1, $codeoccupation, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Ocupación eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar la ocupación';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error al eliminar la ocupación';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/cargo");
exit;

