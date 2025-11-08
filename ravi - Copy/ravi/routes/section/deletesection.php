<?php
session_start();
require '../../config/database.php';

$response = array("status" => "", "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codesection = $_POST['codesection'];

        $checkStmt = $conn->prepare("SELECT sectiondelete FROM section WHERE codesection = ?");
        $checkStmt->bindParam(1, $codesection, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['sectiondelete'] == 1) {
            $_SESSION['message'] = 'La sección ya está eliminada';
            $_SESSION['message_type'] = 'error';
        } else {
            $stmt = $conn->prepare("UPDATE section SET sectiondelete = '1' WHERE codesection = ?");
            $stmt->bindParam(1, $codesection, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Sección eliminada correctamente';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error al eliminar la sección';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/section");
exit;