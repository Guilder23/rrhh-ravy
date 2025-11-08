<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codeoccupation = isset($_POST['codeoccupation']) ? intval($_POST['codeoccupation']) : 0;
$nameoccupation = isset($_POST['nameoccupation']) ? trim($_POST['nameoccupation']) : '';
$occupationdelete = isset($_POST['occupationdelete']) ? intval($_POST['occupationdelete']) : 0;

$sql = "SELECT nameoccupation, occupationdelete FROM occupation WHERE codeoccupation = :codeoccupation";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codeoccupation' => $codeoccupation]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['nameoccupation'] !== $nameoccupation || $currentValues['occupationdelete'] !== $occupationdelete) {
    $sql = "UPDATE occupation SET nameoccupation = :nameoccupation, occupationdelete = :occupationdelete WHERE codeoccupation = :codeoccupation";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nameoccupation' => $nameoccupation,
        ':occupationdelete' => $occupationdelete,
        ':codeoccupation' => $codeoccupation
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Occupación actualizada correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar la ocupación: ';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'info';
}

header('Location: ../../index.php?p=subviews/cargo');
exit();
?>

