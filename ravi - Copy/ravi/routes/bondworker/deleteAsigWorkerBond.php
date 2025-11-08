<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codebondw = $_POST['codebondw'];

        $checkStmt = $conn->prepare("SELECT bondwdelete FROM bondw WHERE codebondw = ?");
        $checkStmt->bindParam(1, $codebondw, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['bondwdelete'] == 1) {
            $_SESSION['message'] = 'La asignación de bono ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE bondw SET bondwdelete = '1' WHERE codebondw = ?");
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
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/bonotrabajador"); 
exit;