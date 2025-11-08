<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codeturna = isset($_POST['codeturna']) ? intval($_POST['codeturna']) : 0;
$codearea = isset($_POST['codearea']) ? intval($_POST['codearea']) : 0;
$codeturn = isset($_POST['codeturnedit']) ? intval($_POST['codeturnedit']) : 0;
$turnadelete = isset($_POST['turnadeleteedit']) ? intval($_POST['turnadeleteedit']) : 0;

$sqlCheckTurn = "SELECT codeturn FROM turn WHERE codeturn = :codeturn";
$stmtCheckTurn = $pdo->prepare($sqlCheckTurn);
$stmtCheckTurn->execute([':codeturn' => $codeturn]);
$turnExists = $stmtCheckTurn->fetch(PDO::FETCH_ASSOC);

if (!$turnExists) {
    $_SESSION['message'] = 'El turno especificado no existe en la tabla `turn`';
    $_SESSION['message_type'] = 'error';
    header('Location: ../../index.php?p=turnoarea');
    exit();
}

$sql = "SELECT codearea, codeturn, turnadelete FROM turna WHERE codeturna = :codeturna";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codeturna' => $codeturna]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['codearea'] !== $codearea || $currentValues['codeturn'] !== $codeturn || $currentValues['turnadelete'] !== $turnadelete) {
    $sql = "UPDATE turna SET codearea = :codearea, codeturn = :codeturn, turnadelete = :turnadelete WHERE codeturna = :codeturna";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':codearea' => $codearea,
        ':codeturn' => $codeturn,
        ':turnadelete' => $turnadelete,
        ':codeturna' => $codeturna
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Asignación de turno actualizada correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar la asignación de turno';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'error'; 
}

header('Location: ../../index.php?p=turnoarea');
exit();
?>