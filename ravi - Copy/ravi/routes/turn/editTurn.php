<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codeturn = isset($_POST['codeturn']) ? intval($_POST['codeturn']) : 0;
$turnname = isset($_POST['turnname']) ? trim($_POST['turnname']) : '';
$turnstart = isset($_POST['turnstart']) ? trim($_POST['turnstart']) : '';
$turnend = isset($_POST['turnend']) ? trim($_POST['turnend']) : '';
$turndelete = isset($_POST['turndelete']) ? intval($_POST['turndelete']) : 0;


$sql = "SELECT turnname, turnstart, turnend, turndelete FROM turn WHERE codeturn = :codeturn";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codeturn' => $codeturn]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['turnname'] !== $turnname || 
    $currentValues['turnstart'] !== $turnstart || 
    $currentValues['turnend'] !== $turnend || 
    $currentValues['turndelete'] !== $turndelete) {

    $sql = "UPDATE turn SET 
            turnname = :turnname, 
            turnstart = :turnstart, 
            turnend = :turnend, 
            turndelete = :turndelete 
            WHERE codeturn = :codeturn";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':turnname' => $turnname,
        ':turnstart' => $turnstart,
        ':turnend' => $turnend,
        ':turndelete' => $turndelete,
        ':codeturn' => $codeturn
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Turno actualizado correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar el turno';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'info';
}

header('Location: ../../index.php?p=turnos');
exit();
?>