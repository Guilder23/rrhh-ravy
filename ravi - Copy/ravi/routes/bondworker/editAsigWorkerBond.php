<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codebondw = isset($_POST['codebondw']) ? intval($_POST['codebondw']) : 0;
$codeworker = isset($_POST['codeworker']) ? intval($_POST['codeworker']) : 0;
$codebond = isset($_POST['codebondedit']) ? intval($_POST['codebondedit']) : 0;
$bondwdelete = isset($_POST['bondwdeleteedit']) ? intval($_POST['bondwdeleteedit']) : 0;

$sqlCheckBond = "SELECT codebond FROM bond WHERE codebond = :codebond";
$stmtCheckBond = $pdo->prepare($sqlCheckBond);
$stmtCheckBond->execute([':codebond' => $codebond]);
$bondExists = $stmtCheckBond->fetch(PDO::FETCH_ASSOC);

if (!$bondExists) {
    $_SESSION['message'] = 'El bono especificado no existe en la tabla `bond`';
    $_SESSION['message_type'] = 'error';
    header('Location: ../../index.php?p=asignacionbono');
    exit();
}

$sql = "SELECT codeworker, codebond, bondwdelete FROM bondw WHERE codebondw = :codebondw";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codebondw' => $codebondw]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['codeworker'] !== $codeworker || $currentValues['codebond'] !== $codebond || $currentValues['bondwdelete'] !== $bondwdelete) {
    $sql = "UPDATE bondw SET codeworker = :codeworker, codebond = :codebond, bondwdelete = :bondwdelete WHERE codebondw = :codebondw";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':codeworker' => $codeworker,
        ':codebond' => $codebond,
        ':bondwdelete' => $bondwdelete,
        ':codebondw' => $codebondw
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Asignación de bono actualizada correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar la asignación de bono';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'error';
}

header('Location: ../../index.php?p=subviews/bonotrabajador');
exit();