<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codebondw = $_POST['codebondt'];

        $checkStmt = $conn->prepare("SELECT bondtdelete FROM bondt WHERE codebondt = ?");
        $checkStmt->bindParam(1, $codebondw, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['bondtdelete'] == 1) {
            $_SESSION['message'] = 'La asignación de bono ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE bondt SET bondtdelete = '1' WHERE codebondt = ?");
            $stmt->bindParam(1, $codebondw, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Asignación de bono eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar la asignación de bono';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error al eliminar la asignación de bono';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/bonoturn"); 
exit;