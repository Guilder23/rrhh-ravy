<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codesection = isset($_POST['codesection']) ? intval($_POST['codesection']) : 0;
$namesection = isset($_POST['namesection']) ? trim($_POST['namesection']) : '';
$sectiondelete = isset($_POST['sectiondelete']) ? intval($_POST['sectiondelete']) : 0;

$sql = "SELECT namesection, sectiondelete FROM section WHERE codesection = :codesection";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codesection' => $codesection]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['namesection'] !== $namesection || $currentValues['sectiondelete'] !== $sectiondelete) {
    $sql = "UPDATE section SET namesection = :namesection, sectiondelete = :sectiondelete WHERE codesection = :codesection";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':namesection' => $namesection,
        ':sectiondelete' => $sectiondelete,
        ':codesection' => $codesection
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Section actualizada correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar la sección: ';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'info';
}

header('Location: ../../index.php?p=subviews/section');
exit();
?>
