<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codeturnw = isset($_POST['codeturnw']) ? intval($_POST['codeturnw']) : 0;
$codeworker = isset($_POST['codeworker']) ? intval($_POST['codeworker']) : 0;
$codeturn = isset($_POST['codeturnedit']) ? intval($_POST['codeturnedit']) : 0;
$turnwdelete = isset($_POST['turnwdeleteedit']) ? intval($_POST['turnwdeleteedit']) : 0; 

$sqlCheckTurn = "SELECT codeturn FROM turn WHERE codeturn = :codeturn";
$stmtCheckTurn = $pdo->prepare($sqlCheckTurn);
$stmtCheckTurn->execute([':codeturn' => $codeturn]);
$turnExists = $stmtCheckTurn->fetch(PDO::FETCH_ASSOC);

if (!$turnExists) {
    $_SESSION['message'] = 'El turno especificado no existe en la tabla `turn`';
    $_SESSION['message_type'] = 'error';
    header('Location: ../../index.php?p=turnotrabajador');
    exit();
}

$sql = "SELECT codeworker, codeturn, turnwdelete FROM turnw WHERE codeturnw = :codeturnw";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codeturnw' => $codeturnw]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['codeworker'] !== $codeworker || $currentValues['codeturn'] !== $codeturn || $currentValues['turnwdelete'] !== $turnwdelete) {
    $sql = "UPDATE turnw SET codeworker = :codeworker, codeturn = :codeturn, turnwdelete = :turnwdelete WHERE codeturnw = :codeturnw";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':codeworker' => $codeworker,
        ':codeturn' => $codeturn,
        ':turnwdelete' => $turnwdelete,
        ':codeturnw' => $codeturnw
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Asignacion de turno actualizada correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar la asignaci¨®n de turno';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'error'; 
}

header('Location: ../../index.php?p=turnotrabajador');
exit();
?>