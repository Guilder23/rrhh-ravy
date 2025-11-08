<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codebond = isset($_POST['codebond']) ? intval($_POST['codebond']) : 0;
$bondcode = isset($_POST['bondcode']) ? trim($_POST['bondcode']) : '';
$bondreason = isset($_POST['bondreason']) ? trim($_POST['bondreason']) : '';
$bondvalue = isset($_POST['bondvalue']) ? floatval($_POST['bondvalue']) : 0.0;
$bondnro = isset($_POST['bondnro']) ? trim($_POST['bondnro']) : '';
$bondfee = isset($_POST['bondfee']) ? floatval($_POST['bondfee']) : 0.0;
$bondelete = isset($_POST['bondelete']) ? intval($_POST['bondelete']) : 0;

$sql = "SELECT bondcode, bondreason, bondvalue, bondnro, bondfee, bondelete FROM bond WHERE codebond = :codebond";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codebond' => $codebond]);
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentValues['bondcode'] !== $bondcode ||
    $currentValues['bondreason'] !== $bondreason ||
    $currentValues['bondvalue'] != $bondvalue || // Usar != para comparar valores decimales
    $currentValues['bondnro'] !== $bondnro ||
    $currentValues['bondfee'] != $bondfee || // Usar != para comparar valores decimales
    $currentValues['bondelete'] !== $bondelete) {

    $sql = "UPDATE bond 
            SET bondcode = :bondcode, 
                bondreason = :bondreason, 
                bondvalue = :bondvalue, 
                bondnro = :bondnro, 
                bondfee = :bondfee, 
                bondelete = :bondelete 
            WHERE codebond = :codebond";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':bondcode' => $bondcode,
        ':bondreason' => $bondreason,
        ':bondvalue' => $bondvalue,
        ':bondnro' => $bondnro,
        ':bondfee' => $bondfee,
        ':bondelete' => $bondelete,
        ':codebond' => $codebond
    ]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Bono actualizado correctamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al actualizar el bono';
        $_SESSION['message_type'] = 'error';
    }
} else {
    $_SESSION['message'] = 'No hay cambios para actualizar';
    $_SESSION['message_type'] = 'info';
}

header('Location: ../../index.php?p=subviews/bono');
exit();