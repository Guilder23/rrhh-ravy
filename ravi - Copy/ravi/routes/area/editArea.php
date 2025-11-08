<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codearea = isset($_POST['codearea']) ? intval($_POST['codearea']) : 0;
$areaname = isset($_POST['areaname']) ? trim($_POST['areaname']) : '';
$areadelete = isset($_POST['areadelete']) ? intval($_POST['areadelete']) : 0;

$sql = "SELECT areaname, areadelete FROM area WHERE codearea = :codearea";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codearea' => $codearea]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['areaname'] !== $areaname || $currentValues['areadelete'] !== $areadelete) {
    $sql = "UPDATE area SET areaname = :areaname, areadelete = :areadelete WHERE codearea = :codearea";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':areaname' => $areaname,
        ':areadelete' => $areadelete,
        ':codearea' => $codearea
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
    $_SESSION['message_type'] = 'info';
}

header('Location: ../../index.php?p=subviews/area');
exit();
?>


