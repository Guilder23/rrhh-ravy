<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codereason = isset($_POST['codereason']) ? intval($_POST['codereason']) : 0;
$reasonname = isset($_POST['reasonname']) ? trim($_POST['reasonname']) : '';
$reasondelete = isset($_POST['reasondelete']) ? intval($_POST['reasondelete']) : 0;

$sql = "SELECT reasonaname, reasondelete FROM reason WHERE codereason = :codereason";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codereason' => $codereason]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['reasonaname'] !== $reasonname || $currentValues['reasondelete'] !== $reasondelete) {
    $sql = "UPDATE reason SET reasonname = :reasonname, reasondelete = :reasondelete WHERE codereason = :codereason";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':reasonname' => $reasonname,
        ':reasondelete' => $reasondelete,
        ':codereason' => $codereason
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Area actualizada correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar el área: ';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'success';
}

header('Location: ../../index.php?p=subviews/motivos');
exit();
?>
