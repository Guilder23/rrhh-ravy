<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database('local');
    $conn = $db->getConnection();

    if ($conn) {
        $codeuser = isset($_POST['codeuser']) ? trim($_POST['codeuser']) : '';
        
        if (!empty($codeuser) && is_numeric($codeuser)) {
            $codeuser = (int)$codeuser;
            
            // Verificar que el usuario existe antes de actualizar
            $checkStmt = $conn->prepare("SELECT codeuser, userstate FROM user WHERE codeuser = :codeuser");
            $checkStmt->bindParam(':codeuser', $codeuser, PDO::PARAM_INT);
            $checkStmt->execute();
            $userExists = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userExists) {
                // Verificar el estado actual
                $currentState = trim($userExists['userstate']);
                
                // Actualizar el estado del usuario
                $stmt = $conn->prepare("UPDATE user SET userstate = 'Inactivo' WHERE codeuser = :codeuser");
                $stmt->bindParam(':codeuser', $codeuser, PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    $rowsAffected = $stmt->rowCount();
                    if ($rowsAffected > 0) {
                        $_SESSION['message'] = 'Usuario eliminado correctamente';
                        $_SESSION['message_type'] = 'success';
                    } else {
                        // Si no se afectaron filas, podría ser que el usuario ya estaba inactivo
                        // o que el valor en la BD es diferente (con espacios, mayúsculas, etc.)
                        $_SESSION['message'] = 'No se pudo actualizar el usuario. Estado actual: ' . htmlspecialchars($currentState);
                        $_SESSION['message_type'] = 'error';
                    }
                } else {
                    $errorInfo = $stmt->errorInfo();
                    $_SESSION['message'] = 'Error al ejecutar la consulta: ' . $errorInfo[2];
                    $_SESSION['message_type'] = 'error';
                }
            } else {
                $_SESSION['message'] = 'Error: Usuario no encontrado con ID: ' . $codeuser;
                $_SESSION['message_type'] = 'error';
            }
        } else {
            $_SESSION['message'] = 'Error: ID de usuario no válido';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'Error: Método de solicitud no válido';
    $_SESSION['message_type'] = 'error';
}

header("Location: ../../index.php?p=usuarios");
exit;


